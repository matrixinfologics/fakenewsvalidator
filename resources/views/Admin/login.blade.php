<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fake News Validator - @yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <script src="{{ asset('js/admin-libs.js') }}"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="/"><b>Fake News Validator</b></a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @if(!empty($errors->first()))
                    <div class="row">
                        <div class="alert alert-danger">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif
                {{ Form::open(['url'=> route('admin.login')]) }}
                    <div class="form-group has-feedback">
                        {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email']) }}
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="{{ route('password.forgot') }}" class="">Forgot Password</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right">
                            {{ Form::submit('Sign In', ['class' => 'btn btn-primary btn-block btn-flat']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </body>
</html>
