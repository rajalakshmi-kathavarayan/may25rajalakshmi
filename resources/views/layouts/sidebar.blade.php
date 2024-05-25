<div class="sidebar">
    <div class="logo-details">
        <i class='bx bxl-c-plus-plus'></i>
        <span class="logo_name">SMS</span>
    </div>
    <ul class="nav-links ps-0">
        <li>
            <a href="/student" >
                <i class='"bi bi-people-fill'></i>
                <span class="links_name">Students</span>
            </a>
        </li>


        <li class="log_out">
            <a href="/">
                <i class='bi bi-box-arrow-left'></i>
                <span class="links_name">Log out</span>
            </a>
        </li>
    </ul>
</div>
<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Student <span class="primary-text">Crud</span></span>
        </div>
        <div class="profile-details d-flex align-items-center">
            <div class="dropdown">
                <button class="btn " type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='fa fa-user align-self-center primary-text'></i>
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="bg-secondary d-flex align-items-center">
                        <i class="fa-solid fa-circle-user text-white ms-2 fs-2"></i>
                        <span class="dropdown-item-text text-white fw-bold">{{ Auth::user()->name }}
                            <span class="d-block">{{ Auth::user()->email }}</span>
                        </span>
                    </div>

                </div>
            </div>
            <div>
                @auth
                    <div><span class="user-name">{{ Auth::user()->name }}</span></div>
                    @if (Auth::user()->role)
                        <div><span class="role-name title-text small">{{ Auth::user()->role->name }}</span>
                    @endif
                @endauth
            </div>
        </div>
    </nav>
    <div class="home-content">
        <div>
            @yield('content')
        </div>
    </div>
</section>

@vite(['resources/js/sidebar.js'])
