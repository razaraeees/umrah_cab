<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state('token')->locked();

state([
    'email' => fn () => request()->string('email')->value(),
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'token' => ['required'],
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$resetPassword = function () {
    $this->validate();

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $status = Password::reset(
        $this->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) {
            $user->forceFill([
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    if ($status != Password::PASSWORD_RESET) {
        $this->addError('email', __($status));

        return;
    }

    Session::flash('status', __($status));

    $this->redirectRoute('login', navigate: true);
};

?>

<div>
    <h4 class="font-size-18 text-muted mt-2 text-center mb-4">Reset Password</h4>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="form-horizontal" wire:submit="resetPassword">
        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" placeholder="Enter email" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" placeholder="New password" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <input wire:model="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                   id="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 row mt-4">
            <div class="col-12 text-end">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                    {{ __('Save Password') }}
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
