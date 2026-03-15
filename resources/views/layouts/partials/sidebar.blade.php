<div class="app-sidebar">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="{{ route('dashboard') }}" class="logo-dark">
            <img src="/images/msi.png" class="logo-sm" alt="logo sm">
            <img src="/images/msi.png" class="logo-lg" alt="logo dark" style="width: 150px; height: 75px;">
        </a>

        <a href="{{ route('dashboard') }}" class="logo-light">
            <img src="/images/msi.png" class="logo-sm" alt="logo sm">
            <img src="/images/msi.png" class="logo-lg" alt="logo light" style="width: 150px; height: 75px;">
        </a>
    </div>

    <div class="scrollbar" data-simplebar>

        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Menu...</li>

            {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('any', 'index') }}">
                         <span class="nav-icon">
                                      <iconify-icon icon="solar:user-circle-outline"></iconify-icon>
                         </span>
                         <span class="nav-text"> Admin </span>
                      

                         
                    </a>
               </li> --}}

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarAdmin" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarAdmin">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:user-circle-outline"></iconify-icon>
                    </span>
                    <span class="nav-text"> Admin</span>
                </a>
                <div class="collapse" id="sidebarAdmin">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('second', ['admin', 'create']) }}">Create</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.users.index') }}">View </a>
                        </li>


                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarEmployees" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ request()->routeIs('admin.employees.*') ? 'true' : 'false' }}"
                    aria-controls="sidebarEmployees">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:users-group-rounded-outline"></iconify-icon>
                    </span>
                    <span class="nav-text"> Employees</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.employees.*') ? 'show' : '' }}" id="sidebarEmployees">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.employees.create') }}">Create</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.employees.index') }}">View</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarDonations" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ request()->routeIs('admin.donations.*') ? 'true' : 'false' }}"
                    aria-controls="sidebarDonations">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:hand-heart-outline"></iconify-icon>

                    </span>
                    <span class="nav-text"> Donations</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.donations.*') ? 'show' : '' }}" id="sidebarDonations">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.donations.create') }}">Create</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.donations.index') }}">View</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarReports" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }}"
                    aria-controls="sidebarReports">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chart-square-outline"></iconify-icon>
                    </span>
                    <span class="nav-text"> Reports</span>
                </a>

                <div class="collapse {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}" id="sidebarReports">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.reports.donation.detailed') }}">Donation
                                Detailed</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link"
                                href="{{ route('admin.reports.employee.donation.summary') }}">Employee Donation
                                Summary</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link"
                                href="{{ route('admin.reports.donation.type.summary') }}">Donation Type Summary</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('admin.reports.employee.master') }}">Employee
                                Master</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.profile.edit') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-2-outline"></iconify-icon>
                    </span>
                    <span class="nav-text"> Profile </span>

                </a>
            </li>


        </ul>
    </div>
</div>
