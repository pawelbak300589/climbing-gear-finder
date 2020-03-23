@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <brands :brands="{{ $brands }}"></brands>
            </div>
        </div>
    </div>
@endsection
