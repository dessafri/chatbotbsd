<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Cabang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cabang.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kodeCabang" class="form-label">Kode Cabang</label>
                                <input type="text" class="form-control" id="kodeCabang" name="kode_cabang"
                                    placeholder="Masukkan Kode Cabang" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="namaCabang" class="form-label">Nama Cabang</label>
                                <input type="text" class="form-control" id="namaCabang" name="nama_cabang"
                                    placeholder="Masukkan Nama Cabang" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="namaRekening" class="form-label">Nama Rekening</label>
                                <input type="text" class="form-control" id="namaRekening" name="nama_rekening"
                                    placeholder="Masukkan Nama Rekening" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomorRekening" class="form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" id="nomorRekening" name="nomor_rekening"
                                    placeholder="Masukkan Nomor Rekening" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kodebank" class="form-label">Kode Bank</label>
                                <input type="text" class="form-control" id="kodebank" name="kode_bank"
                                    placeholder="Masukkan Kode Bank" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
