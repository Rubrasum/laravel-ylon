<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    // Display the form
    public function index()
    {
        return view('forms.new-people');
    }

    // Process the form submission with maxes
    public function submit(Request $request)
    {
        // Validation
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            // Add regex validation for social_security field
            'social_security' => 'required|regex:/^\d{3}-?\d{2}-?\d{4}$/'
        ]);

        // convert social security to a string without dashes
        $social_security = preg_replace('/[^0-9]/', '', $request->social_security);
        // encrypting the ssn
        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $first_encrypted = openssl_encrypt($social_security ,$method, env('APP_BC_K'), OPENSSL_RAW_DATA ,$iv);
        $second_encrypted = hash_hmac('sha3-512', env('APP_BC_K'), env('APP_BC_KT'), TRUE);

        $ssn = base64_encode($iv.$second_encrypted.$first_encrypted);

        dd($request->all());

        // Ok now make a new user
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->social_security = $ssn;
        $user->save();

        return redirect('/')->with('success', 'User created!');
    }
}
