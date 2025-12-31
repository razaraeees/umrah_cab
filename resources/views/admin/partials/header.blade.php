<header id="page-topbar">          
    <div class="navbar-header">
        <!-- LEFT SIDE: Logo & Menu Button -->
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/Copilot_20251231_205328.png') }}" alt="logo-sm-dark" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/Copilot_20251231_205328.png') }}" alt="logo-dark" height="22">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm-light.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg text-white font-size-26" style="font-weight: bolder">
                        UMRAH CAB
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>
        </div>

        <!-- RIGHT SIDE: All Icons -->
        <div class="d-flex align-items-center">
            <!-- Fullscreen Button -->
            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <div class="top-icon">
                        <i class="mdi mdi-fullscreen"></i>
                    </div>
                </button>
            </div>
            <!-- end Fullscreen -->


            <!-- User Profile Dropdown -->
            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/images/users/avatar-7.jpg') }}"
                        alt="Header Avatar" style="height: 36px; width: 36px; object-fit: cover; border-radius: 50%;">
                    <span class="d-none d-xl-inline-block ms-1">{{ auth()->user()->name ?? 'Admin User' }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="ri-user-line align-middle me-1"></i>
                        Profile</a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger p-0 border-0 bg-transparent">
                            <i class="ri-shut-down-line align-middle me-1 text-danger"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <!-- end user -->
        </div>
    </div>
</header>

<script>
// Listen for profile update events
document.addEventListener('livewire:init', () => {
    Livewire.on('profile-updated', (event) => {
        // Extract data from event (Livewire v3 passes data as array)
        const data = Array.isArray(event) ? event[0] : event;
        
        // Update header profile image
        const headerAvatar = document.querySelector('.header-profile-user');
        if (headerAvatar && data.avatar) {
            headerAvatar.src = data.avatar;
        }
        
        // Update header profile name
        const headerName = document.querySelector('.user-dropdown .d-none.d-xl-inline-block.ms-1');
        if (headerName && data.name) {
            headerName.textContent = data.name;
        }
    });
});
</script>