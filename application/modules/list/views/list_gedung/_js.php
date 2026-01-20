<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    var formatTglIndo = function(rawDate) {
        if(!rawDate || rawDate === '0000-00-00' || rawDate === '-') return '-';
        
        var date = new Date(rawDate);
        if (isNaN(date.getTime())) return rawDate; // Jika format invalid, kembalikan aslinya
        
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        
        return day + '/' + month + '/' + year;
    };

    tabel = $('#datatable-main').DataTable(
      {
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']], // Urut Kode Aset
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
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
        { "data": "kategori_nm" },
        // 4. NAMA GEDUNG
        { "data": "asset_nm" },
        // 5. ALAMAT
        { "data": "alamat", "render": function(d){ return d || '-'; } },
        // 6. TANGGAL
        { 
            "data": "tgl_beli_lengkap",
            "className": "text-center",
            "render": function(data) { 
                return formatTglIndo(data); 
            }
        },
        // 7. KONDISI
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = 'secondary';
            if(data == 'BAIK') color = 'green';
            if(data == 'RUSAK') color = 'red';
            if(data == 'RENOVASI') color = 'yellow';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        // 8. QR CODE
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var d = row;
                // [FIX 3] Gunakan tgl_beli_lengkap sesuai Model
                var tgl = formatTglIndo(d.tgl_beli_lengkap);
                
                // Pastikan variabel string aman (Hapus karakter aneh untuk URL QR)
                var safeKode = (d.asset_kd || '-');
                var safeKat  = (d.kategori_nm || '-');
                var safeNama = (d.asset_nm || '-').replace(/[^a-zA-Z0-9 -]/g, ''); 
                var safeAlmt = (d.alamat || '-').replace(/[^a-zA-Z0-9 -]/g, '');

                var qrString = safeKode + '@' + safeKat + '@' + safeNama + '@' + tgl + '@' + safeAlmt;
                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                var finalUrl = baseUrl + encodeURIComponent(qrString);

                return `<a href="${finalUrl}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Lihat QR Code">
                          <i class="fas fa-qrcode fa-lg"></i>
                        </a>`;
            }
        },
      ],
    });
  });
</script>