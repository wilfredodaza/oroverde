<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Blog <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/plyr/plyr.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/blog.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <?= view('home_page/sections/banner', [
        'title' => 'Cultivando Historias'
    ]) ?>

    <div class="container-xxl">
        <div class="row justify-content-between align-items-center mt-5">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <h1 class=""><b><?= $banner->title_2 ?></b></h1>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12">
                <?= $banner->description ?>
            </div>
        </div>
    </div>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-academy">
            <div class="card mb-6">
                <div class="card-body mt-1">
                    <div class="row gy-6 mb-6">
                        <?php foreach($banner->details as $detail): ?>
                            <div class="col-sm-12 col-lg-6">
                                <div class="card p-2 h-100 shadow-none border rounded-3">
                                    <div class="card h-px-350 mb-5">
                                        <div class="card-body h-100">
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
                                    <div class="card-body p-3 pt-0">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <span class="badge rounded-pill bg-label-primary"><i class="ri-calendar-line"></i> <?= formatDate(date("Y-m-d", strtotime($detail->created_at))) ?></span>
                                            
                                        </div>
                                        <h5 class="card-title"><?= $detail->title ?></h5>
                                        <!-- <p class="mt-1">Cada momento en Avovite es una nueva aventura y a través de los rostros que frecuentamos adquirimos nuevos...</p> -->
                                        
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('home_page/sections/events') ?>

    <?= view('home_page/sections/contacts') ?>


<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>

<script src="<?= base_url(['assets/vendor/libs/plyr/plyr.js']) ?>"></script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
    <script>
        for (let index = 0; index < 6; index++) {
            const player = new Plyr(`#plyr-video-player-${index}`);
        }
    </script>
<?= $this->endSection() ?>