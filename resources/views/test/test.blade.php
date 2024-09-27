@extends('layouts.app')

@section('content')
    <!-- Form Show all data Start -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12"> <!-- resize modal -->
                <div class="card">
                    <div class="card-header">Multi-step Form</div>
                    <div class="card-body">
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h3>Senarai PTJ</h3>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#step1Modal">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah PTJ
                                        </button>
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
                                                        <th>Bil</th>
                                                        <th>Kod PTJ</th>
                                                        <th>Nama PTJ</th>
                                                        <th>Pengarah</th>
                                                        <th style="text-align: center;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ptjs as $ptj)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ strtoupper($ptj->kod_ptj) }}</td>
                                                            <td>{{ strtoupper($ptj->nama_ptj) }}</td>
                                                            <td>{{ strtoupper($ptj->pengarah) }}</td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <a href="javascript:void(0)"
                                                                    onClick="viewFunc({{ $ptj->id }})"
                                                                    class="btn btn-primary btn-sm d-inline-block">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    onClick="editFunc({{ $ptj->id }})"
                                                                    class="btn btn-success btn-sm d-inline-block">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    onClick="bahagianFunc({{ $ptj->id }})"
                                                                    class="btn btn-info btn-sm d-inline-block">
                                                                    <i class="fa fa-building" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    onClick="deleteFunc({{ $ptj->id }})"
                                                                    class="btn btn-danger btn-sm d-inline-block">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {!! $ptjs->links('pagination::bootstrap-5') !!}
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
    <!-- Form Show all data End -->

    <!-- Form Modal Start -->
    <form id="multiStepForm" action="{{ route('test.store') }}" method="POST">
        @csrf
        <!-- Step 1: PTJ Modal -->
        <div class="modal fade" id="step1Modal" tabindex="-1" aria-labelledby="step1ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="step1ModalLabel">Step 1: Maklumat PTJ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_ptj">Hospital Name</label>
                            <input type="text" class="form-control" name="nama_ptj" required
                                placeholder="Enter hospital name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kod_ptj">Hospital Code</label>
                            <input type="text" class="form-control" name="kod_ptj" required
                                placeholder="Enter hospital code">
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Address</label>
                            <input type="text" class="form-control" name="alamat" required
                                placeholder="Enter hospital address">
                        </div>
                        <div class="form-group mb-3">
                            <label for="pengarah">Director</label>
                            <input type="text" class="form-control" name="pengarah" required
                                placeholder="Enter director's name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary next-step" data-bs-target="#step2Modal">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Bahagian Modal -->
        <div class="modal fade" id="step2Modal" tabindex="-1" aria-labelledby="step2ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="step2ModalLabel">Step 2: Maklumat Bahagian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="bahagian">Bahagian</label>
                            <input type="text" class="form-control" name="bahagian" required
                                placeholder="Enter section name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary prev-step"
                            data-bs-target="#step1Modal">Previous</button>
                        <button type="button" class="btn btn-primary next-step"
                            data-bs-target="#step3Modal">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Unit Modal -->
        <div class="modal fade" id="step3Modal" tabindex="-1" aria-labelledby="step3ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="step3ModalLabel">Step 3: Maklumat Unit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3 d-flex justify-content-end">
                            <label for="unit" class="me-auto ms-2">Unit</label>
                            <button type="button" class="btn btn-primary btn-sm" id="addUnit">
                                <i class="fa fa-plus"></i> Add More Unit
                            </button>
                        </div>
                        <div id="unitContainer">
                            <div class="unit-entry">
                                <div class="row align-items-center">
                                    <div class="col-10">
                                        <input type="text" name="units[]" class="form-control"
                                            placeholder="Enter unit name" required>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-unit">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary prev-step"
                            data-bs-target="#step2Modal">Previous</button>
                        <button type="submit" class="btn btn-success">Finish</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Form Modal End -->

    <!-- View PTJ Modal -->
    <div class="modal fade" id="viewPtjModal" tabindex="-1" aria-labelledby="viewPtjModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPtjModalLabel">Maklumat PTJ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row">

                        <dt class="col-sm-3">Kod PTJ:</dt>
                        <dd class="col-sm-9" id="viewKodPtj"></dd>

                        <dt class="col-sm-3">Nama PTJ:</dt>
                        <dd class="col-sm-9" id="viewNamaPtj"></dd>

                        <dt class="col-sm-3">Pengarah:</dt>
                        <dd class="col-sm-9" id="viewPengarah"></dd>

                        <dt class="col-sm-3">Alamat:</dt>
                        <dd class="col-sm-9" id="viewAlamat"></dd>

                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View PTJ Modal End -->

    <!-- Edit PTJ Modal -->
    <div class="modal fade" id="editPtjModal" tabindex="-1" aria-labelledby="editPtjModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPtjModalLabel">Edit PTJ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPtjForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_ptj_id" name="ptj_id">
                        <div class="mb-3">
                            <label for="edit_kod_ptj" class="form-label">Kod PTJ</label>
                            <input type="text" class="form-control" id="edit_kod_ptj" name="kod_ptj" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_ptj" class="form-label">Nama PTJ</label>
                            <input type="text" class="form-control" id="edit_nama_ptj" name="nama_ptj" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_pengarah" class="form-label">Pengarah</label>
                            <input type="text" class="form-control" id="edit_pengarah" name="pengarah" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updatePtjBtn">Update PTJ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit PTJ Modal End -->
