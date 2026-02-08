<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store contact form submission
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        try {
            // Send email to admin
            Mail::raw(
                "Name: {$validated['name']}\n" .
                "Email: {$validated['email']}\n\n" .
                "Message:\n{$validated['message']}",
                function ($message) use ($validated) {
                    $message->to(config('mail.from.address'))
                        ->subject("New Contact Form: {$validated['subject']}")
                        ->from($validated['email'], $validated['name']);
                }
            );

            // Optional: Send confirmation email to user
            Mail::raw(
                "Dear {$validated['name']},\n\n" .
                "Thank you for contacting SkillBarter!\n\n" .
                "We have received your message and will get back to you as soon as possible.\n\n" .
                "Best regards,\nSkillBarter Team",
                function ($message) use ($validated) {
                    $message->to($validated['email'])
                        ->subject('We received your message - SkillBarter')
                        ->from(config('mail.from.address'), 'SkillBarter Support');
                }
            );

            return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');
        } catch (\Exception $e) {
            return redirect()->route('contact')->with('error', 'Failed to send message. Please try again later.');
        }
    }
}
