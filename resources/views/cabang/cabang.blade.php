@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Semua cabang</h5>
                            </div>
                            <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop" type="button">+&nbsp; Tambah
                                Cabang</a>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="tabelcabang">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th
                                            class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kode Cabang</th>
                                        <th
                                            class="text-uppercase text-start text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Cabang</th>
                                        <th
                                            class="text-uppercase text-start text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Rekening</th>
                                        <th
                                            class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nomor Rekening</th>
                                        <th
                                            class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kode Bank</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($cabangs)
                                        @foreach ($cabangs as $key => $cabang)
                                            <tr>
                                                <td>
                                                    <p class="font-weight-bold mb-0 text-center">{{ $key + 1 }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="font-weight-bold mb-0 text-start">
                                                        {{ $cabang->kode_cabang }}
                                                    </p>
                                                </td>
                                                <td class="align-middle">
                                                    <p class="font-weight-bold mb-0 text-start">
                                                        {{ $cabang->nama_cabang }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-start">
                                                    <p class="font-weight-bold mb-0 text-start">
                                                        {{ $cabang->nama_rekening }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-start">
                                                    <p class="font-weight-bold mb-0 text-start">
                                                        {{ $cabang->nomor_rekening }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-start">
                                                    <p class="font-weight-bold mb-0 text-start">
                                                        {{ $cabang->kode_bank }}
                                                    </p>
                                                </td>
                                                <td class="text-start align-middle">
                                                    <div class="d-flex justify-content-center align-items-center pt-3">
                                                        <!-- Update Button -->
                                                        <a href="{{ route('cabang.edit', ['cabang' => encrypt($cabang->id)]) }}"
                                                            class="btn btn-info btn-icon me-1"
                                                            id="edit-{{ encrypt($cabang->id) }}">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </a>

                                                        <!-- Destroy Button -->
                                                        <form
                                                            action="{{ route('cabang.destroy', ['cabang' => encrypt($cabang->id)]) }}"
                                                            method="POST" id="delete-form-{{ encrypt($cabang->id) }}"
                                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-icon"
                                                                id="delete-{{ $cabang->id }}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center">Data Tidak Ditemukan</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
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
