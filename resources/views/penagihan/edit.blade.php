@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Edit Faktur : {{ $name_faktur }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form action="{{ route('penagihan.update', ['penagihan' => encrypt($penagihan->id)]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Add method spoofing for PUT request -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kodeOrder" class="form-label">Kode Order</label>
                                        <input type="text" class="form-control" id="kodeOrder" name="kode_order"
                                            value="{{ old('kode_order', $penagihan->kode_order) }}" required
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaCustomer" class="form-label">Nama Customer</label>
                                        <input type="text" class="form-control" id="namaCustomer" name="nama_customer"
                                            value="{{ old('nama_customer', $penagihan->nama_customer) }}" required
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomorHandphone" class="form-label">Nomor Handphone</label>
                                        <input type="text" class="form-control" id="nomorHandphone"
                                            name="nomor_handphone"
                                            value="{{ old('nomor_handphone', $penagihan->nomor_handphone) }}" required
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nilaiFaktur" class="form-label">Nilai Faktur</label>
                                        <input type="text" class="form-control" id="nilaiFaktur" name="nilai_faktur"
                                            value="{{ old('nilai_faktur', formatRupiah($penagihan->nilai_faktur)) }}"
                                            required oninput="formatPembayaran(this)"
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="piutang" class="form-label">Piutang</label>
                                        <input type="text" class="form-control" id="piutang" name="piutang"
                                            value="{{ old('piutang', formatRupiah($penagihan->piutang)) }}" required
                                            oninput="formatPembayaran(this)"
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status</label><br>
                                        @if ($penagihan->status == 1)
                                            <p class="badge badge-sm bg-gradient-success">Terkirim</p>
                                        @else
                                            <p class="badge badge-sm bg-gradient-danger">Belum Terkirim</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomorFaktur" class="form-label">Nomor Faktur</label>
                                        <input type="text" class="form-control" id="nomorFaktur" name="nomorfaktur"
                                            value="{{ old('nomorfaktur', $penagihan->nomorfaktur) }}" required
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pembayaran" class="form-label">Pembayaran</label>
                                        <input type="text" class="form-control" id="pembayaran" name="pembayaran"
                                            value="{{ old('pembayaran', formatRupiah($penagihan->pembayaran)) }}" required
                                            oninput="formatPembayaran(this)"
                                            @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waktuUpload" class="form-label">Waktu Upload</label>
                                        <input type="datetime-local" class="form-control" id="waktuUpload" readonly
                                            name="waktu_upload" value="{{ old('waktu_upload', $penagihan->waktu_upload) }}"
                                            required @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waktuKirim" class="form-label">Waktu Kirim</label>
                                        <input type="datetime-local" class="form-control" id="waktuKirim" readonly
                                            name="waktu_kirim" value="{{ old('waktu_kirim', $penagihan->waktu_kirim) }}"
                                            required @if ($penagihan->status == 1) readonly @endif>
                                    </div>
                                </div>
                            </div>
                            <!-- Upload Bukti Faktur Image -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buktiFaktur" class="form-label">Bukti Faktur (Image)</label>
                                        <!-- Preview Image initially hidden -->
                                        <img id="previewBukti" class="img-thumbnail" width="150"
                                            style="display: none;" onclick="openModal(this)" />
                                        <input type="file" class="form-control" id="buktiFaktur" name="bukti_faktur"
                                            accept="image/*" onchange="previewImage(event)"
                                            @if ($penagihan->status == 1) disabled @endif>
                                    </div>
                                </div>
                                @if ($penagihan->bukti_faktur)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="existingBukti" class="form-label">Bukti Faktur</label>
                                            <div>
                                                <img src="{{ url('bukti_faktur/' . $penagihan->bukti_faktur) }}"
                                                    alt="Bukti Faktur" class="img-thumbnail" width="150"
                                                    onclick="openModal(this)"
                                                    @if ($penagihan->status == 1) style="cursor: pointer;" @endif>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- Modal for Image Preview -->
                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Bukti Faktur</h5>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Modal image -->
                                            <img id="modalImage" src="" class="img-fluid zoomable"
                                                alt="Bukti Faktur" onclick="zoomImage(event)">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">
                                    Edit Faktur
                                </button>
                            </div>
                        </form>
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

        .zoomable {
            transition: transform 0.25s ease;
            cursor: pointer;
        }

        .zoomed {
            transform: scale(2);
        }
    </style>
@endpush

@push('js')
    <script>
        function formatPembayaran(input) {
            var value = input.value;
            input.value = formatRupiah(value, 'Rp. ');
        }

        function previewImage(event) {
            // Get the file from the input
            var file = event.target.files[0];

            // Check if file exists
            if (file) {
                var reader = new FileReader();

                // Set up onload function to display the image
                reader.onload = function(e) {
                    var previewImage = document.getElementById('previewBukti');
                    previewImage.src = e.target.result;

                    // Display the image
                    previewImage.style.display = 'block'; // Show the image
                };

                // Read the file as a data URL
                reader.readAsDataURL(file);
            }
        }

        function zoomImage(event) {
            var img = event.target;

            // Toggle zooming effect
            img.classList.toggle('zoomed');
        }

        function openModal(image) {
            // Get the modal and modal image elements
            var modal = $('#imageModal');
            var modalImage = document.getElementById('modalImage');

            // Set the source of the modal image to the clicked image's source
            modalImage.src = image.src;

            // Show the modal
            modal.modal('show');
        }
        // The formatRupiah function should already be defined
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        // Apply format Rupiah to specific inputs
        $('#nilaiFaktur, #piutang, #pembayaran').on('change', function() {
            var value = $(this).val();
            console.log(value)
            $(this).val(formatRupiah(value, 'Rp. '));
        });

        // Initialize DataTable (if needed)
        $('#tabelpenagihan').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
        });
    </script>
@endpush
