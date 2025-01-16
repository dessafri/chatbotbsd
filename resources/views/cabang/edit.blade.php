@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Edit cabang</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form action="{{ route('cabang.update', ['cabang' => encrypt($cabang->id)]) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Add method spoofing for PUT request -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kodeCabang" class="form-label">Kode Cabang</label>
                                        <input type="text" class="form-control" id="kodeCabang" name="kode_cabang"
                                            value="{{ $cabang->kode_cabang }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaCabang" class="form-label">Nama Cabang</label>
                                        <input type="text" class="form-control" id="namaCabang" name="nama_cabang"
                                            value="{{ $cabang->nama_cabang }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaRekening" class="form-label">Nama Rekening</label>
                                        <input type="text" class="form-control" id="namaRekening" name="nama_rekening"
                                            value="{{ $cabang->nama_rekening }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomorRekening" class="form-label">Nomor Rekening</label>
                                        <input type="text" class="form-control" id="nomorRekening" name="nomor_rekening"
                                            value="{{ $cabang->nomor_rekening }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kodeBank" class="form-label">Kode Bank</label>
                                        <input type="text" class="form-control" id="kodeBank" name="kode_bank"
                                            value="{{ $cabang->kode_bank }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal trigger button -->
                            <div class="d-flex justify-content-end">
                                <!-- Use a regular submit button, instead of <a> -->
                                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">
                                    Edit Cabang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.cabang.modal-add')
@endsection
@push('styles')
    <style>
        .btn-icon {
            padding: 6px 15px;
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#tabelcabang').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            });
        });
    </script>
@endpush
