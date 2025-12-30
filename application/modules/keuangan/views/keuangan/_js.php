<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": {
        "url": "<?= base_url() ?>dist/libs/DataTables/id.json"
      },
      "autoWidth": false,
      "processing": true,  // Aktifkan indikator loading bawaan
      "serverSide": true,  // Aktifkan mode server side (Ajax)
      "ordering": true,
      "order": [[2, 'desc']], // Sort default Tgl Beli
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>", 
        "type": "POST",
        "data": function(data) { data.filter_kategori = $('#filter_kategori').val(); }
      },

      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [
        // 0. NO
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. aksi
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
        // 2. kode aset
        {
          "data": "asset_kd",
          "className": "fw-bold",
          "render": function(d, t, r) { return d + '<br><small class="text-muted">' + r.asset_nm + '</small>'; }
        },
        // 3. TGL PAKAI (Format dd-mm-yyyy)
        {
          "data": "calc_tgl", 
          "className": "text-left",
          "render": function(data) {
              return data ? data.split('-').reverse().join('-') : '';
          }
        },
        // 4. UMUR (Bulan)
        { 
          "data": "calc_umur",
          "className": "text-left",
          "render": function(d) { return '<span class="badge bg-blue-lt">' + d + ' Bln</span>'; }
        },
        // 5. HARGA BELI
        {
          "data": "calc_harga",
          "className": "text-left",
          "render": function(d) { return 'Rp ' + d; }
        },
        // 6. METODE
        {
          "data": "valuasi_metode",
          "className": "text-center",
          "render": function(d) {
              return (d === 'APRESIASI') ? '<span class="badge bg-green-lt">Apresiasi</span>' : '<span class="badge bg-red-lt">Depresiasi</span>';
          }
        },
        // 7. NILAI BUKU
        {
          "data": "calc_nilai_buku",
          "className": "text-end fw-bold",
          "render": function(d){ return 'Rp '+d; }
        },
        // 8. STATUS
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

    // Event Listener Filter (Ajax Reload)
    // Tidak reload halaman, tapi reload tabel via Ajax
    $('#filter_kategori').change(function() {
        tabel.ajax.reload(); // Ini fungsi bawaan datatables untuk refresh data
    });
  });

  // --- FUNGSI STANDAR LAINNYA ---
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

  function _modal(e, opts) {
    if(e) e.preventDefault();
    var url = (typeof opts === 'object') ? opts.uri : opts;
    var title = (typeof opts === 'object') ? (opts.title || 'Form') : 'Form';
    
    $('#modal_content').load(url, function() {
        $('#modal_title').text(title);
        $('#modal_main').modal('show');
    });
  }
  
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