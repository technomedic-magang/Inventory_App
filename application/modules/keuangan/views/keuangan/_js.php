<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    // Inisialisasi DataTables
    tabel = $('#datatable-main').DataTable({
      "language": {
        "url": "<?= base_url() ?>dist/libs/DataTables/id.json"
      },
      "autoWidth": false,
      "processing": true,  // Indikator loading
      "serverSide": true,  // Mode server side
      "ordering": true,
      "order": [[2, 'desc']], // Default urut berdasarkan Tgl Beli
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>", 
        "type": "POST",
        "data": function(data) { 
            // Kirim parameter filter tambahan
            data.filter_kategori = $('#filter_kategori').val(); 
        }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [
        // Kolom 0: Nomor Urut
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // Kolom 1: Tombol Aksi
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '    <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '        Aksi' +
              '    </button>' +
              '    <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus Log' +
              '      </a>' +
              '    </div>' +
              '  </div>' +
              '</div>';
          }
        },
        // Kolom 2: Kode Aset
        {
          "data": "asset_kd",
          "className": "fw-bold",
          "render": function(d, t, r) { return d + '<br><small class="text-muted">' + r.asset_nm + '</small>'; }
        },
        // Kolom 3: Tanggal Pakai
        {
          "data": "calc_tgl", 
          "className": "text-left",
          "render": function(data) {
              return data ? data.split('-').reverse().join('-') : '';
          }
        },
        // Kolom 4: Umur Aset
        { 
          "data": "calc_umur",
          "className": "text-left",
          "render": function(d) { return '<span class="badge bg-blue-lt">' + d + ' Bln</span>'; }
        },
        // Kolom 5: Harga Beli
        {
          "data": "calc_harga",
          "className": "text-left",
          "render": function(d) { return 'Rp ' + d; }
        },
        // Kolom 6: Metode Valuasi
        {
          "data": "valuasi_metode",
          "className": "text-center",
          "render": function(d) {
              return (d === 'APRESIASI') ? '<span class="badge bg-green-lt">Apresiasi</span>' : '<span class="badge bg-red-lt">Depresiasi</span>';
          }
        },
        // Kolom 7: Nilai Buku Saat Ini
        {
          "data": "calc_nilai_buku",
          "className": "text-end fw-bold",
          "render": function(d){ return 'Rp '+d; }
        },
        // Kolom 8: Status Aset
        {
          "data": "calc_status",
          "className": "text-end",
          "render": function(d) {
            var cls = 'bg-secondary-lt';
            if(d==='Berjalan') cls='bg-blue-lt';
            if(d==='Mentok Min') cls='bg-orange-lt';
            if(d==='Apresiasi') cls='bg-green-lt';
            return '<span class="badge '+cls+'">'+d+'</span>';
          }
        },
      ]
    });

    // Event listener untuk filter dropdown
    $('#filter_kategori').change(function() {
        tabel.ajax.reload(); // Reload tabel saat filter berubah
    });
  });

  // --- Fungsi Konfirmasi Tutup Buku ---
  function konfirmasiTutupBuku() {
    if (confirm('KONFIRMASI TUTUP BUKU BULANAN:\n\nApakah Anda yakin?')) {
      $.ajax({
        url: '<?= site_url($this->uri_mod . "/proses_tutup_buku") ?>',
        type: 'POST', dataType: 'json',
        data: {'<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'},
        success: function(res) {
          if (res.status == '01') { alert('Sukses'); location.reload(); } 
          else { alert(res.msg); }
        }
      });
    }
  }

  // --- Fungsi Modal Helper ---
  function _modal(e, opts) {
    if(e) e.preventDefault();
    var url = (typeof opts === 'object') ? opts.uri : opts;
    var title = (typeof opts === 'object') ? (opts.title || 'Form') : 'Form';
    
    $('#modal_content').load(url, function() {
        $('#modal_title').text(title);
        $('#modal_main').modal('show');
    });
  }
  
  // --- Fungsi Simpan Form ---
  function _save(e) {
      e.preventDefault();
      var form = $('#form');
      $.ajax({
          url: form.attr('action'), type: 'POST', data: form.serialize(), dataType: 'json',
          success: function(res){
              if(res.status == '01'){
                  $('#modal_main').modal('hide');
                  location.reload();
              } else { alert(res.msg); }
          }
      });
  }
</script>