    @extends('master')
    @section('content')
        {{-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                @for ($item = 0; $item <= 2; $item++)
                    <div class="carousel-item {{ $products[$item]['id'] == 1 ? 'active' : '' }} ">
                        <img class="d-block w-100" src="{{ asset('uploads/products/' .  $products[$item]['gallery']) }}" alt="First slide">
                    </div>
                @endfor

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div> --}}
        <div class="mt-5 mx-auto container row">
            @foreach ($products as $item)
                <div class="card col-md-4   mt-3">
                    <img class="card-img-top" src="{{ asset('uploads/products/' . $item->gallery) }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->description }}</p>
                        <div class="text-center">
                            <a href="details/{{ $item->id }}" class="btn btn-primary">Product Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
