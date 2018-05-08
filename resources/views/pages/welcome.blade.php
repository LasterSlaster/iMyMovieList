@extends('master') @section('stylesheets')

<link rel="stylesheet" type="text/css" href="/css/welcome.css">

@endsection 

@section('content')

<section class="topSection text-white text-center">
        <div class="overlay"></div>
        <div class="container">
                <div class="row">
                        <div class="col-xl-9 mx-auto">
                                <h1 class="font-weight-bold mb-5">Behalte nun den Überblick über Deine Filme mit iMyMovieList!</h1>
                        </div>
                        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                                <button class="btn btn-success btn-block btn-lg">Jetzt Mitglied werden</button>
                        </div>
                </div>
        </div>
</section>

<section class="feature bg-light text-center">
        <div class="container">
                <div class="row">
                        <div class="col-lg-4">
                                <div class="features-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                                        <div class="features-icon d-flex">
                                                <i class="fas fa-thumbs-up m-auto text-primary pb-3"></i>
                                        </div>
                                        <h3 class="font-weight-bold">Überblick</h3>
                                        <p class="lead mb-0">durch organisierte Listen</p>
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="features-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                                        <div class="features-icon d-flex">
                                                <i class="far fa-lightbulb m-auto text-primary pb-3"></i>
                                        </div>
                                        <h3 class="font-weight-bold">Inspiration</h3>
                                        <p class="lead mb-0">durch vorgeschlagene Filme und Freunde</p>
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="features-item mx-auto mb-0 mb-lg-3">
                                        <div class="features-icon d-flex">
                                                <i class="fas fa-share-alt m-auto text-primary pb-3"></i>
                                        </div>
                                        <h3 class="font-weight-bold">Teile</h3>
                                        <p class="lead mb-0">Bewertungen und Meinungen zu Filmen</p>
                                </div>
                        </div>
                </div>
        </div>
</section>

<section class="galery">
        <div class="container-fluid p-0">
                <div class="row no-gutters">

                        <div class="col-lg-6 order-lg-2 text-white feature-img" style="background-image: url('../img/welcome/organize.jpg');"></div>
                        <div class="col-lg-6 order-lg-1 my-auto feature-text">
                                <h2 class="font-weight-bold">Organisiere Deine Filmelisten</h2>
                                <p class="lead mb-0">Behalte Deine Filme stets im Überlick! Speicher Deine Filme in zwei separaten Listen: Die
                                        "gesehen" und die "ansehen" Liste.</p>
                        </div>
                </div>
                <div class="row no-gutters">
                        <div class="col-lg-6 text-white feature-img" style="background-image: url('../img/welcome/inspire.jpg');"></div>
                        <div class="col-lg-6 my-auto feature-text">
                                <h2 class="font-weight-bold">Lass dich inspirieren</h2>
                                <p class="lead mb-0">Kein Plan was du schauen sollst? Hab stets den Überblick welche Filme sich Deine Freunde
                                        vermerkt oder schon gesehen haben und erhalte von Uns vorschläge zu ähnlichen Filmen</p>
                        </div>
                </div>
                <div class="row no-gutters">
                        <div class="col-lg-6 order-lg-2 text-white feature-img" style="background-image: url('../img/welcome/participate.jpg');"></div>
                        <div class="col-lg-6 order-lg-1 my-auto feature-text">
                                <h2 class="font-weight-bold">Teile deine Filme und Meinungen</h2>
                                <p class="lead mb-0">Lass deine Freunde wissen, wie dir Deine Filme gefallen haben, durch hinterlassen einer Bewertung!</p>
                        </div>
                </div>
        </div>
</section>

<section class="regist-bottom text-white text-center">
        <div class="overlay"></div>
        <div class="container">
                <div class="row">
                        <div class="col-xl-9 mx-auto">
                                <h2 class="font-weight-bold mb-4">Überzeugt? Dann geht's hier weiter:</h2>
                        </div>
                        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                                <button class="btn btn-primary btn-block btn-lg">Registrieren</button>
                        </div>
                </div>
        </div>
</section>

@endsection
