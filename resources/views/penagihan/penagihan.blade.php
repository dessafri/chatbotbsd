@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Data Penagihan') }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="d-flex flex-row-reverse">
                        <button class="m-2 d-inline-block btn btn-success">
                            Import Excel
                        </button>
                        <button class="m-2 d-inline-block btn btn-primary">
                            Jalankan Chatbot
                        </button>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="tabelpenagihan">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Customer</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nomor Handphone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Piutang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nilai Faktur</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Pembayaran</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nomor Faktur</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Cabang</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($penagihans)
                                    @foreach ($penagihans as $key => $penagihan)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 text-center">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                @if ($penagihan->status == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Terkirim</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Belum Terkirim</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nama_customer }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nomor_handphone }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nilai_faktur }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->piutang }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->pembayaran }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->nomorfaktur }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penagihan->kode_cabang }}</p>
                                            </td>
                                            <td class="text-start align-middle">
                                                <div class="d-flex justify-content-center align-items-center pt-3">
                                                    <!-- Update Button -->
                                                    <a href="{{ route('penagihan.edit', ['penagihan' => encrypt($penagihan->id)]) }}"
                                                        class="btn btn-info btn-icon me-1"
                                                        id="edit-{{ encrypt($penagihan->id) }}">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <!-- Destroy Button -->
                                                    <form
                                                        action="{{ route('penagihan.destroy', ['penagihan' => encrypt($penagihan->id)]) }}"
                                                        method="POST" id="delete-form-{{ encrypt($penagihan->id) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-icon"
                                                            id="delete-{{ $penagihan->id }}">
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
            $('#tabelpenagihan').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            });
        });
    </script>
@endpush
