@extends('layouts.app')

@push('css')
    <style>
        .box {
            border-radius: 15px;
            background-color: #faf9fa;
        }

        .box-img {
            width: auto;
            height: 200px;
            object-fit: scale-down;
        }

        .box a {
            text-decoration: none;
            color: black;
        }

        /*--------------------------------------------------------------
        # Hero Section
        --------------------------------------------------------------*/
        #hero {
            width: 100%;
            height: 70vh;
            background-color: rgba(9, 9, 9, 0.8);
            overflow: hidden;
            position: relative;
        }

        #hero .carousel,
        #hero .carousel-inner,
        #hero .carousel-item,
        #hero .carousel-item::before {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
        }

        #hero .carousel-item::before {
            content: '';
            background-color: rgba(71, 70, 71, 0.8);
        }

        #hero .carousel-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            bottom: 0;
            top: 0;
            left: 50px;
            right: 50px;
        }

        #hero .container {
            text-align: center;
        }

        #hero h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 48px;
            font-weight: 700;
        }

        #hero p {
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s;
            margin: 0 auto 30px auto;
            color: #fff;
        }

        #hero .carousel-inner .carousel-item {
            transition-property: opacity;
            background-position: center top;
        }

        #hero .carousel-inner .carousel-item,
        #hero .carousel-inner .active.carousel-item-start,
        #hero .carousel-inner .active.carousel-item-end {
            opacity: 0;
        }

        #hero .carousel-inner .active,
        #hero .carousel-inner .carousel-item-next.carousel-item-start,
        #hero .carousel-inner .carousel-item-prev.carousel-item-end {
            opacity: 1;
            transition: 0.5s;
        }

        #hero .carousel-control-next-icon,
        #hero .carousel-control-prev-icon {
            background: none;
            font-size: 30px;
            line-height: 0;
            width: auto;
            height: auto;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            transition: 0.3s;
            color: rgba(255, 255, 255, 0.5);
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #hero .carousel-control-next-icon:hover,
        #hero .carousel-control-prev-icon:hover {
            background: rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.8);
        }

        #hero .carousel-indicators li {
            cursor: pointer;
            background: #fff;
            overflow: hidden;
            border: 0;
            width: 12px;
            height: 12px;
            border-radius: 50px;
            opacity: .6;
            transition: 0.3s;
        }

        #hero .carousel-indicators li.active {
            opacity: 1;
            background: black;
        }

        #hero .btn-get-started {
            font-family: "Raleway", sans-serif;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 14px 32px;
            border-radius: 4px;
            transition: 0.5s;
            line-height: 1;
            color: #fff;
            -webkit-animation-delay: 0.8s;
            animation-delay: 0.8s;
            background: #474647;
        }

        #hero .btn-get-started:hover {
            background: #353435;
        }

        @media (max-width: 992px) {
            #hero {
                height: 100vh;
            }

            #hero .carousel-container {
                top: 66px;
            }
        }

        @media (max-width: 768px) {
            #hero h2 {
                font-size: 28px;
            }
        }

        @media (min-width: 1024px) {

            #hero .carousel-control-prev,
            #hero .carousel-control-next {
                width: 5%;
            }
        }

        @media (max-height: 500px) {
            #hero {
                height: 120vh;
            }
        }
    </style>
@endpush

@section('content')
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators">
                <li data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></li>
                <li data-bs-target="#heroCarousel" data-bs-slide-to="1" class=""></li>
                <li data-bs-target="#heroCarousel" data-bs-slide-to="2" class=""></li>
            </ol>
            <div class="carousel-inner" role="listbox">

                <!-- Slide 1 -->
                <div class="carousel-item active" style="background-image: url(img/estampaslide1.jpg)">
                    <div class="carousel-container">
                        <div class="container">
                            <h2 class="animate__animated animate__fadeInDown">T-shirts personalizadas</h2>
                            <a href="{{ route('tshirtImages.catalogo') }}"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Catalogo</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item" style="background-image: url(img/t_shirt.jpg)">

                </div>

                <!-- Slide 3 -->
                <div class="carousel-item" style="background-image: url(img/wpshirts2.png)">
                    <div class="carousel-container">
                        <div class="container">
                            <h2 class="animate__animated animate__fadeInDown">T-shirts personalizadas ao teu gosto</h2>
                            <a href="{{ route('tshirts.criar-personalizada') }}"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">A tua T-shirt</a>
                        </div>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

        </div>
    </section>


    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <h1 class="text-center">Algumas das nossas imagens</h1>
                <h4 class="text-center">Para conheceres mais visita o nosso catálogo</h4>
                <div class="row">
                @foreach ($tshirtImages as $tshirtImage)               
                    <x-tshirtImage-card :tshirtImage="$tshirtImage" />
                @endforeach
                </div>
            </div>
            <a href="{{ route('tshirtImages.catalogo') }}" class="btn btn-block btn-outline-dark mb-5">Ver Catálogo »</a>
        </div>
    </div>
@endsection