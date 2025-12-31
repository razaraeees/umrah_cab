<?php

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['email' => '']);

rules(['email' => ['required', 'string', 'email']]);

$sendPasswordResetLink = function () {
    $this->validate();

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink(
        $this->only('email')
    );

    if ($status != Password::RESET_LINK_SENT) {
        $this->addError('email', __($status));

        return;
    }

    $this->reset('email');

    Session::flash('status', __($status));
};

?>

<div>
    <h4 class="font-size-18 text-muted mt-2 text-center mb-4">Reset Password</h4>
    <div class="alert alert-info" role="alert">
        Enter your Email and instructions will be sent to you!
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="form-horizontal" wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" placeholder="Enter email" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 row mt-4">
            <div class="col-12 text-end">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                    {{ __('Sent Reset Password') }}
                </button>
            </div>
        </div>

    </form>
</div>
