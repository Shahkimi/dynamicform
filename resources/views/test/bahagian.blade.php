@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Multi-step Form</div>
                <div class="card-body">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <div>
                                        <h4>{{ $ptj->nama_ptj }}</h4>
                                        <h5>Bahagian Dan Unit</h5>
                                    </div>
                                    <button class="btn btn-success btn-sm" onclick="addBahagian({{ $ptj->id }})"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Bahagian</button>
                                </div>

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif

                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped" id="ptjTable">
                                            <thead>
                                                <tr>
                                                    <th>Bahagian</th>
                                                    <th>Unit</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bahagians as $bahagian)
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

                                        <!-- Pagination links -->
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $bahagians->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('test.index') }}" class="btn btn-secondary btn-sm">Back to PTJ List</a>
    </div>

    <!-- Add Bahagian Modal -->
    <div class="modal fade" id="addBahagianModal" tabindex="-1" aria-labelledby="addBahagianModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBahagianModalLabel">Add New Bahagian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBahagianForm">
                        @csrf
                        <input type="hidden" name="ptj_id" value="{{ $ptj->id }}">
                        <div class="mb-3">
                            <label for="bahagian" class="form-label">Bahagian Name</label>
                            <input type="text" class="form-control" id="bahagian" name="bahagian" required>
                        </div>
                        <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="units" class="form-label">Units Name</label>
                                    <button type="button" class="btn btn-success btn-sm" id="addUnitBtn">Add Unit</button>
                                </div>
                            <div id="unitContainer">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="units[]" required>
                                    <button type="button" class="btn btn-danger btn-sm remove-unit"> Remove</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveBahagianBtn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Bahagian</button>
                </div>
            </div>
        </div>
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

    //Delete bahagian With Unit
    function deleteBahagian(id) {
        if (confirm('Are you sure you want to delete this bahagian and all its associated units?')) {
            $.ajax({
                url: `/bahagian/${id}`,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting Bahagian');
                    console.log(xhr.responseText);
                }
            });
        }
    }

    // Add Bahagian & Unit
    function addBahagian(ptjId) {
        // Show the modal
        $('#addBahagianModal').modal('show');

        // Set up event listeners
        $(document).ready(function() {
            $('#addUnitBtn').off('click').on('click', function() {
                $('#unitContainer').append(`
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="units[]" required>
                        <button type="button" class="btn btn-danger btn-sm remove-unit">Remove</button>
                    </div>
                `);
            });

            $(document).off('click', '.remove-unit').on('click', '.remove-unit', function() {
                $(this).closest('.input-group').remove();
            });

            $('#saveBahagianBtn').off('click').on('click', function() {
                var formData = $('#addBahagianForm').serialize();
                $.ajax({
                    url: '{{ route("bahagian.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addBahagianModal').modal('hide');
                        alert('Bahagian added successfully');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error adding Bahagian');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    }
</script>
@endpush
