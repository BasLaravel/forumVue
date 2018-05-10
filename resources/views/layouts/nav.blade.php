        <nav class="navbar navbar-expand-md  navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Browse
                            </a>
                            <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('threads.index') }}">All Threads</a>
                                @auth
                                <a class="dropdown-item" href="/threads?by={{auth()->user()->name}}">My Threads</a>
                                @endauth
                                <a class="dropdown-item" href="/threads?popular=1">Popular all Time</a>
                                <a class="dropdown-item" href="/threads?unanswered=1">Unanswered Threads</a>
                            </div>
                        </li>

                      
                        <li><a class="nav-link" href="{{ route('thread.create') }}">New Thread</a></li>

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Channels
                            </a>
                            <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                            @foreach($channels as $channel)
                                <a class="dropdown-item" href="/threads/{{$channel->slug}}">{{$channel->name}}</a>
                            @endforeach
                            </div>
                        </li>

   

                    </ul>


                    <!-- Right Side Of Navbar -->

                     
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    </ul>
                        @else

                    <notifications-dropdown inline-template :attribuutuserid="{{auth::user()->id}}"> 
                        <ul class="navbar-nav ml-auto">
                            
                            <li class="nav-item dropdown" id="notifications">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" 
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Notifications
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" v-show="standaardmessage">U heeft geen notificaties</a>
                                    <a class="dropdown-item" :href="value.link" v-for="(value, key) in data"
                                       v-text="value.message" @click="markAsRead(value.id)"></a>           
                                </div>  
                            </li>
                            <li>  
                                <img src="{{asset('images/bell.svg')}}" style="height: 1rem; width: 1rem; margin-left:-5px;
                                     margin-right:5px;" alt="image" v-show="showbell">    
                           </li>

                            <li class="nav-item dropdown">
                               
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="{{route('profile.show',[Auth::user()])}}">My Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </notifications-dropdown>  
                    @endguest
                </div>
            </div>
        </nav>




<script>



</script>


