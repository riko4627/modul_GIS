<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>

            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-plus"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('streetfood*') ? 'active' : '' }}">
                    <a href="{{ url('/streetfood') }}">
                        <i class="fas fa-hamburger"></i> <!-- Burger -->
                        <p>Streetfood</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
