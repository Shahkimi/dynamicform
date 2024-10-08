@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb pt-2 pb-0">
                                <!-- Add padding to the top and reduce padding at the bottom -->
                                <li class="breadcrumb-item"><a href="{{ route('test.index') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Bahagian & Unit</li>
                                </li>
                            </ol>
                        </nav>
                    </div>

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
                                            <button class="btn btn-success btn-sm"
                                                onclick="addBahagian({{ $ptj->id }})"><i class="fas fa-plus"></i></i>
                                                Tambah Bahagian</button>
                                        </div>

                                    </div>
                                    <form id="searchFormBahagian" method="POST" class="d-flex justify-content-center">
                                        @csrf
                                        <div class="input-group w-50 mb-4">
                                            <input class="form-control" id="search" name="search"
                                                placeholder="Carian...">
                                            <button type="submit" class="btn btn-primary"> <i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </form>
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
                                                            <td>{{ strtoupper($bahagian->bahagian) }}</td>
                                                            <td>
                                                                <ul class="list-unstyled mb-0">
                                                                    @foreach ($bahagian->units as $unit)
                                                                        <li>{{ strtoupper($unit->unit) }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </td>
                                                            <td style="width: 1px; white-space: nowrap;">
                                                                <a href="javascript:void(0)"
                                                                    onclick="editBahagian({{ $bahagian->id }})"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    onclick="deleteBahagian({{ $bahagian->id }})"
                                                                    class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {!! $bahagians->links('pagination::bootstrap-5') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Bahagian Modal -->
        <div class="modal fade" id="addBahagianModal" tabindex="-1" aria-labelledby="addBahagianModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBahagianModalLabel">Tambah Bahagian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBahagianForm">
                            @csrf
                            <input type="hidden" name="ptj_id" value="{{ $ptj->id }}">
                            <div class="mb-3">
                                <label for="bahagian" class="form-label">Nama Bahagian</label>
                                <input type="text" class="form-control" id="bahagian" name="bahagian" required>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="units" class="form-label">Nama Unit</label>
                                    <button type="button" class="btn btn-success btn-sm" id="addUnitBtn"><i
                                            class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Unit</button>
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
                        <button type="button" class="btn btn-primary" id="saveBahagianBtn"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Simpan Bahagian</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Bahagian Modal -->
        <div class="modal fade" id="editBahagianModal" tabindex="-1" aria-labelledby="editBahagianModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBahagianModalLabel">Edit Bahagian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editBahagianForm" action="{{ route('test.bahagian.update', ':id') }}" method="POST">
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
                                    <button type="button" class="btn btn-success btn-sm" id="editAddUnitBtn"><i
                                            class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Unit</button>
                                </div>
                                <div id="editUnitContainer">
                                    <!-- Existing units will be populated here -->
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateBahagianBtn"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Kemaskini Bahagian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Add Bahagian
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
                    url: '{{ route('bahagian.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addBahagianModal').modal('hide');
                        Swal.fire(
                            'Success!',
                            'Bahagian added successfully',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Error adding Bahagian',
                            'error'
                        );
                        console.log(xhr.responseText);
                    }
                });
            });

            // Edit Bahagian
            function editBahagian(id) {
                $.ajax({
                    url: "{{ route('test.bahagian.edit', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#edit_bahagian_id').val(response.id);
                        $('#edit_bahagian').val(response.bahagian);

                        var action = $('#editBahagianForm').attr('action');
                        action = action.replace(':id', response.id);
                        $('#editBahagianForm').attr('action', action);

                        $('#editUnitContainer').empty();

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
                        Swal.fire(
                            'Error!',
                            'Error fetching Bahagian data',
                            'error'
                        );
                        console.log(xhr.responseText);
                    }
                });
            }

            // Update Bahagian
            $('#updateBahagianBtn').on('click', function() {
                var form = $('#editBahagianForm');
                var formData = form.serialize();
                var bahagianId = $('#edit_bahagian_id').val();
                $.ajax({
                    url: form.attr('action').replace(':id', bahagianId),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#editBahagianModal').modal('hide');
                        Swal.fire(
                            'Success!',
                            'Bahagian updated successfully',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Error updating Bahagian',
                            'error'
                        );
                        console.log(xhr.responseText);
                    }
                });
            });

            // Delete Bahagian
            function deleteBahagian(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/bahagian/${id}`,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Error deleting Bahagian',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            }

            // Search Bahagian
            $('#searchFormBahagian').on('submit', function(e) {
                e.preventDefault();
                performSearch();
            });

            $('#search').on('keyup', function() {
                performSearch();
            });

            function performSearch() {
                let searchQuery = $('#search').val();
                let ptjId = {{ $ptj->id }};

                $.ajax({
                    type: 'GET',
                    url: '{{ route('bahagian.search') }}',
                    data: {
                        search: searchQuery,
                        ptj_id: ptjId
                    },
                    success: function(response) {
                        let tableBody = $('tbody');
                        tableBody.empty();

                        if (response.data.length > 0) {
                            response.data.forEach(function(bahagian) {
                                let row = `<tr>
                                    <td>${bahagian.bahagian}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            ${bahagian.units.map(unit => `<li>${unit.unit}</li>`).join('')}
                                        </ul>
                                    </td>
                                    <td style="width: 1px; white-space: nowrap;">
                                        <a href="javascript:void(0)" onclick="editBahagian(${bahagian.id})" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="deleteBahagian(${bahagian.id})" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>`;
                                tableBody.append(row);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="3" class="text-center">No results found</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Search error:', error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while searching. Please try again.',
                            'error'
                        );
                    }
                });
            }

            // Make functions globally accessible
            window.editBahagian = editBahagian;
            window.deleteBahagian = deleteBahagian;
        });

        function addBahagian(ptjId) {
            $('#addBahagianModal').modal('show');
        }
    </script>
@endpush
