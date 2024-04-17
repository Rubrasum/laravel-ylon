<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function toggleStatus(User $user)
    {
        $user->update([
            'admin' => !$user->admin
        ]);

        return back()->with('success', 'User status updated successfully.');
    }
}
