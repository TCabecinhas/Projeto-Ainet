<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4 align-items-center">
    <div class="card box">
        <img src="{{ asset('storage/tshirtImages/' . $tshirtImage->image_url) }}" class="card-img-top box-img"
            alt="...">
        <div class="card-body">
            <h5 class="card-title">{{ $tshirtImage->name }}</h5>
            <p class="card-text">Categoria:
                {{ $tshirtImage->categoria != null ? $tshirtImage->categoria->name : 'Sem Categoria' }}</p>
            <a href="{{ route('tshirtImages.tshirtImage', $tshirtImage->id) }}" class="btn btn-outline-dark">Ver mais</a>
        </div>
    </div>
</div>
