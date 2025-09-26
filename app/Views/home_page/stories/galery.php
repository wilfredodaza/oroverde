<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Galeria de Imagenes <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/blog.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <?= view('home_page/sections/banner', [
        'title' => 'Galeria de Imagenes'
    ]) ?>
    

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-xl-12">
                <h3 class="text-primary">Imagenes <small>2025</small></h3>
                <div class="nav-align-left mb-6">
                    <ul class="nav nav-pills me-4" role="tablist">
                        <?php foreach(meses() as $key => $mes): ?>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link <?= $key == 0 ? "active" : "" ?> waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#nav-mes-<?= $mes->mes ?>" aria-controls="nav-mes-<?= $mes->mes ?>" aria-selected="true">
                                    <?= $mes->name ?>
                                </button>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach(meses() as $key => $mes): ?>
                            <div class="tab-pane fade <?= $key == 0 ? "show active" : "" ?>" id="nav-mes-<?= $mes->mes ?>" role="tabpanel">
                                <div class="row g-6" data-masonry='{"percentPosition": true }'>
                                    <?php for($i = 0; $i < 11; $i++): ?>
                                        
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="card">
                                                <img class="card-img <?= rand(0, 1) > 0.5 ? "w-px-500" : "" ?>" src="../../assets/img/elements/4.jpg" alt="Card image cap" />
                                            </div>
                                        </div>
                                    <?php endfor ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
    <script src="<?= base_url(['assets/vendor/libs/masonry/masonry.js']) ?>"></script>

<?= $this->endSection() ?>