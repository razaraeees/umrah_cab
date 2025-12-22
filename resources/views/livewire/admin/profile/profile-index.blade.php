<div>
    <div class="page-content">
        <div class="container-fluid">
            
             <livewire:admin.components.breadcrumbs title="Profile Details" bredcrumb1="Profile Settings"
                bredcrumb2="Profile detail" />

            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-user-box">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                    @if($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}"
                                            class="rounded-circle img-thumbnail" alt="user-profile-img" style="width: 200px; height: 200px; object-fit: cover;">
                                    @else
                                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/images/users/avatar-7.jpg') }}"
                                            class="rounded-circle img-thumbnail" alt="user-profile-img" style="width: 200px; height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="position-absolute bottom-0 start-0 m-2">
                                        <input type="file" class="d-none" id="profile-img-file-input" 
                                            accept="image/*" wire:model="avatar">
                                        <label for="profile-img-file-input" class="avatar-xs rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                            style="cursor: pointer; width: 32px; height: 32px;">
                                            <i class="ri-camera-line"></i>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="font-size-18 fw-semibold text-dark mb-1">{{ auth()->user()->name ?? 'Admin User' }}</h5>
                                <p class="text-muted mb-0">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4" x-data="{ showPasswordSection: @entangle('showPasswordSection') }">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="ri-shield-keyhole-line align-bottom me-2"></i>Security Settings
                                    </h5>
                                    <p class="text-muted mb-0 small">Manage your password and security preferences</p>
                                </div>
                                <button class="btn btn-soft-primary btn-sm" type="button" @click="showPasswordSection = !showPasswordSection">
                                    <i class="ri-arrow-down-s-line" x-show="!showPasswordSection"></i>
                                    <i class="ri-arrow-up-s-line" x-show="showPasswordSection"></i>
                                    <span x-show="!showPasswordSection">Change Password</span>
                                    <span x-show="showPasswordSection">Hide Password</span>
                            </button>
                            </div>

                            <div x-show="showPasswordSection" 
                                 x-transition:enter="transition ease-out duration-500"
                                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                                 class="border-top pt-4 mt-4">
                                <form wire:submit="changePassword">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" for="current_password">
                                                    Current Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control" id="current_password"
                                                    wire:model="current_password"
                                                    placeholder="Enter your current password">
                                                @error('current_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" for="new_password">
                                                    New Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control" id="new_password"
                                                    wire:model="new_password" placeholder="Enter new password">
                                                @error('new_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" for="new_password_confirmation">
                                                    Confirm Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control"
                                                    id="new_password_confirmation" wire:model="new_password_confirmation"
                                                    placeholder="Confirm your new password">
                                                @error('new_password_confirmation')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-soft-secondary me-2" @click="showPasswordSection = false; $wire.reset(['current_password', 'new_password', 'new_password_confirmation'])">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="ri-lock-password-line align-bottom me-1"></i> Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-user-settings-line align-bottom me-2"></i>Edit Profile
                                    </h5>
                                </div>
                            </div>

                            <form wire:submit="updateProfile">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="name">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="name"
                                                wire:model="name" placeholder="Enter your full name">
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="email">
                                                Email Address <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" id="email"
                                                wire:model="email" placeholder="Enter email address">
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="phone">Phone Number</label>
                                            <input type="tel" class="form-control" id="phone"
                                                wire:model="phone" placeholder="Enter phone number">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="location">Location</label>
                                            <input type="text" class="form-control" id="location"
                                                wire:model="location" placeholder="Enter your location">
                                            @error('location')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="bio">About Me</label>
                                    <textarea class="form-control" id="bio" wire:model="bio" rows="4"
                                        placeholder="Write something about yourself..."></textarea>
                                    @error('bio')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="ri-save-line align-bottom me-1"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- <!-- Security Settings Card -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="ri-shield-keyhole-line align-bottom me-2"></i>Security Settings
                                    </h5>
                                    <p class="text-muted mb-0 small">Manage your password and security preferences</p>
                                </div>
                                <button class="btn btn-soft-primary btn-sm" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#passwordSection" 
                                    aria-expanded="false" aria-controls="passwordSection">
                                    <i class="ri-arrow-down-s-line"></i> Change Password
                                </button>
                            </div>

                            <div class="collapse mt-4" id="passwordSection">
                                <hr class="mb-4">
                                <form wire:submit="changePassword">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" for="current_password">
                                                    Current Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control" id="current_password"
                                                    wire:model="current_password"
                                                    placeholder="Enter your current password">
                                                @error('current_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" for="new_password">
                                                    New Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control" id="new_password"
                                                    wire:model="new_password" placeholder="Enter new password">
                                                @error('new_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" for="password_confirmation">
                                                    Confirm Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control"
                                                    id="password_confirmation" wire:model="password_confirmation"
                                                    placeholder="Confirm your new password">
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-soft-secondary me-2" 
                                            data-bs-toggle="collapse" data-bs-target="#passwordSection">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="ri-lock-password-line align-bottom me-1"></i> Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Loading indicator for image upload --}}
    <div wire:loading wire:target="avatar" 
         class="position-fixed top-50 start-50 translate-middle" 
         style="z-index: 9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>