<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();
    session()->flash('success', 'Logged in successfully.');

    return redirect()->route('dashboard');

};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- <h4 class="font-size-18 text-muted mt-2 text-center">Welcome Back !</h4> --}}
    <p class="text-muted text-center mb-4">Sign in to continue to {{ config('app.name', 'Laravel') }}.</p>

    <form class="form-horizontal" wire:submit="login">
        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('E-mail Address') }}</label>
            <input wire:model="form.email" type="text" class="form-control @error('form.email') is-invalid @enderror" 
                   id="email" placeholder="Enter email" required autofocus autocomplete="username">
            @error('form.email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label" for="password">{{ __('Password') }}</label>
            <input wire:model="form.password" type="password" class="form-control @error('form.password') is-invalid @enderror" 
                   id="password" placeholder="Enter password" required autocomplete="current-password">
            @error('form.password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 row mt-4">
            <div class="col-sm-6">
                    <input wire:model="form.remember" type="checkbox" class="form-check-input me-1" id="remember" name="remember">
                    <label class="form-label form-check-label" for="remember">{{ __('Remember me') }}</label>
            </div>
            <div class="col-sm-6 text-end">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-muted" wire:navigate>
                        <i class="mdi mdi-lock"></i> {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 text-center">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                    {{ __('Log In') }}
                </button>
            </div>
        </div>
        
    </form>
</div>
