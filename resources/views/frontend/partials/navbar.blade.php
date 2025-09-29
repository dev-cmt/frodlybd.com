<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <!-- Logo Left -->
        <a class="navbar-brand me-auto" href="https://frodlybd.com">
            <img src="{{ asset('images/logo-light.svg') }}" alt="Frodly Logo" height="40" class="logo-light">
            <img src="{{ asset('images/logo-dark.svg') }}" alt="Frodly Logo Dark" height="40" class="logo-dark">
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <div class="navbar-toggler-icon-custom">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <!-- Menu & Buttons -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu Center -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>

            <!-- Buttons Right -->
            <div class="d-flex align-items-center navbar-buttons">
                <!-- Dark Mode Toggle -->
                <input type="checkbox" id="dark-mode-toggle-checkbox" class="d-none">
                <label for="dark-mode-toggle-checkbox" class="dark-mode-toggle-label me-3" aria-label="Toggle Dark Mode">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </label>

                <!-- Login / Signup -->
                @guest
                    <a href="{{route('login')}}" class="btn btn-outline-warning me-2">Login</a>
                    <a href="{{route('register')}}" class="btn btn-warning">Signup</a>
                @else
                    <a href="{{route('dashboard')}}" class="btn btn-outline-warning me-2">{{ Auth::user()->name }}</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-warning">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
