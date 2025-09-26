<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Conoce el negocio <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/plyr/plyr.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/about.css?v=".getCommit()]) ?>" />
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/bussines.css?v=".getCommit()]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<?= view('home_page/sections/banner', [
        "banner" => $banner
    ]) ?>

    <?php foreach ($details as $key => $detail): ?>
        <div class="container-xxl flex-grow-1 container-p-y bg-body <?= $key == 0 ? "mt-10" : "" ?> <?= $key == (count($details) - 1) ? "mb-10" : "" ?>">
            <div class="row g-6 px-10">
                <div class="col-md px-10">
                    <div class="card">
                        <div class="row g-0 align-items-center <?= ($key % 2) !== 0 ? "flex-direction-row-reverse" : "" ?>">
                            <div class="col-md-4">
                                <img class="card-img card-img-<?= ($key % 2) === 0 ? "left" : "right" ?>" src="<?= $detail->image ? base_url(['master/img/pages/home', $detail->image]) : base_url(['assets/img/elements/17.jpg']) ?>" alt="Card image">
                            </div>
                            <div class="col-md-8 px-10">
                                <div class="card-body px-10">
                                    <h5 class="text-primary"><?= $detail->sub_title ? $detail->sub_title : "Sobre Nosotros" ?></h5>
                                    <h2 class="card-title"><?= $detail->title ?></h2>
                                    <?= $detail->description ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <div class="container-xxl px-12 contanier-info">

        <!-- <h5 class="text-white">Cómo Avovite Transforma su Inversión en</h5> -->
        <h1 class="text-white"><?= $video->title ?></h1>
        <div class="card h-px-350">
            <div class="card-body h-100">
                <div class="plyr__video-embed" id="plyr-video-player">
                    <iframe
                        src="<?= $video->image ?>"
                        allowfullscreen
                        allowtransparency
                        allow="autoplay"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>

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

    <section class="section-py bg-body">
        <div class="container">
            <h2 class="text-center mb-6 text-primary d-flex justify-content-center align-items-end"><?= $files->title ?> <small> | <?= count($files->details) ?> archivo<?= count($files->details) == 1 ? "" : "s" ?></small></h2>
            <div class="row">
                <?php if(count($files->details) > 0): ?>
                    <div class="col-lg-10 mx-auto">
                        <div class="row gy-6 gy-md-0 justify-content-around">
                            <?php foreach($files->details as $key => $detail): ?>
                                <div class="col-lg-2 col-md-3 col-sm-6 mb-2">
                                    <a href="<?= base_url(['master/img/pages/details', $detail->file]) ?>" target="_blank">
                                        <div class="card border shadow-none">
                                            <div class="card-body text-center">
                                                <i class="<?= getIconFile($detail->file) ?>"></i>
                                                <h6 class="my-3"><?= $detail->title ?></h6>
                                                <small class="mb-3">Documento: <?= convertirPesoArchivo("master/img/pages/details/$detail->file") ?></small>
                                                <!-- <a class="btn btn-outline-primary waves-effect" href="help-center-article.html">Read More</a> -->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="d-flex justify-content-center w-100 mt-5">
            
                <a href="<?= base_url(['knowthebusiness/simulation']) ?>" class="btn btn-primary"><i class="ri-calculator-line"></i> Realizar simulación</a>
            </div>
        </div>
    </section>

<section id="landingFAQ" class="section-py mt-0 landing-faq">
    <div class="container bg-icon-right">
        <h5 class="text-center mb-2"><span class="display-5 fs-4 fw-bold"><?= $faqs->title ?></span></h5>
        <div class="row gy-5 align-items-center">
            <div class="col-lg-4">
                <div class="text-center">
                    <img src="<?= $faqs->image ? base_url(['master/img/pages/home', $faqs->image]) : base_url(['assets/img/front-pages/landing-page/sitting-girl-with-laptop.png']) ?>" alt="sitting girl with laptop" class="faq-image scaleX-n1-rtl">
                </div>
            </div>
            <?php foreach($faqs->details as $key => $faqs): ?>
                <div class="col-lg-<?= 8 / count($faqs) ?>">
                    <div class="accordion" id="accordionFront-<?= $key ?>">
                        <?php foreach($faqs as $faq): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="head-One-<?= $key ?>-<?= $faq->id ?>">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-<?= $key ?>-<?= $faq->id ?>" aria-expanded="false" aria-controls="faq-<?= $key ?>-<?= $faq->id ?>">
                                        <?= $faq->title ?>
                                    </button>
                                </h2>

                                <div id="faq-<?= $key ?>-<?= $faq->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFront-<?= $key ?>" aria-labelledby="faq-<?= $key ?>-<?= $faq->id ?>" style="">
                                    <div class="accordion-body">
                                        <?= $faq->description ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>  
</section>

<?= view('home_page/sections/contacts') ?>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/plyr/plyr.js']) ?>"></script>

    <script>
        const player = new Plyr('#plyr-video-player');
    </script>
<?= $this->endSection() ?>