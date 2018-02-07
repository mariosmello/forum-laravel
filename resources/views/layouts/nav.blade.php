<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">

                <li class="dropdown">

                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        Browse <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/threads">All Threads</a>
                        </li>
                        <li>
                            @if(auth()->check())
                                <a href="/threads?by={{auth()->user()->name}}">My Threads</a>
                            @endif
                        </li>
                        <li>
                            <a href="/threads?popular=1">
                                Popular Threads
                            </a>
                        </li>
                    </ul>

                </li>

                <li>
                    <a href="/threads/create" title="New Thread">New Thread</a>
                </li>

                <li class="dropdown">

                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        Channels <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($channels as $channel)
                            <li>
                                <a href="/threads/{{ $channel->slug }}" title="{{ $channel->name }}">
                                    {{ $channel->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                 @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('profile', Auth::user()) }}">
                                        My Profile
                                    </a>

                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
            </ul>
        </div>
    </div>
</nav>