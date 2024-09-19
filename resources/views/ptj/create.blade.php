@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Hospital (PTJ)</div>

                <div class="card-body">
                    <form action="{{ route('storePtj') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="nama_ptj">Hospital Name</label>
                            <input type="text" class="form-control" name="nama_ptj" required placeholder="Enter hospital name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="kod_ptj">Hospital Code</label>
                            <input type="number" class="form-control" name="kod_ptj" required placeholder="Enter hospital code">
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Address</label>
                            <input type="text" class="form-control" name="alamat" required placeholder="Enter hospital address">
                        </div>

                        <div class="form-group mb-3">
                            <label for="pengarah">Director</label>
                            <input type="text" class="form-control" name="pengarah" required placeholder="Enter director's name">
                        </div>

                        <button type="submit" class="btn btn-primary">Next: Add Section</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
