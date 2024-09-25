@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $ptj->nama_ptj }} - Bahagian and Units</h1>
    <div class="d-flex justify-content-end">
        <button class="btn btn-success btn-sm" onclick="addBahagian({{ $ptj->id }})"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Bahagian</button>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bahagian</th>
                        <th>Units</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ptj->bahagians as $bahagian)
                        <tr>
                            <td>{{ $bahagian->bahagian }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($bahagian->units as $unit)
                                        <li>{{ $unit->unit }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td style="width: 1px; white-space: nowrap;">
                                <a href="javascript:void(0)" onclick="editBahagian({{ $bahagian->id }})" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="javascript:void(0)" onclick="deleteBahagian({{ $bahagian->id }})" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('test.index') }}" class="btn btn-secondary btn-sm">Back to PTJ List</a>
        <button class="btn btn-success btn-sm" onclick="addBahagian({{ $ptj->id }})"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Bahagian</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editBahagian(id) {
        // Implement edit functionality
        console.log('Edit bahagian:', id);
        // You can open a modal or redirect to an edit page
    }

    function deleteBahagian(id) {
        if (confirm('Are you sure you want to delete this bahagian?')) {
            // Implement delete functionality
            console.log('Delete bahagian:', id);
            // You should make an AJAX call to delete the bahagian
        }
    }

    function addBahagian(ptjId) {
        // Implement add functionality
        console.log('Add new bahagian for PTJ:', ptjId);
        // You can open a modal or redirect to an add page
    }
</script>
@endpush
