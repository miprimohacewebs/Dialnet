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
                    <li  class="dropdown" >
                    	<a href="{{url('login')}}" ><i class="fa fa-user"></i> Login </a>
                    </li>

                @else
                    <li>
                    <a href="#" class="dropdown" ><i class="fa fa-user"></i> Bienvenido/a:  {{ Auth::user()->name }} <b class="caret"></b></a>
                    </li>
                    <li class="dropdown" >
                         <a href="#"><i class="fa fa-fw fa-gear"></i> Administración</a>
                    </li>
                    <li class="dropdown">
                         <a href="#"><i class="fa fa-fw fa-power-off"></i>Salir</a>
                    </li>
                @endif
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

           
