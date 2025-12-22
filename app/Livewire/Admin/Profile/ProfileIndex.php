<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads;

class ProfileIndex extends Component
{
    use WithFileUploads;
    
    public $name;
    public $email;
    public $phone;
    public $location;
    public $bio;
    public $avatar;
    
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $showPasswordSection = false;

    protected $rules = [
        'avatar' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->location = $user->location ?? '';
        $this->bio = $user->bio ?? '';
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg'],
        ]);

        $user = Auth::user();
        
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'bio' => $this->bio,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('profile-images', 'public');
            $updateData['avatar'] = $path;
            
            // Dispatch event to update avatar in header
            $this->dispatch('profile-updated', [
                'avatar' => asset('storage/' . $path),
                'name' => $this->name
            ]);
        }

        $user->update($updateData);

        $this->dispatch('show-toast', type: 'success', message: 'Profile updated successfully!');
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showPasswordSection = false; // Close the section after successful change
        $this->dispatch('show-toast', type: 'success', message: 'Password changed successfully!');
    }

    public function togglePasswordSection()
    {
        $this->showPasswordSection = !$this->showPasswordSection;
    }
    
    public function closePasswordSection()
    {
        $this->showPasswordSection = false;
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }
    
    public function render()
    {
        return view('livewire.admin.profile.profile-index');
    }
}
