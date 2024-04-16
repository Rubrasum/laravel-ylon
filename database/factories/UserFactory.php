<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // encrypting the ssn
        $ssn = fake()->numerify('#########');
        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $first_encrypted = openssl_encrypt($ssn,$method, env('APP_BC_K'), OPENSSL_RAW_DATA ,$iv);
        $second_encrypted = hash_hmac('sha3-512', env('APP_BC_K'), env('APP_BC_KT'), TRUE);

        $ssn = base64_encode($iv.$second_encrypted.$first_encrypted);

        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'social_security' => $ssn,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
