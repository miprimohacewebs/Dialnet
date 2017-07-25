            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <!-- Preguntas frecuentes -->
                <li class="dropdown">
                    <a href="#"><i class="fa fa-envelope-o"></i> Contacto </a>
                </li>
                <!-- Preguntas frecuentes -->
                <li class="dropdown">
                    <a href="#"><i class="fa fa-question"></i> FAQS </a>
                </li>
                <!-- Usuario -->
                @if (Auth::check())
                    <li>
                        <a href="#" class="dropdown" ><i class="fa fa-user"></i> Bienvenido/a:  {{ Auth::user()->name }}</b></a>
                    </li>
                    <li class="dropdown" >
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Administración</a>
                    </li>
                    <li class="dropdown">
                        <a href="#"><i class="fa fa-fw fa-power-off"></i>Salir</a>
                    </li>
                @else
                    <li  class="dropdown" >
                        <a href="{{url('login')}}" ><i class="fa fa-user"></i> Login </a>
                    </li>
                @endif

            </ul>
