<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            // [STANDAR] CSRF Token
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [
        // 0. NO
        {
          "data": null,
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. AKSI (DROPDOWN)
        { 
            "data": "asset_id", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                 var uri_detail = '<?= $this->uri . '/detail_modal/' ?>' + data;
                 
                 return `
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Aksi
                      </button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg', title: 'Detail Aset'})">
                            <i class="fas fa-eye me-2"></i> Detail
                        </a>
                      </div>
                    </div>
                 `;
            }
        },
        // 2. KODE ASET (LINK)
        { 
            "data": "asset_kd", 
            "className": "fw-bold"
        },
        // 3. KATEGORI
        { "data": "kategori_nm", "className": "text-left" },
        // 4. NAMA BARANG
        { "data": "asset_nm", "className": "text-left" },
        // 5. MEREK/SPEK
        { "data": "merek_spek", "className": "text-left", "render": function(d){ return d || '-'; } },
        // 6. KONDISI
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = 'secondary';
            if(data == 'BAIK') color = 'green';
            if(data == 'RUSAK') color = 'red';
            if(data == 'RUSAK BERAT') color = 'danger'; // Spesifik Mebel
            if(data == 'SEDANG' || data == 'PERBAIKAN') color = 'yellow';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        // 7. RUANGAN
        { "data": "ruangan", "className": "text-left fw-bold", "render": function(d){ return d || '-'; } },
        // 8. LANTAI
        { "data": "lantai", "className": "text-left", "render": function(d){ return d || '-'; } },
        // 9. BULAN BELI
        { 
            "data": "asset_bln_beli", 
            "className": "text-center",
            "render": function(data) {
                var namaBulan = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
                var idx = parseInt(data);
                return (idx && namaBulan[idx]) ? namaBulan[idx] : '-';
            }
        },
        // 10. TAHUN BELI
        { 
            "data": "asset_thn_beli", 
            "className": "text-center",
            "render": function(data) { return data || '-'; }
        },
        // 11. KETERANGAN
        { "data": "asset_ket", "className": "text-left", "render": function(d){ return d || '-'; } },
        // 12. QR CODE
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var d = row;
                var lokasi = (d.ruangan || '') + ' ' + (d.lantai || '');
                var qrString = `${d.asset_kd}@${d.asset_nm}@${d.merek_spek}@${lokasi}`;
                
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