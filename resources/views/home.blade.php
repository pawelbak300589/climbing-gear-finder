@extends('layouts.user')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Search</div>

                    <div class="card-body">
                        <form action="search/filter" method="post">
                            <div class="form-group">
                                <label for="">Gear Name</label>
                                <select multiple class="form-control form-control-sm" name="" id="">
                                    <option>bla</option>
                                    <option>blasdasd</option>
                                    <option>safefwf</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
