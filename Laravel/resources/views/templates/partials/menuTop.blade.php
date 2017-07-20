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
                    	<a href="{{url('login')}}" ><i class="fa fa-user"></i> Login </a>
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

            <!-- Filtros -->
            <ul class="nav navbar-left top-nav">
            	 <!-- Categorías -->
                <li class="dropdown">
                    <a href="#"><i class="fa fa-folder-open"></i> Categorías </a>
                </li>
                <!-- Autorores -->
                <li class="dropdown">
                    <a href="#"><i class="fa fa-users"></i> Autores/as </a>
                </li>
                <!-- Alfabético -->
                <li class="dropdown">
                    <a href="#"><i class="fa fa-filter"></i> A-Z </a>
                </li>
            </ul>
           @endif
           
