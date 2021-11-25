<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Gestíon de Planificaciones</title>
    </head>
    
    <body>
            <div id="app">
                    
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                        <ul class="menu">
                            <li><a href="/users">Inspectores</a></li>
                            <li><a href="/planning">Planificaciones</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-6">
                        <ul>
                        @guest
                        
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                        @else
                            <li class="nav-item dropdown">Conectado como: 
                               
                                    {{ strtoupper(Auth::user()->name) }}
                               
                            </li>
                            <li>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            </li>
                        
                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                
                            
                        @endguest
                    </ul>
                        
                </div>
            </div>
        

    
            <div class="row">
                    <div class="col-12 w-100">
                        @yield('content')
                    </div>
            </div>
        </div> <!-- cierre container -->
    </div> <!-- cierre app -->
    </body>
    </html>