@endsection

@push('scripts')
    <script>
        // Step-by-step form and save data
        document.addEventListener('DOMContentLoaded', function() {
            var modals = [
                new bootstrap.Modal(document.getElementById('step1Modal')),
                new bootstrap.Modal(document.getElementById('step2Modal')),
                new bootstrap.Modal(document.getElementById('step3Modal'))
            ];

            document.querySelectorAll('.next-step, .prev-step').forEach(function(button) {
                button.addEventListener('click', function() {
                    var currentModal = bootstrap.Modal.getInstance(this.closest('.modal'));
                    var targetModalId = this.getAttribute('data-bs-target');
                    var targetModal = bootstrap.Modal.getInstance(document.querySelector(
                        targetModalId));

                    currentModal.hide();
                    targetModal.show();
                });
            });

            var unitContainer = document.getElementById('unitContainer');
            var addUnitBtn = document.getElementById('addUnit');

            addUnitBtn.addEventListener('click', function() {
                var newUnit = document.createElement('div');
                newUnit.className = 'unit-entry mb-3';
                newUnit.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-10">
                            <input type="text" name="units[]" class="form-control" placeholder="Enter unit name" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger btn-sm remove-unit">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                unitContainer.appendChild(newUnit);
            });

            unitContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-unit') || e.target.closest('.remove-unit')) {
                    e.target.closest('.unit-entry').remove();
                }
            });

            document.getElementById('multiStepForm').addEventListener('submit', function(e) {
                e.preventDefault();
                fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        modals[2].hide();
                        alert(data.message);
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });

            document.querySelector('[data-bs-toggle="modal"][data-bs-target="#step1Modal"]').addEventListener(
                'click',
                function() {
                    modals[0].show();
                });
        });

        // PTJ View
        function viewFunc(id) {
            console.log('Viewing PTJ with id:', id);
            if (id === undefined || id === null) {
                console.error('Invalid PTJ id');
                alert('An error occurred: Invalid PTJ id');
                return;
            }

            fetch(`/ptj/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Parsed data:', data);

                    // Populate basic PTJ info
                    document.getElementById('viewNamaPtj').textContent = data.nama_ptj || 'N/A';
                    document.getElementById('viewKodPtj').textContent = data.kod_ptj || 'N/A';
                    document.getElementById('viewAlamat').textContent = data.alamat || 'N/A';
                    document.getElementById('viewPengarah').textContent = data.pengarah || 'N/A';


                    let viewPtjModal = new bootstrap.Modal(document.getElementById('viewPtjModal'));
                    viewPtjModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the data. Check the console for more details.');
                });
        }

        // PTJ Delete
        function deleteFunc(id) {
            if (confirm(
                    "Are you sure you want to delete this PTJ? This action cannot be undone and will also delete all related Bahagian and Unit records."
                )) {
                fetch(`/ptj/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (response.status === 419) { // CSRF token mismatch
                            alert('Your session has expired. Please refresh the page and try again.');
                            return;
                        }
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        location.reload(); // Reload the page to reflect the changes
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the PTJ.');
                    });
            }
        }

        function bahagianFunc(id) {
            // Redirect to the bahagian page with the PTJ id
            window.location.href = `/ptj/${id}/bahagian`;
        }

        // PTJ Edit
        function editFunc(id) {
            fetch(`/ptj/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_ptj_id').value = data.id;
                    document.getElementById('edit_nama_ptj').value = data.nama_ptj;
                    document.getElementById('edit_kod_ptj').value = data.kod_ptj;
                    document.getElementById('edit_alamat').value = data.alamat;
                    document.getElementById('edit_pengarah').value = data.pengarah;

                    let editPtjModal = new bootstrap.Modal(document.getElementById('editPtjModal'));
                    editPtjModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the PTJ data.');
                });
        }

        // PTJ Update
        document.getElementById('updatePtjBtn').addEventListener('click', function() {
            let form = document.getElementById('editPtjForm');
            let formData = new FormData(form);
            let ptjId = document.getElementById('edit_ptj_id').value;

            // Convert FormData to a plain object
            let plainFormData = Object.fromEntries(formData.entries());

            fetch(`/ptj/${ptjId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(plainFormData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        console.log('Validation errors:', data.errors);
                        let errorMessage = 'Validation errors:\n';
                        for (let field in data.errors) {
                            errorMessage += `${field}: ${data.errors[field].join(', ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        let editPtjModal = bootstrap.Modal.getInstance(document.getElementById('editPtjModal'));
                        editPtjModal.hide();
                        alert(data.message);
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the PTJ.');
                });
        });
    </script>
@endpush
