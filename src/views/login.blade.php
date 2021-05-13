@extends('auth.app')

@section('content')
<div class="login_page">
    <div class="login_wrapper" style="text-align:center">
        @if(config('backoffice::backoffice.frontoffice',"true") == "true")
            <p class="title">Frontoffice</p>
        @else
            <p class="title">Backoffice</p>
        @endif
        @if(config('backoffice::backoffice.logo') != null)
            <img src="<?php echo config('backoffice::backoffice.logo') ?>" style="width:300px"/>
        @else
            <p class="subtitle">{{ strtoupper(config('app.name', 'OUTDARE'))}}</p>
        @endif
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div>
                <label for="email" class="col-md-4 control-label">E-mail</label>
                <div class="col-md-6">
                    <input class="textinput" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off">
                    @if ($errors->has('email'))
                        <p style="color:#a94442">{{ $errors->first('email') }}</p>
                    @endif
                </div>
            </div>
            <div style="margin-top: 25px">
                <label for="password" class="col-md-4 control-label">Password</label>
                <div>
                    <input class="textinput" id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                        <p style="color:#a94442">{{ $errors->first('password') }}</p>
                    @endif
                </div>
            </div>
            @if (isset($forbidden))
                <div>
                    <p style="color:#a94442">{{$forbidden}}</p>
                </div>
            @endif
            <div style="margin-top: 50px">
                <div style="text-align: center;">
                    <input class="submit" type="submit" value="Login">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
