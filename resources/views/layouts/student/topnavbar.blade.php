<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
            <a class="navbar-brand" href="{{ Route('landing') }}">{{ config('app.name', 'Laravel') }}</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Left Side Of Navbar -->
                  <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                              <a id="InformationBarDropdown" class="nav-link" href="{{ Route('student.menus') }}">Menu</a>
                        </li>
                        @if(\App\Models\InformationPageDesign::all()->count() !== 0)
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Information
                              </a>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="InformationBarDropdown">
                                    @foreach(\App\Models\InformationPageDesign::all() as $info)
                                    <a class="dropdown-item" href="{{ route('landing.information', ['id' => $info->id, 'title' => $info->title]) }}">
                                          {{ $info->title }}
                                    </a>
                                    @endforeach
                              </div>
                        </li>
                        @endif
                  </ul>

                  <!-- Right Side Of Navbar -->
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                        @if(Auth::guard('web')->check())
                        <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ auth()->user()->isAdmin() ? route('admin.home') : route('food_seller.home') }}">
                                        <i class="fa-solid fa-house"></i>
                                        {{ __('Home') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ auth()->user()->isAdmin() ? route('admin.profile') : route('food_seller.profile') }}">
                                          <i class="fa-solid fa-user"></i>
                                          {{ __('Profile') }}
                                    </a>

                                    <hr class="dropdown-divider">

                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                          <i class="fa-solid fa-right-from-bracket"></i>
                                          {{ __('Logout') }}
                                    </a>

                                    {{--
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                    --}}
                              </div>
                        </li>
                        @elseif(Auth::guard('student')->check())

                        @if(auth()->guard('student')->user()->is_a_sandbox_student)
                        <li class="nav-item">
                              <div class="nav-link">
                                    <i class="fa-solid fa-flask fa-fw"></i> This is a sandbox student account. <i class="fa-solid fa-flask fa-fw"></i>
                              </div>
                        </li>
                        @endif

                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('student.menus.cart') }}">
                                    Carts
                                    @if(auth()->guard('student')->user()->carts()->count() !== 0)
                                    <sup>
                                          <span class="badge bg-danger">{{ auth()->guard('student')->user()->carts()->count() > 99 ? '99+' : auth()->guard('student')->user()->carts()->count() }}</span>
                                    </sup>
                                    @endif
                              </a>
                        </li>

                        <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ auth('student')->user()->first_name }} {{ auth('student')->user()->last_name }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('student.profile') }}">
                                          <i class="fa-solid fa-user"></i> {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('student.order') }}">
                                          <i class="fa-solid fa-utensils"></i> {{ __('Order History') }}
                                    </a>

                                    <hr class="dropdown-divider">

                                    <a class="dropdown-item" href="{{ route('student.logout') }}">
                                          <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    {{--
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                    --}}
                              </div>
                        </li>
                        @else
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
                        @endif
                  </ul>
            </div>
      </div>
</nav>
