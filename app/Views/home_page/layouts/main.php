<!doctype html>

<?php $config = getConfigPage() ?>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-wide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url(['assets/']) ?>"
  data-template="front-pages"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= isset($config->name_app) && !empty($config->name_app) ? $config->name_app : "IplanetColombia" ?> <?= $this->renderSection('title') ?></title>

    <meta name="description" content="<?= isset($config->meta_description) && !empty($config->meta_description) ? $config->meta_description : "" ?>" />
    <meta name="keywords" content="<?= isset($config->meta_keywords) && !empty($config->meta_keywords) ? $config->meta_keywords : "" ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= isset($config->favicon) && !empty($config->favicon) ? base_url(['assets/img/favicon', $config->favicon]) : base_url(['assets/img/favicon/favicon.ico']) ?>" />

    <?php
      $color_primary = isset(configInfo()['primary_color']) && !empty(configInfo()['primary_color']) ? (string) configInfo()['primary_color'] : '8e24aa';
      $secondary_color = isset(configInfo()['secundary_color']) && !empty(configInfo()['secundary_color']) ? (string) configInfo()['secundary_color'] : 'ff6e40';
      $color_primary = "$color_primary";
      $secondary_color = "$secondary_color";
    ?>

    <style>
      :root {
        --primary-color: #<?= $color_primary ?>;
        --secondary-color: #<?= $secondary_color ?>;
        --primary-rgb: <?= hexToRgb($color_primary)?>;
        --secondary-rgb: <?= hexToRgb($secondary_color) ?>;

        --primary-ligth: <?= lightenColor($color_primary, 90) ?>;
        --primary-ligth-2: <?= lightenColor($color_primary, 80) ?>;
        --primary-ligth-3: <?= lightenColor($color_primary, 70) ?>;
        
        --primary-darken: <?= darkenColor($color_primary, 50) ?>;
        --primary-darken-2: <?= darkenColor($color_primary, 60) ?>;
        --primary-darken-3: <?= darkenColor($color_primary, 70) ?>;
        --primary-darken-4: <?= darkenColor($color_primary, 80) ?>;
      }   
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url(["master/css/main.css"]) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/fonts/remixicon/remixicon.css']) ?>" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/node-waves/node-waves.css']) ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/css/rtl/core.css']) ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/css/rtl/theme-default.css']) ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url(['assets/css/demo.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/css/pages/front-page.css']) ?>" />
    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/nouislider/nouislider.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/swiper/swiper.css']) ?>" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="<?= base_url(['assets/vendor/css/pages/front-page-landing.css']) ?>" />

    <?= $this->renderSection('styles') ?>


    <!-- Helpers -->
    <script src="<?= base_url(['assets/vendor/js/helpers.js']) ?>"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url(['assets/vendor/js/template-customizer.js']) ?>"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url(['assets/js/front-config.js']) ?>"></script>
  </head>

  <body>
    <script src="<?= base_url(['assets/vendor/js/dropdown-hover.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/js/mega-dropdown.js']) ?>"></script>

    <?= view('home_page/layouts/navbar') ?>

    <!-- Sections:Start -->

    <div data-bs-spy="scroll" class="scrollspy-example">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- / Sections:End -->

    <?= view('home_page/layouts/footer') ?>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url(['assets/vendor/libs/jquery/jquery.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/popper/popper.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/js/bootstrap.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/node-waves/node-waves.js']) ?>"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url(['assets/vendor/libs/nouislider/nouislider.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/swiper/swiper.js']) ?>"></script>

    <!-- Main JS -->
    <script src="<?= base_url(['assets/js/front-main.js']) ?>"></script>

    <!-- Page JS -->
    <script src="<?= base_url(['assets/js/front-page-landing.js']) ?>"></script>

    <script src="<?= base_url(["master/js/functions/functions.js?v=".getCommit()]) ?>"></script>

    <?= $this->renderSection('scripts') ?>
  </body>
</html>
