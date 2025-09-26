<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Blog <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/blog.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <?= view('home_page/sections/banner', [
        'title' => 'Blog'
    ]) ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-academy">
            <div class="card mb-6">
                <div class="card-body mt-1">
                    <div class="row gy-6 mb-6">
                        <?php for($i = 0; $i < 6; $i++): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="<?= base_url(["blog", $i]) ?>">
                                    <div class="card p-2 h-100 shadow-none border rounded-3">
                                        <div class="rounded-4 text-center mb-5">
                                            <img class="img-fluid img-blog" src="../../assets/img/pages/app-academy-tutor-1.png" alt="tutor image 1">
                                        </div>
                                        <div class="card-body p-3 pt-0">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="badge rounded-pill bg-label-primary"><i class="ri-calendar-line"></i> 11 de marzo de 2025</span>
                                                <p class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                                                    <span class="text-warning"><i class="ri-user-3-line span-user"></i></span><span class="fw-normal">Oro Verde</span>
                                                </p>
                                            </div>
                                            <h5 class="card-title">Saberes y prácticas que posibilitan el desarrollo sostenible del Aguacate Hass</h5>
                                            <p class="mt-1">Cada momento en Avovite es una nueva aventura y a través de los rostros que frecuentamos adquirimos nuevos...</p>
                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endfor ?>
                    </div>
                    <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
                        <ul class="pagination mb-0">
                        <li class="page-item first">
                            <a class="page-link waves-effect" href="javascript:void(0);"><i class="tf-icon ri-skip-back-mini-line ri-22px"></i></a>
                        </li>
                        <li class="page-item prev">
                            <a class="page-link waves-effect" href="javascript:void(0);"><i class="tf-icon ri-arrow-left-s-line ri-22px"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link waves-effect" href="javascript:void(0);">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link waves-effect" href="javascript:void(0);">2</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link waves-effect" href="javascript:void(0);">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link waves-effect" href="javascript:void(0);">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link waves-effect" href="javascript:void(0);">5</a>
                        </li>
                        <li class="page-item next">
                            <a class="page-link waves-effect" href="javascript:void(0);"><i class="tf-icon ri-arrow-right-s-line ri-22px"></i></a>
                        </li>
                        <li class="page-item last">
                            <a class="page-link waves-effect" href="javascript:void(0);"><i class="tf-icon ri-skip-forward-mini-line ri-22px"></i></a>
                        </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?= view('home_page/sections/events') ?>

    <?= view('home_page/sections/contacts') ?>


<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
<?= $this->endSection() ?>