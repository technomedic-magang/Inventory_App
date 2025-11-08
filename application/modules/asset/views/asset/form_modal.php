<style>
    /* Sedikit style agar tabel detail lebih rapi */
    #table-detail th, #table-detail td { vertical-align: middle; }
    .btn-hapus-row { color: red; cursor: pointer; }
</style>

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label required">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label required">No. Transaksi</label>
                    <input type="text" name="no_transaksi" class="form-control" required placeholder="Contoh: IN-001">
                </div>
            </div>
            <div class="col-md-4">
                 <div class="mb-3">
                    <label class="form-label">Keterangan Header</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Catatan umum...">
                </div>
            </div>
        </div>

        <hr class="my-3"> <h4 class="mb-2">Rincian Barang Masuk</h4>
        <table class="table table-bordered table-sm" id="table-detail">
            <thead class="table-light">
                <tr>
                    <th width="40%">Nama Barang (Asset)</th>
                    <th width="20%">Jumlah Masuk</th>
                    <th>Keterangan Detail</th>
                    <th width="5%"></th> </tr>
            </thead>
            <tbody id="tbody-detail">
                <tr>
                    <td>
                        <select name="asset_id[]" class="form-select select-asset" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php if(isset($list_barang)): foreach($list_barang as $brg): ?>
                                <option value="<?= $brg['asset_id'] ?>"><?= $brg['asset_nama'] ?> (<?= $brg['asset_kode'] ?>)</option>
                            <?php endforeach; endif; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="text" name="ket_detail[]" class="form-control" placeholder="Opsional">
                    </td>
                    <td class="text-center">
                        <i class="fas fa-times btn-hapus-row" onclick="hapusBaris(this)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahBaris()">
            <i class="fas fa-plus"></i> Tambah Barang Lain
        </button>

    </div>
    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
</form>

<script>
    function tambahBaris() {
        // Ambil baris pertama sebagai template
        var barisBaru = $('#tbody-detail tr:first').clone();
        // Bersihkan nilai input di baris baru
        barisBaru.find('input').val('');
        barisBaru.find('input[type="number"]').val('1');
        barisBaru.find('select').val('');
        // Tempelkan ke paling bawah tabel
        $('#tbody-detail').append(barisBaru);
    }

    function hapusBaris(tombol) {
        // Cegah penghapusan jika hanya sisa 1 baris
        if ($('#tbody-detail tr').length > 1) {
            $(tombol).closest('tr').remove();
        } else {
            alert('Minimal harus ada satu barang!');
        }
    }
</script>