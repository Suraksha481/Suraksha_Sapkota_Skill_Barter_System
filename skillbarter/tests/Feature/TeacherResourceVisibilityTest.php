<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\RequestModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeacherResourceVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_profile_shows_resources_to_owner()
    {
        Storage::fake('public');

        $teacher = User::factory()->create(['role' => 'teacher', 'is_teacher_approved' => true]);

        // create a fake resource
        $file = UploadedFile::fake()->create('doc.pdf', 100);
        $path = $file->store('resources', 'public');
        $resource = Resource::create([
            'user_id' => $teacher->id,
            'title' => 'Test doc',
            'file_path' => $path,
            'filename' => 'doc.pdf',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        $response = $this->actingAs($teacher)->get(route('teachers.show', $teacher));
        $response->assertOk();
        $response->assertSee('Test doc');

        // download link working
        $response = $this->actingAs($teacher)->get(route('teacher.resources.download', $resource));
        $response->assertOk();
    }

    public function test_accepted_student_can_see_and_download_resources()
    {
        Storage::fake('public');

        $teacher = User::factory()->create(['role' => 'teacher', 'is_teacher_approved' => true]);
        $student = User::factory()->create(['role' => 'student']);

        $resource = Resource::create([
            'user_id' => $teacher->id,
            'title' => 'Shared file',
            'file_path' => 'resources/fake.pdf',
            'filename' => 'fake.pdf',
            'mime' => 'application/pdf',
            'size' => 10,
        ]);

        RequestModel::create([
            'requester_id' => $student->id,
            'responder_id' => $teacher->id,
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($student)->get(route('teachers.show', $teacher));
        $response->assertOk();
        $response->assertSee('Shared file');

        $response = $this->actingAs($student)->get(route('teacher.resources.download', $resource));
        $response->assertOk();
    }

    public function test_unaccepted_student_cannot_view_or_download_resources()
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'is_teacher_approved' => true]);
        $student = User::factory()->create(['role' => 'student']);

        $resource = Resource::create([
            'user_id' => $teacher->id,
            'title' => 'Secret file',
            'file_path' => 'resources/secret.pdf',
            'filename' => 'secret.pdf',
            'mime' => 'application/pdf',
            'size' => 10,
        ]);

        $response = $this->actingAs($student)->get(route('teachers.show', $teacher));
        $response->assertOk();
        $response->assertDontSee('Secret file');
        $response->assertSee('You need to be accepted');

        $response = $this->actingAs($student)->get(route('teacher.resources.download', $resource));
        $response->assertStatus(403);
    }
}
