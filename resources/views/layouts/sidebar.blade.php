<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header bg-white-5">
        <a href="{{ url('/dashboard') }}">
            <span class="smini-show">
                <i class="fa fa-star text-primary"></i>
            </span>
            <span class="smini-hide">
                <img src="{{ asset('img/new-logo.png') }}" style="width:75%;" alt="LOGO-UNERG">
            </span>
        </a>
        <div>
            <div class="dropdown d-inline-block ml-3">
                <a class="text-dual font-size-sm" id="sidebar-themes-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="si si-drop"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right font-size-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
                    <a class="dropdown-item" data-toggle="layout" data-action="sidebar_style_light" href="#">
                        <span>Panel Blanco</span>
                    </a>
                    <a class="dropdown-item" data-toggle="layout" data-action="sidebar_style_dark" href="#">
                        <span>Panel Oscuro</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-toggle="layout" data-action="header_style_light" href="#">
                        <span>Cabezera Blanca</span>
                    </a>
                    <a class="dropdown-item" data-toggle="layout" data-action="header_style_dark" href="#">
                        <span>Cabezera Oscura</span>
                    </a>
                </div>
            </div>
            <a class="d-lg-none text-dual ml-3" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="content-side content-side-full">
        <ul class="nav-main">
            <li class="nav-main-item">
                <a class="nav-main-link active" href="#">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name">ADMINISTRACION</span>
                </a>
            </li>
            <li class="nav-main-item {{ Sidebar::here(['profesores','profesores/ordinarios','profesores/contratados']) }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">PERSONAL DOCENTE</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('profesores/ordinarios')?'active':'' }}" href="{{ route('ordinary.index') }}">
                            <span class="nav-main-link-name">Ordinario</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('profesores/contratados')?'active':'' }}" href="{{ route('hired.index') }}">
                            <span class="nav-main-link-name">Contratado</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item {{ Sidebar::movement_here(['ascenso'])}}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">MOVIMIENTOS DOCENTE</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Concurso de Oposicion</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('movimiento/ascenso')?'active':'' }}" href="{{ route('ascent.index') }}">
                            <span class="nav-main-link-name">Convalidacion de Ascensos</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Comision de Servicios</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                            <span class="nav-main-link-name">Permisos</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="">
                                    <span class="nav-main-link-name">Remunerados</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="">
                                    <span class="nav-main-link-name">No Remunerados</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Traslados</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Disfrute de año Sabatico</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Reincorporaciones</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Jubilaciones</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">NOMINAS DOCENTE</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Carga Horaria</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">PROCEDIMIENTO ADMINISTRATIVO</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <span class="nav-main-link-name">Todos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item {{ Sidebar::preload_here(['areas','carreras','nucleos','sedes','periodos','programas','asignaturas','titulos','universidades','extensiones'])}}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">PRECARGA DE DATOS</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/universidades')?'active':'' }}" href="{{ route('university.index') }}">
                            <span class="nav-main-link-name">Universidades</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/titulos')?'active':'' }}" href="{{ route('title.index') }}">
                            <span class="nav-main-link-name">Titulos</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/periodos')?'active':'' }}" href="{{ route('period.index') }}">
                            <span class="nav-main-link-name">Periodos</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/sedes')?'active':'' }}" href="{{ route('headquarter.index') }}">
                            <span class="nav-main-link-name">Sedes</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/areas')?'active':'' }}" href="{{ route('area.index') }}">
                            <span class="nav-main-link-name">Areas</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/programas')?'active':'' }}" href="{{ route('program.index') }}">
                            <span class="nav-main-link-name">Programas</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/asignaturas')?'active':'' }}" href="{{ route('subject.index') }}">
                            <span class="nav-main-link-name">Asignaturas</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/nucleos')?'active':'' }}" href="{{ route('core.index') }}">
                            <span class="nav-main-link-name">Nucleos</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/extensiones')?'active':'' }}" href="{{ route('extension.index') }}">
                            <span class="nav-main-link-name">Extensiones</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/aulas-territoriales')?'active':'' }}" href="{{ route('tclassroom.index') }}">
                            <span class="nav-main-link-name">Aulas Territoriales</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item {{ Sidebar::preload_here(['autoridades']) }} {{ Sidebar::here(['usuarios']) }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">CONFIGURACIÓN</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('usuarios')?'active':'' }}" href="{{ route('users.index') }}">
                            <span class="nav-main-link-name">USUARIOS</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/autoridades')?'active':'' }}" href="{{ route('authority.index') }}">
                            <span class="nav-main-link-name">AUTORIDADES</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>