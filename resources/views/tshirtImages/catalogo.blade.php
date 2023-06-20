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

        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none
        }

        .page-link {
            position: relative;
            display: block;
            color: #262626;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #dee2e6;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
        }

        @media (prefers-reduced-motion:reduce) {
            .page-link {
                transition: none
            }
        }

        .page-link:hover {
            z-index: 2;
            color: #262626;
            background-color: #e9ecef;
            border-color: #dee2e6
        }

        .page-link:focus {
            z-index: 3;
            color: #262626;
            background-color: #e9ecef;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(38, 38, 38, 0.8)
        }

        .page-item:not(:first-child) .page-link {
            margin-left: -1px
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #262626;
            border-color: #262626
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6
        }

        .page-link {
            padding: .375rem .75rem
        }

        .page-item:first-child .page-link {
            border-top-left-radius: .25rem;
            border-bottom-left-radius: .25rem
        }

        .page-item:last-child .page-link {
            border-top-right-radius: .25rem;
            border-bottom-right-radius: .25rem
        }

        .pagination-lg .page-link {
            padding: .75rem 1.5rem;
            font-size: 1.25rem
        }

        .pagination-lg .page-item:first-child .page-link {
            border-top-left-radius: .3rem;
            border-bottom-left-radius: .3rem
        }

        .pagination-lg .page-item:last-child .page-link {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem
        }

        .pagination-sm .page-link {
            padding: .25rem .5rem;
            font-size: .875rem
        }

        .pagination-sm .page-item:first-child .page-link {
            border-top-left-radius: .2rem;
            border-bottom-left-radius: .2rem
        }

        .pagination-sm .page-item:last-child .page-link {
            border-top-right-radius: .2rem;
            border-bottom-right-radius: .2rem
        }
    </style>
@endpush

@section('content')
    <section class="  mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class=" bg-white ">
                        <a href="/"
                            class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                            <svg class="bi me-2" width="30" height="24">
                                <use xlink:href="#bootstrap"></use>
                            </svg>
                            <span class="fs-5 fw-semibold">
                                <h2>
                                    Imagens
                                </h2>
                            </span>
                        </a>
                        <ul class="list-unstyled ps-0">
                            <li class="mb-1">
                                <button class="btn btn-toggle align-items-center rounded collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                                    Categorias
                                </button>
                                <div class="collapse mt-2" id="dashboard-collapse">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        @foreach ($categories as $categoria)
                                            <li class="list-group-item "><a
                                                    href="{{ route('tshirtImages.category', $categoria->id) }}"
                                                    class="link-dark rounded"
                                                    style="text-decoration:none">{{ $categoria->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="row">
                        @foreach ($tshirtImages as $tshirtImage)
                            <x-tshirtImage-card :tshirtImage=$tshirtImage />
                        @endforeach
                    </div>
                    <br>
                    <div class="pagination pagination-circle d-flex justify-content-center ">{{ $tshirtImages->links() }}
                    </div>
                </div>
            </div>
        </div>
        <br>
    </section>
@endsection
