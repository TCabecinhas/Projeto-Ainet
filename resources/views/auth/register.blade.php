@extends('layouts.app')
@push('css')
    <style>
        .main-content {
            width: 50%;
            border-radius: 20px;
            box-shadow: 0 5px 5px rgba(0, 0, 0, .4);
            margin: 5em auto;
            display: flex;
        }

        .company__info {
            background-color: #343a40;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }

        .fa-android {
            font-size: 3em;
        }

        @media screen and (max-width: 640px) {
            .main-content {
                width: 90%;
            }

            .company__info {
                display: none;
            }

            .login_form {
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
            }
        }

        @media screen and (min-width: 642px) and (max-width:800px) {
            .main-content {
                width: 70%;
            }
        }

        .row>h2 {
            color: #343a40;
        }

        .login_form {
            background-color: #fff;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            border-top: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }

        form {
            padding: 0 2em;
        }

        .form__input {
            width: 100%;
            border: 0px solid transparent;
            border-radius: 0;
            border-bottom: 1px solid #aaa;
            padding: 1em .5em .5em;
            padding-left: 2em;
            outline: none;
            margin: 1.5em auto;
            transition: all .5s ease;
        }

        .form__input:focus {
            border-bottom-color: #343a40;
            box-shadow: 0 0 5px rgba(52, 58, 64, 0.8);
            border-radius: 4px;
        }

        .btn {
            transition: all .5s ease;
            width: 100%;
            display: block;
            border-radius: 30px;
            color: #343a40;
            font-weight: 600;
            background-color: #fff;
            border: 1px solid #343a40;
            margin-top: 1.5em;
            margin-bottom: 1em;
        }

        .btn:hover,
        .btn:focus {
            background-color: #343a40;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="container-fluid">
            <div class="row main-content bg-success text-center">
                <div class="col-md-4 text-center company__info  bg-dark">
                    <span class="company__logo">
                        <h2> <img src="{{ asset('img/plain_white.png') }}" width="75" height="75"
                                class="d-inline-block align-top"></h2>
                    </span>
                    <h4 class="company_title">IMAGINE SHIRTS</h4>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
                    <div class="container-fluid">
                        <div class="row mt-2">
                            <h2>{{ __('Register') }}</h2>
                        </div>
                        <div class="row">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <input id="name" type="text"
                                        class="form__input @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="{{ __('Name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <input id="email" type="email"
                                        class="form__input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="{{ __('E-Mail Address') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <input id="password" type="password"
                                        class="form__input @error('password') is-invalid @enderror" name="password" required
                                        autocomplete="new-password" placeholder="{{ __('Password') }}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <input id="password-confirm" type="password" class="form__input"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="{{ __('Confirm Password') }}">
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
