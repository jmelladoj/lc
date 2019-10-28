@extends('layouts.app')

@section('content')
    <sliders-ubicacion :ubicacion="5"></sliders-ubicacion>

    <section class="breadcrumb">
        <div class="breadcrumb-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">Top five en nuestra comunidad Pyme</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        {{ $pagina->mensaje_uno }}
                    </p>
                    <div class="table-responsive m-t-40">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="breadcrumb">
        <div class="breadcrumb-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">Nuestra comunidad Pyme</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        {{ $pagina->mensaje_dos }}
                    </p>
                    <div class="table-responsive m-t-40">
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection