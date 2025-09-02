<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if (!URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            // Log the user in if they're already verified
            Auth::login($user, true);
            session()->save();
            DB::commit();
            return redirect()->intended(route('admin.dashboard', absolute: false) . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Assign default "user" role if user doesn't have a role yet
        if (!$user->role_id) {
            $userRole = \App\Models\Role::where('name', 'user')->first();
            if ($userRole) {
                $user->update(['role_id' => $userRole->id]);
            }
        }

        // Refresh the user to ensure the verification and role are saved
        $user->refresh();

        // Log the user in automatically after verification
        Auth::login($user, true); // Remember the user

        // Ensure session is saved and committed before redirect
        session()->save();

        // Force database transaction commit
        DB::commit();

        return redirect()->intended(route('admin.dashboard', absolute: false) . '?verified=1');
    }
}