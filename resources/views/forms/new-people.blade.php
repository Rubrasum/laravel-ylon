@extends('layout.full')

@section('content')
<main>
    <form method="POST" action="/">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="firstname" :value="__('First Name')" />
            <x-text-input id="firstname" class="block mt-1 w-full text-black" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" class="block mt-1 w-full text-black" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-black" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Social Security -->
        <div class="mt-4">
            <x-input-label for="social_security" :value="__('Social Security Number')" />
            <x-text-input id="social_security" class="block mt-1 w-full text-black" type="text" name="social_security" :value="old('social_security')" required autocomplete="off" pattern="\d{3}-?\d{2}-?\d{4}" />
            <x-input-error :messages="$errors->get('social_security')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-4 mb-4">

            <x-primary-button class="ms-4">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</main>

@endsection
