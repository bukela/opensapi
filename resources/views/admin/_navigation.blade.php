<nav id="sidebar">
    <div id="sidebar-scroll">
        <div class="sidebar-content">

            <div class="side-header side-content bg-white-op text-center">
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                {{-- <div class="btn-group pull-right"></div> --}}
                <img src="{{asset('img/opens-logo.png')}}" width="120">
            </div>

            <div class="side-content side-content-full">
                <ul class="nav-main">
                    <li>
                        <a class="active" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span class="sidebar-mini-hide">{{__('Dashboard')}}</span></a>
                    </li>
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">{{ __('Content') }}</span></li>
                    <li>
                        <a class="active" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span class="sidebar-mini-hide">{{ __('Users') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.events.index') }}"><i class="fas fa-calendar-alt"></i> <span class="sidebar-mini-hide">{{ __('Events') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.news.index') }}"><i class="fas fa-newspaper"></i> <span class="sidebar-mini-hide">{{ __('News') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.organizations.index') }}"><i class="fas fa-building"></i> <span class="sidebar-mini-hide">{{ __('Organizations') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.donators.index') }}"><i class="fas fa-handshake"></i> <span class="sidebar-mini-hide">{{ __('Donators') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.projects.index') }}"><i class="fas fa-forward"></i> <span class="sidebar-mini-hide">{{ __('Projects') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.publications.index') }}"><i class="fas fa-book"></i> <span class="sidebar-mini-hide">{{ __('Publications') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.galleries.index') }}"><i class="fas fa-images"></i> <span class="sidebar-mini-hide">{{ __('Galleries') }}</span></a>
                    </li>
                    <li>
                        <a class="active" href="{{ route('admin.libraries.index') }}"><i class="fas fa-bookmark"></i> <span class="sidebar-mini-hide">{{ __('Libraries') }}</span></a>
                    </li>
                    <li>
                    <a class="active" href="{{ route('admin.contactus') }}"><i class="fas fa-address-book"></i> <span class="sidebar-mini-hide">{{ __('Contact us') }}</span></a>
                    </li> 
                    <li>
                        <a class="active" href="{{ route('admin.logs.index') }}"><i class="fas fa-file-alt"></i> <span class="sidebar-mini-hide">{{ __('Logs') }}</span></a>
                    </li>                                       
                    {{-- <li class="nav-main-heading"><span class="sidebar-mini-hide">Site</span></li> --}}
                </ul>
            </div>
        </div>
    </div>
</nav>

<header id="header-navbar" class="content-mini content-mini-full">
    <ul class="nav-header pull-right">
        <li>
            <a target="_blank" class="btn btn-default" href="{{ route('home') }}"><i class="fas fa-globe"></i></a>
        </li>
        <li>
            <div class="btn-group">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                    <i class="fas fa-user"></i> {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    {{--<li>--}}
                        {{--<a href="{{ route('admin.users.edit', ['user' => auth()->user()->id]) }}" class="dropdown-item"><i class="fas fa-edit"></i> Edit Profile</a>--}}
                    {{--</li>--}}
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </li>
    </ul>

    <ul class="nav-header pull-left">
        {{--<li>--}}
            {{--<a href="{{ route('admin.settings.index') }}"><i class="fas fa-cogs"></i> Settings</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Users</a>--}}
        {{--</li>--}}
    </ul>
</header>
