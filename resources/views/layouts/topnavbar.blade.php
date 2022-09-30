<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
            @if(Route::is('login'))
            <a class="navbar-brand" href="{{ Route('landing') }}">{{ config('app.name', 'Laravel') }}</a>
            @else
            <button class="btn btn-primary" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
            @endif
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if(Route::has('student.login'))
                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('student.login') }}">{{ __('Student Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('login'))
                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">{{ __('Admin/Food Seller Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @can('isAdmin')
                                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                          <i class="fa-solid fa-user"></i> {{ __('Profile') }}
                                    </a>
                                    @endcan

                                    @can('isFoodSeller')
                                    <a class="dropdown-item" href="{{ route('food_seller.profile') }}">
                                          <i class="fa-solid fa-user"></i> {{ __('Profile') }}
                                    </a>
                                    @endcan

                                    <hr class="dropdown-divider">

                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                          <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    {{--
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                    --}}
                              </div>
                        </li>
                        @endguest
                  </ul>
            </div>
      </div>
</nav>