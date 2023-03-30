<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
        
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <link rel="stylesheet" href="/css/style.css">
        
      
    </head>
    <body>
        
        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbar">
                        <a href="/" class="navbar-brand">
                            <img src="/img/logo.png" alt="Logo">
                        </a>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="/" class="nav-link">Eventos</a>
                            </li>
                            <li class="nav-item">
                                <a href="/events/create" class="nav-link">Criar Eventos</a>
                            </li>
                            @auth
                            <li class="nav-item">
                                    <a href="/dashboard" class="nav-link">Meus Eventos</a>
                                </li>

                                <li class="nav-item">
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <a  href="/logout" 
                                            class="nav-link" 
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            Sair
                                        </a>
                                    </form>
                                </li>

                            @endauth
                            
                            
                            @guest
                                <li class="nav-item">
                                    <a href="/login" class="nav-link">Entrar</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/register" class="nav-link">Cadastrar</a>
                                </li>
                            @endguest
                          
                        </ul>
                </div>
            </nav>
        </header>
         <div class="container-fluid">
            <div class="row">
                @if(session('msg'))
                    <p class="msg">{{session('msg')}}</p>
                @elseif(session('error'))
                    <p class="msg-error">{{session('error')}}</p>
                @endif
                @yield('content')
            </div>
         </div>

           <footer>
            <p>HanzEventSys &copy 2023</p>
            <!-- ION ICONS -->
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
           </footer>
    </body>
</html>
