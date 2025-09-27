<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Blog <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/blog.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <?= view('home_page/sections/banner', [
        'sub_title' => 'Saberes y prácticas que posibilitan el desarrollo sostenible del Aguacate Hass'
    ]) ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center flex-wrap mb-6 gap-1">
                            <div class="d-flex align-items-center justify-content-end">
                                <a href="<?= base_url(['blog']) ?>"><i class="ri-arrow-go-back-line"></i></a>
                            </div>
                        </div>
                        <div class="card academy-content shadow-none border blog">
                            <div class="card-body pt-3">
                                <?= !empty($detail->sub_title) ? "<h5>$detail->sub_title</h5>" : "" ?>
                                <?= $detail->description ?>
                                <hr class="my-6">
                                <h5>Autor</h5>
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-4">
                                            <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1">William Bonilla</h6>
                                        <small>Desarrollador</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
<?= $this->endSection() ?>