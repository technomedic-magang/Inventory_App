<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Masuk | <?= $identitas['aplikasi_singkatan'] . ' - ' . $identitas['perusahaan_nm'] ?></title>
  <link rel="shortcut icon" href="<?= $identitas['logo'] ?>" type="image/x-icon">
  <link href="<?= base_url() ?>dist/libs/jquery-toast/jquery-toast.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/libs/fontawesome/css/all.css" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/css/tabler.min.css?1684106062" rel="stylesheet" />
  <link href="<?= base_url() ?>dist/css/itm.css?<?= time() ?>" rel="stylesheet" />
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
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }

    /* Background Image dipertahankan */
    .bg-img {
      background: url("<?= $identitas['background'] ?>") no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }

    #captcha {
      width: 100% !important;
    }

    /* --- GAYA BARU UNTUK DESAIN MODERN --- */

    /* Warna latar belakang biru gelap untuk kolom kiri */
    .bg-brand {
        background-color: #1e3a8a; /* Sesuaikan warna ini jika ingin lebih gelap/terang */
        color: white;
    }

    /* Membuat kartu login lebih lebar untuk menampung dua kolom */
    .login-container {
        max-width: 900px !important;
        width: 100%;
    }

    /* Memastikan sudut kartu melengkung bagus dan overflow hidden agar warna biru tidak keluar */
    .card-login-modern {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        border: none;
    }

    /* Styling untuk teks branding di kiri */
    .brand-title {
        font-weight: 700;
        font-size: 2rem;
        margin-top: 1rem;
    }
    .brand-subtitle {
        font-weight: 600;
        font-size: 1rem;
        opacity: 0.9;
    }
    .brand-tagline {
        font-size: 0.8rem;
        opacity: 0.7;
        margin-top: 2rem;
    }

    /* Penyesuaian padding pada layar kecil */
    @media screen and (max-width: 768px) {
        .login-container {
            max-width: 450px !important;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        /* Pada layar kecil, kolom branding di kiri mungkin perlu padding lebih kecil saat ditumpuk */
        .col-brand {
            padding: 2rem !important;
        }
    }
  </style>
  <script src="<?= base_url() ?>dist/libs/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>dist/libs/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?= base_url() ?>dist/libs/jquery-validation/dist/localization/messages_id.min.js"></script>
  <script src="<?= base_url() ?>dist/libs/jquery-toast/jquery.toast.min.js"></script>
  <script src="<?= base_url() ?>dist/js/tabler.min.js?1684106062" defer></script>
  <script src="<?= base_url() ?>dist/js/demo.min.js?1684106062" defer></script>
</head>

<body class="d-flex flex-column">
  <div class="flash-error" data-flasherror="<?= $this->session->flashdata('flash_error') ?>"></div>

  <div class="page page-center bg-img">

    <div class="container login-container py-4">
      <div class="card card-login-modern">
        <div class="row g-0">

          <div class="col-md-6 bg-brand d-flex flex-column justify-content-center align-items-center text-center p-5 col-brand">
            <div class="mb-3">
                <img src="<?= $identitas['logo'] ?>" height="80" alt="Logo">
            </div>
            <h1 class="brand-title mb-0"><?= $identitas['aplikasi_singkatan'] ?></h1>
            <h2 class="brand-subtitle mb-0">ENTERPRISE RESOURCE PLANNING</h2>
            <h3 class="brand-subtitle mt-2"><?= $identitas['perusahaan_nm'] ?></h3>

            <div class="brand-tagline">
                Sistem Informasi Terintegrasi<br>
                Aman • Cepat • Modern
            </div>
          </div>

          <div class="col-md-6 p-4 p-md-5 bg-white">
            <div class="text-center mb-3">
                <i class="fas fa-user-shield fa-3x text-primary"></i>
            </div>
            <h2 class="h2 text-center mb-1">Autentikasi</h2>
            <p class="text-muted text-center mb-4">Silakan masuk dengan akun Anda</p>

            <form id="form" action="<?= site_url() . '/app/auth/login_action' ?>" method="post" autocomplete="off" novalidate>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input class="form-control" type="text" id="u" name="u" placeholder="Nama Pengguna" autocomplete="off" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input class="form-control" type="password" id="p" name="p" placeholder="Kata Sandi" autocomplete="off" required>
                <span class="input-group-text">
                  <a href="#" onclick="showPassword()" id="show_password" class="link-secondary">
                    <i class="fas fa-eye"></i>
                  </a>
                </span>
              </div>
              <div class="mt-3 mb-3">
                <div class="row">
                  <div class="col-7">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-th"></i></span>
                      <input class="form-control" type="number" id="c" name="c" placeholder="Captcha" autocomplete="off" required>
                      <input type="hidden" id="t" name="t" value="<?= md5(date('YmdH')) ?>">
                      <span class="input-group-text">
                        <a href="#" onclick="getCaptcha()" class="link-secondary">
                          <i class="fas fa-sync"></i>
                        </a>
                      </span>
                    </div>
                  </div>
                  <div class="col-5" id="divCaptcha">
                    </div>
                </div>
              </div>
              <div class="form-footer mt-4">
                <button class="btn btn-primary btn-submit w-100 py-2" type="submit">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
              </div>
            </form>
            </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Generate Captcha
      getCaptcha();

      $("#form").validate({
        rules: {

        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          error.addClass("invalid-feedback");
          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.next("label"));
          } else if ($(element).hasClass('select2')) {
            error.insertAfter(element.next(".select2-container"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function(form) {
          $(".btn-submit").html('<i class="fas fa-spin fa-spinner"></i> Proses');
          $(".btn-submit").attr("disabled", "disabled");
          $(".btn-cancel").attr("disabled", "disabled");
          form.submit();
        }
      });

      const flashError = $(".flash-error").data("flasherror");
      if (flashError) {
        $.toast({
          heading: "Kesalahan",
          text: flashError,
          icon: "error",
          position: "top-right",
        });
      }
    })

    function showPassword() {
      var x = document.getElementById("p");
      if (x.type === "password") {
        $("#show_password").html('<i class="fas fa-eye-slash"></i>');
        x.type = "text";
      } else {
        $("#show_password").html('<i class="fas fa-eye"></i>');
        x.type = "password";
      }
    }

    function getCaptcha() {
      $.post("<?= site_url('app/auth/ajax_statement/get_captcha') ?>", {
          _is_ajax: true,
        },
        function(res) {
          $('#divCaptcha').html(res.image);
        },
        "json"
      );
    }
    if ('serviceWorker' in navigator) {
      let _base_url = '<?= base_url(); ?>';
      window.addEventListener('load', function() {
        navigator.serviceWorker.register(_base_url + 'erp-sw.js');
      });
    }
  </script>
</body>

</html>