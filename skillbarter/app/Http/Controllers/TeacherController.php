<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // List all teachers with basic filters
   public function index()
    {
        $query = User::where('role', 'teacher')
            ->where('is_teacher_approved', true)
            ->where('is_active', true);

        // apply name/skill search when a query parameter is provided
        if ($search = request('q')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('userSkills.skill', function($q2) use ($search) {
                      $q2->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // apply category filter
        if ($category = request('category')) {
            $query->whereHas('userSkills.skill', function($q) use ($category) {
                $q->where('category', $category);
            });
        }

        // Add average rating and review count
        $teachers = $query->with('userSkills.skill')
            ->withCount(['receivedFeedback as reviews_count' => function ($q) {
                $q->whereNotNull('rating');
            }])
            ->withAvg('receivedFeedback as average_rating', 'rating')
            ->paginate(10);

        // Fetch categories for the dropdown
        $categories = \App\Models\Skill::whereNotNull('category')->distinct()->pluck('category');

        // return view with teachers collection (include query string for pagination)
        return view('teacher.index', [
            'teachers' => $teachers->withQueryString(),
            'categories' => $categories
        ]);
    }

    public function show(User $teacher)
    {
        // We allow viewing any user profile that is active, 
        // especially for matching purposes between teachers and students.
        if (!$teacher->is_active) {
            abort(404);
        }

        // eager load skills for profile display
        $teacher->load(['userSkills.skill']);

        // Load feedback/reviews
        $reviews = \App\Models\Feedback::where('target_type', 'user')
            ->where('target_id', $teacher->id)
            ->whereNotNull('rating')
            ->with('author')
            ->latest()
            ->get();

        $averageRating = $reviews->avg('rating');
        $reviewsCount = $reviews->count();

        $resources = collect();
        $canViewResources = false;
        $user = auth()->user();

        // owner may always view their own resources
        if ($user && $user->id === $teacher->id) {
            $canViewResources = true;
            $resources = $teacher->resources()->latest()->get();
        }

        // students who have an accepted request can view resources
        $isPremium = false;
        if (! $canViewResources && $user && $user->isStudent()) {
            $isPremium = $user->isPremium();
            $accepted = \App\Models\RequestModel::where('responder_id', $teacher->id)
                ->where('requester_id', $user->id)
                ->where('status', 'accepted')
                ->exists();

            if ($accepted) {
                if ($isPremium) {
                    $canViewResources = true;
                    $resources = $teacher->resources()->latest()->get();
                } else {
                    $canViewResources = 'premium_required';
                }
            }
        }

        return view('teacher.show', compact('teacher', 'resources', 'canViewResources', 'reviews', 'averageRating', 'reviewsCount'));
    }
}
