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
                                        <h2>Maklumat Ptj</h2>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#step1Modal">
                                            Tambah PTJ
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
                                                        <th>No</th>
                                                        <th>Nama PTJ</th>
                                                        <th>Kod PTJ</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ptjs as $ptj)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $ptj->nama_ptj }}</td>
                                                            <td>{{ $ptj->kod_ptj }}</td>
                                                            <td style="text-align: center;">
                                                                <a href="javascript:void(0)" onClick="viewFunc({{ $ptj->id }})"
                                                                    class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</a>
                                                                <a href="javascript:void(0)" onClick="editFunc({{ $ptj->id }})"
                                                                    class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Kemaskini</a>
                                                                <a href="javascript:void(0)" onClick="deleteFunc({{ $ptj->id }})"
                                                                    class="btn btn-danger btn-sm"> <i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
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
                            <input type="text" class="form-control" name="nama_ptj" required placeholder="Enter hospital name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kod_ptj">Hospital Code</label>
                            <input type="text" class="form-control" name="kod_ptj" required placeholder="Enter hospital code">
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Address</label>
                            <input type="text" class="form-control" name="alamat" required placeholder="Enter hospital address">
                        </div>
                        <div class="form-group mb-3">
                            <label for="pengarah">Director</label>
                            <input type="text" class="form-control" name="pengarah" required placeholder="Enter director's name">
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
                            <input type="text" class="form-control" name="bahagian" required placeholder="Enter section name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary prev-step" data-bs-target="#step1Modal">Previous</button>
                        <button type="button" class="btn btn-primary next-step" data-bs-target="#step3Modal">Next</button>
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
                                        <input type="text" name="units[]" class="form-control" placeholder="Enter unit name" required>
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
                        <button type="button" class="btn btn-secondary prev-step" data-bs-target="#step2Modal">Previous</button>
                        <button type="submit" class="btn btn-success">Finish</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Form Modal End -->

@endsection

@push('scripts')
    <script>
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
                    var targetModal = bootstrap.Modal.getInstance(document.querySelector(targetModalId));

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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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

            document.querySelector('[data-bs-toggle="modal"][data-bs-target="#step1Modal"]').addEventListener('click', function() {
                modals[0].show();
            });
        });
    </script>
@endpush
