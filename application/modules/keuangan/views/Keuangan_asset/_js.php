<script type="text/javascript">
  var tabel = null;
  
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": false, 
      "ordering": true,
      "order": [],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            d.filter_kategori = $('#filter_kategori').val(); 
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "deferRender": true,
      "pageLength": 500,
      "columns": [
        { 
            "data": null,
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        // [UPDATE] Kolom Aksi dengan Tombol View
        {
          "data": "asset_id",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_detail = '<?= $this->uri . '/form_modal_view/' ?>' + data;
            // Tombol Detail
            var btnDetail = '<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_detail + '\', size: \'modal-lg\', position: \'normal\'})">' +
                            '   <i class="fas fa-eye me-2"></i> Detail' +
                            '</a>';

            return '' +
              '<div class="dropdown">' +
              '  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">' +
              '    Aksi' +
              '  </button>' +
              '  <div class="dropdown-menu dropdown-menu-end">' +
                   btnDetail +
              '  </div>' +
              '</div>';
          }
        },
        { 
            "data": "asset_kd",
            "className": "fw-bold text-dark"
        },
        { 
            "data": "beli_tgl",
            "className": "text-center",
            "render": function(d) {
                return d ? d.split('-').reverse().join('-') : '-';
            }
        },
        { 
            "data": "calc_umur_jalan",
            "width": "15%",
            "render": function(data, type, row) {
                var masa_total = parseInt(row.pakai_masa_bln) || 0;
                var umur_jalan = parseInt(data) || 0;
                var persen = (masa_total > 0) ? Math.round((umur_jalan / masa_total) * 100) : 0;
                if (persen > 100) persen = 100;
                
                var barColor = (persen >= 100) ? 'bg-purple' : 'bg-blue';
                
                return `<div>
                          <div class="d-flex justify-content-between small mb-1">
                              <span>${umur_jalan} / ${masa_total} Bln</span>
                              <span>${persen}%</span>
                          </div>
                          <div class="progress progress-xs">
                              <div class="progress-bar ${barColor}" style="width: ${persen}%"></div>
                          </div>
                        </div>`;
            }
        },
        { 
            "data": "beli_nominal",
            "className": "text-end",
            "render": function(d) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(d);
            }
        },
        { 
            "data": "depresiasi_metode",
            "className": "text-center",
            "render": function(d) {
                return `<span class="badge bg-secondary-lt text-uppercase" style="font-size:10px">${d}</span>`;
            }
        },
        { 
            "data": "calc_nilai_buku",
            "className": "text-end fw-bold text-green",
            "render": function(d) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(d);
            }
        },
        { 
            "data": "calc_status",
            "className": "text-center",
            "render": function(d) {
                if (d === 'HABIS') return '<span class="badge bg-purple-lt">Habis Susut</span>';
                return '<span class="badge bg-yellow-lt">Aktif</span>';
            }
        }
      ]
    });

    $('#filter_kategori').change(function() {
        tabel.ajax.reload();
    });
  });
</script>