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
                                        <h5>{{ $ptj->nama_ptj }}</h5>
                                        <h6 class="mt-1">Bahagian Dan Unit</h6>
                                    </div>
                                    <div>
                                        <button class="btn btn-success btn-sm" onclick="addBahagian({{ $ptj->id }})"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Bahagian</button>
                                    </div>
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
                                                    <th class="text-center">Action</th>
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
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" onclick="deleteBahagian({{ $bahagian->id }})" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Updated Pagination -->
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $bahagians->links('pagination::bootstrap-5') }}
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
                                <button type="button" class="btn btn-success btn-sm" id="addUnitBtn"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Unit</button>
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

    <!-- Edit Bahagian Modal -->
    <div class="modal fade" id="editBahagianModal" tabindex="-1" aria-labelledby="editBahagianModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBahagianModalLabel">Edit Bahagian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBahagianForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_bahagian_id" name="bahagian_id">
                        <div class="mb-3">
                            <label for="edit_bahagian" class="form-label">Bahagian Name</label>
                            <input type="text" class="form-control" id="edit_bahagian" name="bahagian" required>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="edit_units" class="form-label">Units</label>
                                <button type="button" class="btn btn-success btn-sm" id="editAddUnitBtn"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Unit</button>
                            </div>
                            <div id="editUnitContainer">
                                <!-- Existing units will be populated here -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateBahagianBtn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Update Bahagian</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editBahagian(id) {
        $.ajax({
            url: `/bahagian/${id}/edit`,
            type: 'GET',
            success: function(response) {
                $('#edit_bahagian_id').val(response.id);
                $('#edit_bahagian').val(response.bahagian);

                // Clear existing units
                $('#editUnitContainer').empty();

                // Populate units
                response.units.forEach(function(unit) {
                    $('#editUnitContainer').append(`
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="units[]" value="${unit.unit}" required>
                            <input type="hidden" name="unit_ids[]" value="${unit.id}">
                            <button type="button" class="btn btn-danger btn-sm remove-unit">Remove</button>
                        </div>
                    `);
                });

                $('#editBahagianModal').modal('show');
            },
            error: function(xhr) {
                alert('Error fetching Bahagian data');
                console.log(xhr.responseText);
            }
        });
    }

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

    function addBahagian(ptjId) {
        $('#addBahagianModal').modal('show');
    }

    $(document).ready(function() {
        $('#addUnitBtn, #editAddUnitBtn').on('click', function() {
            var container = $(this).closest('.modal-body').find('.input-group').parent();
            container.append(`
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="units[]" required>
                    <button type="button" class="btn btn-danger btn-sm remove-unit">Remove</button>
                </div>
            `);
        });

        $(document).on('click', '.remove-unit', function() {
            $(this).closest('.input-group').remove();
        });

        $('#saveBahagianBtn').on('click', function() {
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

        $('#updateBahagianBtn').on('click', function() {
            var formData = $('#editBahagianForm').serialize();
            var bahagianId = $('#edit_bahagian_id').val();
            $.ajax({
                url: `/bahagian/${bahagianId}`,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editBahagianModal').modal('hide');
                    alert('Bahagian updated successfully');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error updating Bahagian');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
