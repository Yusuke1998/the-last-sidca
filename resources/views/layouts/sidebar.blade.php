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
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">NOMINA</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="#">
                            <span class="nav-main-link-name">Nueva</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="#">
                            <span class="nav-main-link-name">Seguimiento</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="#">
                            <span class="nav-main-link-name">Relación</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="#">
                            <span class="nav-main-link-name">Devolución</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item {{ Sidebar::here(['profesores']) }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">PROFESOR</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item {{ request()->is('profesores')?'active':'' }}">
                        <a class="nav-main-link" href="{{ route('teacher.index') }}">
                            <span class="nav-main-link-name">Todos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item {{ Sidebar::here(['usuarios']) }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">USUARIO</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item {{ request()->is('usuarios')?'active':'' }}">
                        <a class="nav-main-link" href="{{ route('users.index') }}">
                            <span class="nav-main-link-name">Todos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item {{ Sidebar::preload_here(['areas','carreras','nucleos','sedes','periodos','programas','asignaturas','titulos','universidades'])}}">
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
                        <a class="nav-main-link {{ request()->is('precarga/nucleos')?'active':'' }}" href="{{ route('core.index') }}">
                            <span class="nav-main-link-name">Nucleos</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('precarga/carreras')?'active':'' }}" href="{{ route('career.index') }}">
                            <span class="nav-main-link-name">Carreras</span>
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
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">REPORTES</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="#">
                            <span class="nav-main-link-name">PDF</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="#">
                            <span class="nav-main-link-name">EXCEL</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>