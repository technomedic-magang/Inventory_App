<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title><?= $identitas['aplikasi_singkatan'] . ' - ' . $identitas['perusahaan_nm'] ?></title>
  <link rel="shortcut icon" href="<?= $identitas['logo'] ?>" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets/manifest_asset/ios/57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/manifest_asset/ios/60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets/manifest_asset/ios/72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/manifest_asset/ios/76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets/manifest_asset/ios/114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/manifest_asset/ios/120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets/manifest_asset/ios/144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/manifest_asset/ios/152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/manifest_asset/ios/180.png">
  <link rel="icon" type="image/png" sizes="512x512" href="<?= base_url() ?>assets/manifest_asset/android/android-launchericon-512-512.png">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/manifest_asset/android/android-launchericon-192-192.png">
  <!-- Toast -->
  <link href="<?= base_url() ?>dist/libs/jquery-toast/jquery-toast.min.css" rel="stylesheet" />
  <!-- Fontawesome -->
  <link href="<?= base_url() ?>dist/libs/fontawesome/css/all.css" rel="stylesheet" />
  <!-- SweetAlert -->
  <link href="<?= base_url() ?>dist/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="<?= base_url() ?>dist/libs/DataTables/datatables.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>dist/libs/DataTables/DataTables-1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- GridTable -->
  <link href="<?= base_url() ?>dist/libs/grid-table/gridTable.css?v=1.0.1" rel="stylesheet">
  <!-- CSS files -->
  <link href="<?= base_url() ?>dist/css/tabler.css?1684106062" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
  <!-- <link href="<?= base_url() ?>dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" /> -->
  <link href="<?= base_url() ?>dist/css/demo.min.css?1684106062" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/css/itm.css?v=<?= time() ?>" rel="stylesheet" />
  <!-- Select2 -->
  <link href="<?= base_url() ?>dist/libs/select2/css/select2.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/libs/select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  <!-- Daterangepicker -->
  <link href="<?= base_url() ?>dist/libs/daterangepicker/css/daterangepicker.css" rel="stylesheet" />
  <!-- Codemirror -->
  <link href="<?= base_url() ?>dist/libs/codemirror/lib/codemirror.css" rel="stylesheet" />
  <!-- Chat -->
  <link href="<?= base_url() ?>dist/css/chat.css" rel="stylesheet" />
  <!-- Chart.js -->
  <link href="<?= base_url() ?>dist/libs/Chart.js/Chart.min.css" rel="stylesheet">
  <!-- Json Viewer -->
  <link href="<?= base_url() ?>dist/libs/json-viewer/jquery.json-viewer.css" rel="stylesheet">
  <!-- Handsontable -->
  <link href="<?= base_url() ?>dist/libs/handsontable/handsontable.full.min.css" rel="stylesheet" />
  <!-- Fullcalendar -->
  <link href="<?= base_url() ?>dist/libs/fullcalendar/main.css" rel="stylesheet">
  <!-- Calendar -->
  <link href="<?= base_url() ?>dist/libs/calendar/calendar.css" rel="stylesheet">
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <style>
    /* @import url('<?= base_url() ?>dist/css/inter.css'); */

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }

    .form-disabled {
      pointer-events: none !important;
    }
  </style>
  <style>
    #form_dokumen {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 13px;
    }

    #form_dokumen input {
      border: 0;
    }

    #form_dokumen input::placeholder {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }

    #form_dokumen input {
      font-family: courier, courier new, serif;
    }

    #form_dokumen textarea {
      border: 0;
    }

    #form_dokumen textarea {
      font-family: courier, courier new, serif;
    }

    #form_dokumen textarea::placeholder {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }

    .ui-autocomplete {
      position: absolute;
      top: 0;
      left: 0;
      cursor: default;
    }

    .table-diagonal td {
      position: relative;
      overflow: hidden;
    }

    .line {
      position: absolute;
      height: 45px;
      top: 40px;
      bottom: 0;
      margin: auto;
      width: 100%;
      border-top: 1px solid #ccc;
      -webkit-transform: rotate(-20deg);
      -ms-transform: rotate(-20deg);
      transform: rotate(-20deg);
    }

    .diagonal {
      width: 150px;
      height: 40px;
    }

    .diagonal span.lb {
      position: absolute;
      top: 2px;
      left: 2px;
    }

    .diagonal span.rt {
      position: absolute;
      bottom: 2px;
      right: 2px;
    }

    div:where(.swal2-container) {
      z-index: 1160 !important;
    }
  </style>
  <!-- Handsontable custom style -->
  <style>
    .htDropdown {
      z-index: 9999 !important;
    }

    .handsontable .ht_clone_top,
    .handsontable .ht_clone_left,
    .handsontable .ht_clone_top_left_corner {
      overflow: visible !important;
    }

    .handsontable .htDropdown {
      background-color: #f0f8ff !important;
      /* Ganti dengan warna yang kamu mau */
      color: #333 !important;
      /* Warna teks */
      border: 1px solid #ccc !important;
    }

    .handsontable .htDropdown .ht_master .wtHider {
      background-color: #f0f8ff !important;
    }

    .handsontable .htDropdown .wtHolder {
      background-color: #f0f8ff !important;
    }

    .handsontable .htDropdown .ht_master td {
      background-color: #f0f8ff !important;
      color: #333 !important;
    }

    .listbox.htDimmed {
      background-color: #dfe6e9 !important;
    }

    .listbox.htDimmed:hover {
      background-color: #b2bec3 !important;
    }

    .handsontableEditor.autocompleteEditor.htMacScroll.listbox.handsontable {
      min-height: 80px !important;
    }
  </style>
  <!-- Libs JS -->
  <script src="<?= base_url() ?>dist/libs/jquery/jquery.min.js"></script>
  <!-- JQuery Validation -->
  <script src="<?= base_url() ?>dist/libs/jquery-validation/dist/jquery.validate.js"></script>
  <script src="<?= base_url() ?>dist/libs/jquery-validation/dist/localization/messages_id.min.js"></script>
  <!-- SweetAlert -->
  <script src="<?= base_url() ?>dist/libs/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- Datatables-->
  <script src="<?= base_url() ?>dist/libs/DataTables/datatables.min.js"></script>
  <!-- Toast -->
  <script src="<?= base_url() ?>dist/libs/jquery-toast/jquery.toast.min.js"></script>
  <!-- Tabler Core -->
  <script src="<?= base_url() ?>dist/js/tabler.min.js?1684106062"></script>
  <script src="<?= base_url() ?>dist/js/demo.min.js?1684106062"></script>
  <!-- Select2 -->
  <script src="<?= base_url() ?>dist/libs/select2/js/select2.full.min.js"></script>
  <!-- Chained -->
  <script src="<?= base_url() ?>dist/libs/jquery_chained/jquery.chained.min.js"></script>
  <script src="<?= base_url() ?>dist/libs/jquery_chained/jquery.chained.remote.js"></script>
  <!-- Daterangepicker -->
  <script src="<?= base_url() ?>dist/libs/momentjs/js/moment.min.js"></script>
  <script src="<?= base_url() ?>dist/libs/daterangepicker/js/daterangepicker.min.js"></script>
  <!-- Autonumeric -->
  <script src="<?= base_url() ?>dist/libs/autonumeric/autonumeric.js"></script>
  <!-- GridTable -->
  <script src="<?= base_url() ?>dist/libs/grid-table/gridTable.js?v=1.1.0"></script>
  <!-- TinyMCE -->
  <script src="<?= base_url() ?>/dist/libs/tinymce/tinymce.min.js?1684106062" defer></script>
  <!-- Autocomplete -->
  <script src="<?= base_url() ?>dist/js/autocomplete.js"></script>
  <!-- Chart.js -->
  <script src="<?= base_url() ?>dist/libs/Chart.js/Chart.min.js"></script>
  <script src="<?= base_url() ?>dist/libs/Chart.js/chartjs-plugin-labels.js"></script>
  <!-- Codemirror -->
  <script src="<?= base_url() ?>dist/libs/codemirror/lib/codemirror.js"></script>
  <script src="<?= base_url() ?>dist/libs/codemirror/addon/edit/matchbrackets.js"></script>
  <script src="<?= base_url() ?>dist/libs/codemirror/addon/comment/continuecomment.js"></script>
  <script src="<?= base_url() ?>dist/libs/codemirror/addon/comment/comment.js"></script>
  <script src="<?= base_url() ?>dist/libs/codemirror/mode/javascript/javascript.js"></script>
  <script src="<?= base_url() ?>dist/libs/codemirror/mode/sql/sql.js"></script>
  <script src="<?= base_url() ?>dist/js/inputmask.min.js"></script>
  <script src="<?= base_url() ?>dist/js/chartjs.min.js"></script>
  <script src="<?= base_url() ?>dist/js/chartjs-datalabels.min.js"></script>
  <!-- Chart -->
  <script src="<?= base_url() ?>dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
  <!-- Json Viewer -->
  <script src="<?= base_url() ?>dist/libs/json-viewer/jquery.json-viewer.js"></script>
  <!-- Handsontable -->
  <script src="<?= base_url() ?>dist/libs/handsontable/handsontable.full.min.js"></script>
  <!-- hotkeys -->
  <script src="<?= base_url() ?>dist/js/hotkeys.min.js"></script>
  <!-- Fullcalendar -->
  <script src="<?= base_url() ?>dist/libs/fullcalendar/main.min.js"></script>
  <!-- Leaflet -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <!-- Custom -->
  <script type="text/javascript">
    const _token = '<?= _token() ?>';
    const _base_url = '<?= base_url() ?>';
    const _site_url = '<?= site_url() ?>';
    const _this_uri = '<?= @$this->uri ?>';
    const _datatableLengthMenu = [
      [10, 50, 100, 500],
      [10, 50, 100, 500]
    ];
    $(window).bind("popstate", function() {
      window.location = location.href
    });

    var jqxhrAjax = {
      abort: function() {}
    };
  </script>
  <script src="<?= base_url() ?>dist/js/itm.js?v=<?= time() ?>"></script>
  <script src="<?= base_url() ?>dist/js/itm.jquery.js?v=<?= time() ?>"></script>
  <script src="<?= base_url() ?>dist/js/itm.load.js?v=<?= time() ?>"></script>
  <script src="<?= base_url() ?>dist/js/itm.canvas.js?v=<?= time() ?>"></script>
  <!-- RowGroup -->
  <script src="<?= base_url() ?>dist/js/dataTables.rowGroup.js"></script>
</head>

<body class="layout-fluid">
  <div class="page">