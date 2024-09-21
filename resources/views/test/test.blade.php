@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Multi-step Form</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#step1Modal">
                            Start Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="multiStepForm" action="{{ route('test.store') }}" method="POST">
        @csrf

        <!-- Step 1: PTJ Modal -->
        <div class="modal fade" id="step1Modal" tabindex="-1" aria-labelledby="step1ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="step1ModalLabel">Step 1: Hospital (PTJ) Details</h5>
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
                        <h5 class="modal-title" id="step2ModalLabel">Step 2: Section Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="bahagian">Section Name</label>
                            <input type="text" class="form-control" name="bahagian" required
                                placeholder="Enter section name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary prev-step"
                            data-bs-target="#step1Modal">Previous</button>
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
                        <h5 class="modal-title" id="step3ModalLabel">Step 3: Unit Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="unit">Unit Name</label>
                            <input type="text" class="form-control" name="unit" required
                                placeholder="Enter unit name">
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
                    var targetModal = bootstrap.Modal.getInstance(document.querySelector(
                        targetModalId));

                    currentModal.hide();
                    targetModal.show();
                });
            });

            document.getElementById('multiStepForm').addEventListener('submit', function(e) {
                e.preventDefault();
                fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
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
        });
    </script>
@endpush
