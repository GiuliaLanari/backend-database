<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use App\Models\User;


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url').'/email-verify'
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(
            config('app.frontend_url').'/email-verify'
        );
    }

    // public function __invoke(Request $request): array
    // {
    //     $user = $request->user();

    //     if ($user->hasVerifiedEmail()) {
    //         return ['message' => 'already_verified'];
    //     }

    //     if ($user->markEmailAsVerified()) {
    //         event(new Verified($user));
    //         return ['message' => 'verified'];
    //     }

    //     return ['message' => 'verification_failed'];
    // }

}
