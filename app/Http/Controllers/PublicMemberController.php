<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PublicMemberController extends Controller
{
    /**
     * Show the public member registration form.
     */
    public function create()
    {
        // Get slideshow images for the background
        $slideshowAlbum = Album::where('name', 'slideshow')
            ->where('is_public', true)
            ->first();

        $slideshowImages = collect();
        if ($slideshowAlbum) {
            $slideshowImages = $slideshowAlbum->media()
                ->where('type', 'photo')
                ->where('is_public', true)
                ->orderBy('sort_order', 'asc')
                ->limit(6) // Limit to 6 images for performance
                ->get();
        }

        return view('public.member-register', compact('slideshowImages'));
    }

    /**
     * Handle the public member registration.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('members', 'email')
            ],
            'country_code' => 'required|string|in:+250,+1,+44,+33,+49,+86,+91,+234,+254,+256,+255,+27',
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]{7,15}$/',
            ],
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'country_code.required' => 'Country code is required.',
            'country_code.in' => 'Please select a valid country code.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid phone number (7-15 digits).',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Combine country code with phone number
        $fullPhoneNumber = $request->country_code . $request->phone;

        // Check if the full phone number is already registered
        if (Member::where('phone', $fullPhoneNumber)->exists()) {
            return redirect()->back()
                ->withErrors(['phone' => 'This phone number is already registered.'])
                ->withInput();
        }

        // Create the member as a general member
        $member = Member::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $fullPhoneNumber,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'type' => 'general', // Always general for public registration
            'join_date' => now()->toDateString(),
            'is_active' => true,
        ]);

        // Send welcome notification
        $this->sendWelcomeNotification($member);

        return redirect()->route('public.member-register')
            ->with('success', 'Thank you for registering! Welcome to The Harmony Singers Choir. You will receive a welcome notification shortly.');
    }

    /**
     * Send welcome notification to the new member.
     */
    private function sendWelcomeNotification(Member $member)
    {
        try {
            $member->notify(new \App\Notifications\MemberRegisteredNotification($member));
        } catch (\Exception $e) {
            // Log the error but don't fail the registration
            Log::error('Failed to send welcome notification to member: ' . $member->id, [
                'error' => $e->getMessage()
            ]);
        }
    }
}
