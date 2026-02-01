<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Grant lifetime access to a user
     */
    public function grantLifetime(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->user_email)->first();

        if (!$user) {
            return redirect()->back()->with('access_error', 'User not found with email: ' . $request->user_email);
        }

        if ($user->role !== 'student') {
            return redirect()->back()->with('access_error', 'Only students can receive lifetime access.');
        }

        // Check if user already has lifetime access
        if ($user->has_lifetime_access) {
            return redirect()->back()->with('access_error', "{$user->name} ({$user->email}) already has lifetime access!");
        }

        // Grant lifetime access
        $user->update(['has_lifetime_access' => true]);

        return redirect()->back()->with('access_message',
            "🎉 Lifetime access granted to {$user->name} ({$user->email})!");
    }
}
