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
@if (Auth::guest())
        <li>
            <a href="{{url('auth/login')}}" ><i class="fa fa-user"></i> Login </a>
        </li>
</ul>
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="#"><i class="fa fa-fw fa-user"></i> Perfil</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-gear"></i> Administración</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-power-off"></i>Salir</a>
            </li>
        </ul>
    </li>
    </ul>


@endif

