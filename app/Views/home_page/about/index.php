<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Sobre Nosotros <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/plyr/plyr.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/about.css?v=".getCommit()]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
    
    <?= view('home_page/sections/banner', [
        'banner'    => $banner
    ]) ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-12 g-6">
            <div class="col-md">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="text-primary"><?= $detail->sub_title ? $detail->sub_title : "Sobre Nosotros" ?></h5>
                                <h2 class="card-title"><?= $detail->title ? $detail->title : "Conoce Oro Verde" ?></h2>
                                <?= $detail->description ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img class="card-img card-img-right" src="<?= $detail->image ? base_url(['master/img/pages/home', $detail->image]) : base_url(['assets/img/elements/17.jpg']) ?>" alt="Card image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-body">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <h5><?= $why->title ? $why->title : "Por qué escogernos" ?></h5>
                    <h1><?= $why->sub_title ? $why->sub_title : 'Agricultura Sostenible con<br><span class="text-primary">Retornos Garantizados</span>' ?></h1>
                </span>

                <?php foreach ($why->details as $key => $detail): ?>
                    <?php if($detail->type == "enlaces"): ?>
                        <a href="<?= strpos($detail->url, 'http') !== false ? $detail->url : base_url([$detail->url]) ?>" class="btn text-primary btn-lg btn-secondary p-3 me-10 btn-home-1"><?= $detail->title ?></a>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
            <div class="row mb-12 g-6 align-items-center">
                <div class="col-md">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row gy-6 gy-md-0">
                                <?php foreach ($why->details as $key => $detail): ?>
                                    <?php if($detail->type == "detail_why"): ?>
                                        <div class="col-md-6">
                                            <div class="card border shadow-none mt-5">
                                                <div class="card-body text-center">
                                                    <span class="span-about">
                                                        <?= $detail->icon ? "<i class='{$detail->icon}'></i>" : '<i class="ri-blogger-line"></i>' ?>
                                                    </span>
                                                    <h5 class="my-3 text-primary"><?= $detail->title ?></h5>
                                                    <?= $detail->description ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md row">
                    <?php foreach($why->details as $key => $detail): ?>
                        <?php if($detail->type == "video_why"): ?>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-6 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="plyr__video-embed" id="plyr-video-player-<?= $detail->id ?>">
                                            <iframe
                                                src="<?= $detail->url ?>"
                                                allowfullscreen
                                                allowtransparency
                                                allow="autoplay"
                                            ></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </section>


    <?= view('home_page/sections/events', [
        'events'    => $events
    ]) ?>

    <?= view('home_page/sections/contacts') ?>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/plyr/plyr.js']) ?>"></script>

    <script>
        const why = <?= json_encode($why->details) ?>;
        why.filter(d => d.type == "video_why").map((detail) => {
            const player = new Plyr(`#plyr-video-player-${detail.id}`);
        })
    </script>
<?= $this->endSection() ?>