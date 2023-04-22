<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::query()->findOrFail($request->id);

        if ($user->hasVerifiedEmail()) {
            return Redirect::to(config('app.frontend_url').'/login');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return Redirect::to(config('app.frontend_url').'/login');
    }
}
