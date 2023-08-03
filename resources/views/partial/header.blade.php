<header style="position:  fixed;z-index:  10000;width:  100%;">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #000000;">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('home') }}">
                {{ config('app.name', 'instagram') }}
            </a>

            <button class="bg-secondary navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

                @auth
                    <li class="dropdown dropdown-notification nav-item  dropdown-notifications">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="fa fa-bell"> </i>
                            <span
                                class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow   notif-count"
                                data-count="9">9</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0 text-center">
                                    <span class="grey darken-2 text-center"> الرسائل</span>
                                </h6>
                            </li>
                            <li class="scrollable-container ps-container ps-active-y media-list w-100">
                                <a href="">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="media-heading text-right ">عنوان الاشعار </h6>
                                            <p class="notification-text font-small-3 text-muted text-right"> نص الاشعار</p>
                                            <small style="direction: ltr;">
                                                <p class=" text-muted text-right"
                                                      style="direction: ltr;"> 20-05-2020 - 06:00 pm
                                                </p>
                                                <br>

                                            </small>
                                        </div>
                                    </div>
                                </a>

                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href=""> جميع الاشعارات </a>
                            </li>
                        </ul>
                    </li>
                @endauth


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search -->
                <div class="navbar-nav mr-auto">
                    <input class="form-control" id="search" style="direction: rtl;width: 100%; margin: 5px; border: 1px solid #484f64; background: none;" type="text" placeholder="البحث" aria-label="Search" autocomplete="off">
                </div>

                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('posts.create') }}"><i class="fa fa-plus"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('profile.edit') }}"><i class="fa fa-user"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="pt-5">
    <section class="jumbotron text-center bg-dark">
        <div class="container">
            <h1 class="jumbotron-heading"></h1>
            <p class="lead text-muted">انشر أجمل صورك وفيديوهاتك لتحصل على تفاعل الاصداقاء معك!</p>
            <p>
                <a href="{{ route('home') }}" class="btn btn-{{ isset($active_home) ? $active_home : 'secondary' }} my-2">{{ __('Home') }}</a>
                {{-- <a href="{{ route('followers.index') }}" class="btn btn-{{ isset($active_follow) ? $active_follow : 'secondary' }} my-2">{{ __('frontend.Followers') }}</a>
                <a href="{{ route('users.index') }}" class="btn btn-{{ isset($active_user) ? $active_user : 'secondary' }} my-2">{{ __('frontend.Users') }}</a> --}}
                <a href="{{ route('profile.edit') }}" class="btn btn-{{ isset($active_profile) ? $active_profile : 'secondary' }} my-2">{{ __('My Profile') }}</a>
            </p>
        </div>
    </section>
</div>

