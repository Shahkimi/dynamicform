@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Unit for Section: {{ $bahagian->bahagian }}</div>

                <div class="card-body">
                    <form action="{{ route('storeUnit', $bahagian->id) }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="unit">Unit Name</label>
                            <input type="text" class="form-control" name="unit" required placeholder="Enter unit name">
                        </div>

                        <button type="submit" class="btn btn-success">Finish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
