<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login - Fake News Validator</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/front.js') }}"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="main-login">
            <div class="container">
                <div class="form-main">
                    <h1>Fake News Validator</h1>
                    {{ Form::open(['url'=> route('password.email')]) }}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                         <div class="form-group {{ $errors->first('email')?'has-error':'' }}">
                            {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email']) }}
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>
                        {{ Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </body>
</html>

