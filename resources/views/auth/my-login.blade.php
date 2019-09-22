@extends('layouts.page-blank')
@section('content')
<div id="page-container">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('{{ asset('assets/img/photo6@2x.jpg') }}');">
            <div class="hero-static bg-white-95">
                <div class="content">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <div class="block block-themed block-fx-shadow mb-0">
                                <div class="block-header text-center">
                                    <h3 class="block-title">Ingresar</h3>
                                </div>
                                <div class="block-content">
                                    <div class="p-sm-3 px-lg-4 py-lg-5">
                                        <h1 class="mb-2">SIDCA</h1>
                                        <p>Bienvenid@, por favor ingresa tus datos.</p>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="py-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-alt form-control-lg @error('email') is-invalid @enderror" id="login-username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo Electronico">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-alt form-control-lg @error('password') is-invalid @enderror" id="login-password" name="password" required autocomplete="current-password"placeholder="Contraseña">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 offset-3">
                                                    <button type="submit" class="btn btn-block btn-primary">
                                                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Iniciar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@stop
