<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function toggleStatus(User $user)
    {
        $success = $user->update([
            'enabled' => !$user->enabled
        ]);

        return back()->with('success', $success ? 'User status updated!' : 'Failed to update user status');
    }
}
