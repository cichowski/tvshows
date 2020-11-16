@extends('layouts.app')

@section('page')
    <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">TV shows</h1>

    <hr class="mt-2 mb-5">

    <div class="row text-center text-lg-left">

        <div class="col-lg-3 col-md-4 col-6 tv-item">
            <div class="thumbnail">
                <div class="image-wrapper">
                    <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/pWkk7iiCoDM/400x300" alt="">
                </div>
                <div class="caption">
                    <h3 class="title">Title</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-6 tv-item">
            <div class="thumbnail">
                <div class="image-wrapper">
                    <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/EUfxH-pze7s/400x300" alt="">
                </div>
                <div class="caption">
                    <h3 class="title">Title</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-6 tv-item">
            <div class="thumbnail">
                <div class="image-wrapper">
                    <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/G9Rfc1qccH4/400x300" alt="">
                </div>
                <div class="caption">
                    <h3 class="title">Title</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-6 tv-item">
            <div class="thumbnail">
                <div class="image-wrapper">
                    <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/aJeH0KcFkuc/400x300" alt="">
                </div>
                <div class="caption">
                    <h3 class="title">Title</h3>
                </div>
            </div>
        </div>

        <div class="col-12 tv-item">
            <div class="thumbnail">
                <div class="image-wrapper" style="float:left;">
                    <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/p2TQ-3Bh3Oo/400x300" alt="">
                </div>
                <div class="caption" style="float:left;">
                    <h3 class="title">Title</h3>
                </div>
            </div>
        </div>
    </div>
@endsection