<!--Sidebar-->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" id="sidebar-wrapper">
      <a href="{{ route('landing') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none sidebar-heading">
            <i class="fa-solid fa-house fa-xl me-2"></i>
            <span class="fs-3">{{ config('app.name', 'Laravel') }}</span>
      </a>
      <hr>

      <ul class="nav nav-pills flex-column mb-auto">
            @can('isAdmin')
            <li class="nav-item">
                  <a href="{{ route('admin.home') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.home') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-house me-2"></i>
                        Home
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.user_management') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.user_management') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-users"></i>
                        User Management
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.store') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.store') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-shop"></i>
                        Store
                  </a>
            </li>
            <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle link-dark" id="menuDropdown" data-bs-toggle="collapse" data-bs-target="#menu-collapse" aria-expanded="false">
                        <i class="fa-solid fa-bowl-food"></i>
                        Menus
                  </a>
                  <div class="collapse {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.menus') ? 'show' : '' }}" id="menu-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.menus.category') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.menus.category') }}">Product Category</a>
                              </li>
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.menus.list') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.menus.list') }}">Product List</a>
                              </li>
                        </ul>
                  </div>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.order') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.order') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-list-check"></i>
                        Order
                  </a>
            </li>
            <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle link-dark" id="paymentDropdown" data-bs-toggle="collapse" data-bs-target="#payment-collapse" aria-expanded="false">
                        <i class="fa-solid fa-credit-card"></i>
                        Payment
                  </a>
                  <div class="collapse {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.payment') ? 'show' : '' }}" id="payment-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.payment.general') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.payment.general') }}">General</a>
                              </li>
                              @if(config('payment.2c2p-status'))
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.payment.2c2p') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.payment.2c2p') }}">2C2P</a>
                              </li>
                              @endif
                              @if(config('payment.stripe-status'))
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.payment.stripe') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.payment.stripe') }}">Stripe</a>
                              </li>
                              @endif
                        </ul>
                  </div>
            </li>
            <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle link-dark" id="designDropdown" data-bs-toggle="collapse" data-bs-target="#design-collapse" aria-expanded="false">
                        <i class="fa-solid fa-ruler-combined"></i>
                        Design
                  </a>
                  <div class="collapse {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.design') ? 'show' : '' }}" id="design-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.design.general') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.design.general') }}">General</a>
                              </li>
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.design.landing') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.design.landing') }}">Landing Page</a>
                              </li>
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.design.information') ? 'active' : 'link-dark' }} mx-4" href="{{ route('admin.design.information') }}">Information Page</a>
                              </li>
                        </ul>
                  </div>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.reports') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.reports') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-file-pen"></i>
                        Reports
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.media_manager') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.media_manager') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-images"></i>
                        Media Manager
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.pos_settings') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.pos_settings') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-cash-register"></i>
                        POS Settings
                  </a>
            </li>
            @endcan

            @can('isFoodSeller')
            <li class="nav-item">
                  <a href="{{ route('food_seller.home') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.home') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-house me-2"></i>
                        Home
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('food_seller.store') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.store') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-shop"></i>
                        Store
                  </a>
            </li>
            <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle link-dark" id="menuDropdown" data-bs-toggle="collapse" data-bs-target="#menu-collapse" aria-expanded="false">
                        <i class="fa-solid fa-bowl-food"></i>
                        Menus
                  </a>
                  <div class="collapse {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.menus') ? 'show' : '' }}" id="menu-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.menus.category') ? 'active' : 'link-dark' }} mx-4" href="{{ route('food_seller.menus.category') }}">Product Category</a>
                              </li>
                              <li>
                                    <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.menus.product') ? 'active' : 'link-dark' }} mx-4" href="{{ route('food_seller.menus.product') }}">Product List</a>
                              </li>
                        </ul>
                  </div>
            </li>
            <li class="nav-item">
                  <a href="{{ route('food_seller.order') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.order') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-list-check"></i>
                        Orders
                  </a>
            </li>
            <li class="nav-item">
                  <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-file-pen"></i>
                        Reports
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('food_seller.media_manager') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.media_manager') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-images"></i>
                        Media Manager
                  </a>
            </li>
            @endcan
      </ul>

</div>