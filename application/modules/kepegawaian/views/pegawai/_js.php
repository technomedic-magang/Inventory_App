<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": {
        url: '<?= base_url() ?>dist/libs/DataTables/id.json',
      },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [
        [0, 'asc']
      ],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "createdRow": function(row, data, dataIndex) {
        if (data.active_st == 0) {
          $(row).addClass('bg-pink');
        }
      },
      "bFilter": false,
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_auth = '<?= $this->uri . '/form_auth_modal/' ?>' + data;
            var uri_permission = '<?= $this->uri . '/form_permission_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '     <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '          Aksi' +
              '     </button>' +
              '     <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-xl\', position: \'normal\'})">' +
              '          <?= _icon('edit') ?> Ubah' +
              '      </a>' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_auth + '\', size: \'modal-md\', position: \'normal\'})">' +
              '          <?= _icon('cog') ?> Authentication' +
              '      </a>' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus' +
              '      </a>' +
              '   </div>' +
              ' </div>' +
              '</div>';
          }
        },
        {
          "data": "pegawai_id",
          "className": "text-left",
          "sortable": false,
        },
        {
          "data": "pegawai_nm",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            if (row.sex_id == 'P') {
              return '<b class="h4 m-0"><i>' + data + '</i></b>';
            } else {
              return '<b class="h4 m-0">' + data + '</b>';
            }
          }
        },
        {
          "data": "pendek_nm",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            if (data != null) {
              if (row.sex_id == 'P') {
                return '<i>' + data + '</i>';
              } else {
                return data;
              }
            } else {
              return "";
            }
          }
        },
        {
          "data": "sex_id",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            if (row.sex_id == 'P') {
              return '<i class="fas fa-venus text-pink me-2"></i>' + data;
            } else {
              return '<i class="fas fa-mars text-blue me-2"></i>' + data;
            }
          }
        },
        {
          "data": "divisi_nm",
          "className": "text-left",
          "sortable": false,
        },
        {
          "data": "jabatan_nm",
          "className": "text-left",
          "sortable": false,
        },
        {
          "data": "pegawai_tmt",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var result = '';
            if (data != '') {
              result = toDate(data);
            }
            return result;
          }
        },
        {
          "data": "pegawai_tat",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var result = '';
            if (data != '') {
              result = toDate(data);
            }
            return result;
          }
        },
        {
          "data": "pegawai_id",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var result = '';
            if (row.pegawai_tmt != '' && row.pegawai_tmt != null) {
              if (row.pegawai_tat != '' && row.pegawai_tat != null) {
                age = exactAge(row.pegawai_tmt, row.pegawai_tat);
              } else {
                age = exactAge(row.pegawai_tmt);
              }
              result = age['years'] + ' th ' + age['months'] + ' bl ' + age['days'] + ' hr ';
            }
            return result;
          }
        },
        {
          "data": "spkl_st",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;
            if (row['spkl_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success "></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger"></i>';
            }
            return result;
          }
        },
        {
          "data": "lembur_pengajuan_st",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;
            if (row['lembur_pengajuan_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success "></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger"></i>';
            }
            return result;
          }
        },
        {
          "data": "lembur_kegiatan_st",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;
            if (row['lembur_kegiatan_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success "></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger"></i>';
            }
            return result;
          }
        },
        {
          "data": "active_st",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;
            if (row['active_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success "></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger"></i>';
            }
            return result;
          }
        }
      ],
      "rowGroup": {
        startRender: null,
        endRender: function(rows, group) {
          let tr = document.createElement('tr');
          let className = '';
          if (rows.data()[0]['active_st'] == 0) {
            className = 'bg-pink';
          }
          addCell(tr, '<span class="text-purple">Role</span> : ' + ifNull(rows.data()[0]['role_nm']), 3, className);
          addCell(tr, '<span class="text-orange">Alamat</span> : ' + ifNull(rows.data()[0]['alamat']), 3, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          addCell(tr, '', 1, className);
          return tr;
        },
        dataSrc: 0
      }
    });
    tabel.draw();
  });

  function addCell(tr, content, colSpan = 1, className) {
    let td = document.createElement('td');

    td.setAttribute('class', className);
    td.colSpan = colSpan;
    td.textContent = content;
    td.innerHTML = content;

    tr.appendChild(td);
  }
</script>