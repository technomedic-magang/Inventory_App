<script type="text/javascript">
  var tabel = null;

  function formatTglIndo(rawDate) {
      if(!rawDate || rawDate === '0000-00-00') return '-';
      var date = new Date(rawDate);
      if (isNaN(date.getTime())) return rawDate; 
      var day = String(date.getDate()).padStart(2, '0');
      var month = String(date.getMonth() + 1).padStart(2, '0');
      var year = date.getFullYear();
      return `${day}/${month}/${year}`;
  }

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[1, 'asc']], 
      "scrollX": true, 
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [
        // 0. NO
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. Kode
        { 
            "data": "asset_kd", 
            "className": "text-left fw-bold",
            "render": function(data, type, row) {
                 var uri_detail = '<?= $this->uri . '/detail_modal/' ?>' + row.asset_id;
                 return `<a href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg'})" class="text-primary text-decoration-none" title="Lihat Detail">${data}</a>`;
            }
        },
        { "data": "kategori_nm", "className": "text-left" },
        { "data": "asset_nm", "className": "text-left" },
        { "data": "merek_seri_spek", "className": "text-left", "render": function(d){ return d || '-'; } },
        // 5. Kondisi
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = 'success'; 
            if (data == 'Baru') color = 'info';
            if (data == 'RUSAK' || data == 'Rusak Berat') color = 'danger';
            if (data == 'PERBAIKAN') color = 'warning';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        { "data": "penanggungjawab", "className": "text-left fw-bold" },
        { "data": "jabatan", "className": "text-left small text-muted" },
        { "data": "lokasi", "className": "text-left" },

        // [FIX] KOLOM BULAN BELI
        { 
            "data": "asset_bln_beli", 
            "className": "text-center",
            "render": function(data) {
                var namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                                 "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                var idx = parseInt(data);
                return (idx && namaBulan[idx]) ? namaBulan[idx] : '-';
            }
        },

        // [FIX] KOLOM TAHUN BELI
        { 
            "data": "asset_thn_beli", 
            "className": "text-center",
            "render": function(data) {
                return data || '-';
            }
        },
        
        { "data": "asset_ket", "className": "text-left", "render": function(d){ return d || '-'; } },

        // QR Code
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var qrString = `${row.asset_kd}@${row.asset_nm}@${row.merek_seri_spek}@${row.lokasi}@${row.penanggungjawab}`;
                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                var finalUrl = baseUrl + encodeURIComponent(qrString);

                return `<a href="${finalUrl}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Cetak QR">
                          <i class="fas fa-qrcode fa-lg"></i>
                        </a>`;
            }
        },
      ],
    });
  });
</script>