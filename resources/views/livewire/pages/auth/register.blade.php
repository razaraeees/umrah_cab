<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    Auth::login($user);

    return redirect()->route('dashboard');
};

?>

<div>
    <h4 class="font-size-18 text-muted mt-2 text-center mb-4">Sign Up</h4>
    <p class="text-muted text-center mb-4">Sign up to continue to {{ config('app.name', 'Laravel') }}.</p>

    <form class="form-horizontal" wire:submit="register">
        <!-- Name -->
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" placeholder="Enter name" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" placeholder="Enter email" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label" for="password">{{ __('Password') }}</label>
            <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" placeholder="Enter password" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input wire:model="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                   id="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 row mt-4">
            <div class="col-12 text-end">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                    {{ __('Register') }}
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="text-center plan-line">
                    or sign up with
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="button-list btn-social-icon text-center">
                <button type="button" class="btn btn-facebook">
                    <i class="fab fa-facebook"></i>
                </button>
                <button type="button" class="btn btn-twitter ms-1">
                    <i class="fab fa-twitter"></i>
                </button>
                <button type="button" class="btn btn-linkedin ms-1">
                    <i class="fab fa-linkedin"></i>
                </button>
            </div>
        </div>
    </form>
</div>
