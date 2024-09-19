@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Section for {{ $ptj->nama_ptj }}</div>

                <div class="card-body">
                    <form action="{{ route('storeBahagian', $ptj->id) }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="bahagian">Section Name</label>
                            <input type="text" class="form-control" name="bahagian" required placeholder="Enter section name">
                        </div>

                        <button type="submit" class="btn btn-primary">Next: Add Unit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
