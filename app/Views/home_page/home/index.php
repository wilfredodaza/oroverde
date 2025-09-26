<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Inicio <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/home.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
    <!-- Hero: Start -->
    <section id="landingHero" class="home-1 mx-3"
        style="
            background-image: url('<?= base_url(['master/img/pages/home', $banner->image ? $banner->image :'heroImage.webp']) ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
                    "
        >
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12 mt-10">
                    <h1 class="display-1 text-white"><?= $banner->title ? $banner->title : 'Los frutos del aguacate HASS Colombiano son para todos "Cultivamos y vendemos por ti"' ?></h1>
                    <div>
                        <a href="#landingPricing" class="btn text-primary btn-lg btn-secondary p-3 me-10 btn-home-1">Empezar</a>
                        <?php foreach ($banner->details as $key => $detail): ?>
                            <?php if($detail->type == "enlaces"): ?>
                                <a href="<?= strpos($detail->url, 'http') !== false ? $detail->url : base_url([$detail->url]) ?>" class="btn text-primary btn-lg btn-secondary p-3 me-10 btn-home-1"><?= $detail->title ?></a>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>

                
            </div>
            <div class="row mt-5">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="indicadores-home-1">
                        <div>
                            <div class="indicador-detail">
                                <?php foreach ($banner->details as $key => $detail): ?>
                                    <?php if($detail->type == "indicadores"): ?>
                                        <div class="mx-3 text-center">
                                            <span class="text-secondary"><?= $detail->sub_title ?></span>
                                            <p class="m-0 text-white"><?= $detail->title ?></p>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero: End -->

    <?php

        $planes = [
            (object)[
                'name'      => "3 Vites",
                'quantity'  => 3,
                'price'     => 500000,00,
                'discount'  => 0,
            ],
            (object)[
                'name'      => "10 Vites",
                'quantity'  => 10,
                'price'     => 500000,00,
                'discount'  => 5,
            ],
            (object)[
                'name'      => "20 Vites",
                'quantity'  => 20,
                'price'     => 500000,00,
                'discount'  => 10,
            ],
            (object)[
                'name'      => "30 Vites",
                'quantity'  => 30,
                'price'     => 500000,00,
                'discount'  => 15,
            ]
        ];

    ?>

    <?= view('home_page/sections/products', [
        'planes'    => $planes
    ]) ?>


    

    <section class="section-py first-section-pt help-center-header position-relative overflow-hidden pb-0 mb-10">
        <img
            class="banner-bg-img z-n1"
            src="<?= base_url(['master/img/pages/home', $how->image ? $how->image :'home-how.jpg']) ?>"
            alt="Help center header"/>
        <h5 class="text-center text-secondary"><?= $how->sub_title ? $how->sub_title : "Cómo Funciona" ?></h5>
        <h1 class="text-center text-white fw-semibold"><?= $how->title ? $how->title : "Comience su Viaje de <br>Inversor" ?></h1>
        <!-- Our great team: Start -->
        <section id="landingTeam" class="section-py landing-team pb-2">
            <div class="container bg-icon-right position-relative">
                <div class="row gy-lg-5 gy-12">
                    <?php foreach($how->details as $key => $detail): ?>
                        <?php if($detail->type == "pasos"): ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="card card-hover-border-primary mt-4 mt-lg-0 shadow-none">
                                    <div class="bg-label-primary position-relative team-image-box">
                                        <img
                                        src="<?= base_url(['master/img/pages/details', $detail->file]) ?>"
                                        class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl"
                                        alt="human image" />
                                    </div>
                                    <div class="card-body text-center">
                                        <h3 class="card-title mb-1 text-primary">Paso <?= $key + 1 ?></h3>
                                        <h5 class="card-text mb-3"><b><?= $detail->title ?></b></h5>
                                        <?= $detail->description ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100 mt-5">
                <?php foreach($how->details as $key => $detail): ?>
                    <?php if($detail->type == "enlaces"): ?>
                        <a href="<?= strpos($detail->url, 'http') !== false ? $detail->url : base_url([$detail->url]) ?>" class="btn btn-lg btn-secondary waves-effect waves-light text-primary mx-5"><?= $detail->title ?></a>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </section>
        <!-- Our great team: End -->
    </section>

    <?= view('home_page/sections/events', [
        'events'    => $events
    ]) ?>

    <?= view('home_page/sections/contacts') ?>

    

<?= $this->endSection() ?>



<?= $this->section('scripts'); ?>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
<?= $this->endSection() ?>