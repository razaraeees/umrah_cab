<div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>

                    <li>
                        <a href="{{ route('dashboard') }}" class="waves-effect">
                            <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-store-2-line"></i>
                            <span>Booking Manage</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('pickup.index') }}">Pick Up</a></li>
                            <li><a href="{{ route('drop-off.index') }}">Drop Off</a></li>
                            <li><a href="{{ route('routefares.index') }}">Routes And Fares</a></li>
                            <li><a href="{{ route('cities.index') }}">Cities</a></li>
                            <li><a href="{{ route('hotel.index') }}">Hotels</a></li>
                            <li><a href="{{ route('booking.index') }}">Bookings</a></li>
                            <li><a href="{{ route('additional.index') }}">Additional Service</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-car-line"></i>
                            <span>Cars & Driver</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('driver-detail.index') }}">Drivers</a></li>
                            <li><a href="{{ route('car-detail.index') }}">Cars Details</a></li>
                        </ul>
                    </li>
                    <!-- end li -->
                    <li>
                        <a href="apps-kanban-board.html" class=" waves-effect">
                            <i class="ri-artboard-2-line"></i>
                            <span>Kanban Board</span>
                        </a>
                    </li>
                    <!-- end li -->
                    <li class="menu-title">Pages</li>

                    <li>
                        <a href="{{ route('profile') }}" class="waves-effect">
                            <i class="ri-account-circle-line"></i>
                            <span>Profile Setting</span>
                        </a>
                    </li>
                </ul>
                <!-- end ul -->
            </div>
            <!-- Sidebar -->
        </div>
    </div>