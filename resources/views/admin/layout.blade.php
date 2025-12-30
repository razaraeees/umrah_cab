<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Upbond - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @livewireStyles

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        @include('admin.partials.header')


        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.partials.sidebar')

        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')
            <!-- End Page-content -->

            @include('admin.partials.footer')


        </div>
        <!-- end main content-->
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if (request()->routeIs('dashboard') || request()->routeIs('admin.dashboard'))
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
    @endif

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @vite(['resources/js/app.js'])
    <script>
        window.addEventListener('show-toast', event => {
            console.log("EVENT:", event.detail); // Optional for debugging

            Swal.fire({
                toast: true,
                icon: event.detail.type,
                title: event.detail.message,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false,
                customClass: {
                    popup: 'custom-toast',
                    title: 'custom-toast-title'
                }
            });

        });
    </script>

    <style>
        .custom-toast {
            width: 300px !important;
            font-size: 16px !important;
            padding: 10px !important;

        }

        .custom-toast-title {
            font-size: 16px !important;
            font-weight: 500 !important;
            margin: 0 !important;
            padding: 10px !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '{{ session('success') }}',
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'custom-toast',
                        title: 'custom-toast-title'
                    }
                });
            @endif
        });
    </script>
    <script>
        // Simple function to handle copy
        function copyBookingText(bookingId, type, button) {
            const originalText = button.innerHTML;

            // Call Livewire method
            Livewire.dispatch('copy-booking', {
                bookingId: bookingId,
                type: type
            });

            // Give visual feedback
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Copying...';
            button.disabled = true;
        }

        // Listen for Livewire events
        document.addEventListener('livewire:init', () => {
            Livewire.on('copy-booking', async (data) => {
                try {
                    // Get the data - handle both array and object
                    const params = Array.isArray(data) ? data[0] : data;

                    // Call Livewire component to prepare text
                    await Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).call('prepareCopyText', params.bookingId, params.type);

                } catch (err) {
                    console.error('Error:', err);
                }
            });

            Livewire.on('do-copy-now', async () => {
                try {
                    // Get text from backend
                    const response = await fetch('{{ route('get-clipboard-text') }}');
                    const data = await response.json();

                    if (data.text) {
                        // Try clipboard API first
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(data.text);
                        } else {
                            // Fallback for non-HTTPS
                            const textArea = document.createElement('textarea');
                            textArea.value = data.text;
                            textArea.style.position = 'fixed';
                            textArea.style.left = '-999999px';
                            document.body.appendChild(textArea);
                            textArea.select();
                            document.execCommand('copy');
                            document.body.removeChild(textArea);
                        }

                        // Success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied!',
                            text: 'Text copied to clipboard',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Re-enable buttons
                        document.querySelectorAll('.dropdown-item[disabled]').forEach(btn => {
                            btn.disabled = false;
                            btn.innerHTML = btn.innerHTML.replace(
                                '<i class="fas fa-spinner fa-spin me-2"></i>Copying...',
                                btn.textContent.includes('Driver') ?
                                '<i class="fas fa-car me-2"></i>Copy for Driver' :
                                '<i class="fas fa-user me-2"></i>Copy for Customer'
                            );
                        });
                    }
                } catch (err) {
                    console.error('Copy failed:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Could not copy text',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

            Livewire.on('copy-error', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to prepare text',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    </script>

    @livewireScripts

</body>

</html>
