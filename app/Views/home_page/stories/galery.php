<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Galeria de Imagenes <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/plyr/plyr.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/blog.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <?= view('home_page/sections/banner', [
        'title' => 'Galeria de Imagenes'
    ]) ?>
    

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-xl-12">
                <h3 class="text-primary">Imagenes</h3>
                <div class="nav-align-left mb-6">
                    <ul class="nav nav-pills me-4" role="tablist">
                        <?php foreach($years as $key => $year): ?>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link <?= $key == 0 ? "active" : "" ?> waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#nav-<?= $year->year ?>" aria-controls="nav-<?= $year->year ?>" aria-selected="true">
                                    <?= $year->year ?>
                                </button>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach($years as $key => $year): ?>
                            <div class="tab-pane fade <?= $key == 0 ? "show active" : "" ?>" id="nav-<?= $year->year ?>" role="tabpanel">
                                <div class="row g-6">
                                    <div class="col-12">
                                        <ul class="timeline timeline-center mt-12">
                                            <?php foreach($year->groups as $key => $group): ?>
                                                <li class="timeline-item <?= $key % 2 == 0 ? "timeline-item-left" : "timeline-item-right" ?>">
                                                    <span
                                                        class="timeline-indicator timeline-indicator-primary"
                                                        data-aos="zoom-in"
                                                        data-aos-delay="200">
                                                        <i class="ri-timeline-view ri-20px"></i>
                                                    </span>
                                                    <div class="timeline-event card p-0" data-aos="fade-<?= $key % 2 == 0 ? "right" : "left" ?>">
                                                        <div class="card-body">
                                                            <div class="row g-6" data-masonry='{"percentPosition": true }'>
                                                                <?php foreach($group->images as $img): ?>
                                                                    <div class="col-sm-6 col-lg-4">
                                                                        <?php if(!empty($img->file)): ?>
                                                                            <img class="card-img" src="<?= base_url(['master/img/pages/galleries', $img->file]) ?>" alt="Card image cap" />
                                                                                                                                                <?php endif ?>
                                                                        <div class="card">
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row g-6" data-masonry='{"percentPosition": true }'>
                                                                <?php foreach($group->images as $img): ?>
                                                                    <div class="col-sm-6 col-lg-4 mx-1">
                                                                        <?php if(!empty($img->url)): ?>
                                                                            <div class="card-img">
                                                                                <div class="plyr__video-embed" style="min-height: 200px">
                                                                                    <iframe
                                                                                        src="<?= getEmbedUrl($img->url) ?>"
                                                                                        allowfullscreen
                                                                                        allowtransparency
                                                                                        allow="autoplay"
                                                                                    ></iframe>
                                                                                </div>
                                                                            </div>
                                                                        <?php endif ?>
                                                                        <div class="card">
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-event-time"><?= $group->date ?></div>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
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
    <script src="<?= base_url(['assets/vendor/libs/plyr/plyr.js']) ?>"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const masonryGrids = document.querySelectorAll('[data-masonry]');
        const msnries = [];

        masonryGrids.forEach(grid => {
            const msnry = new Masonry(grid, {
                percentPosition: true,
                itemSelector: '.col-sm-6',
            });
            msnries.push(msnry);
        });

        function initPlyrPlayers() {
            document.querySelectorAll('[id^="plyr-video-player-"]').forEach(el => {
                if (!el.classList.contains('plyr-initialized')) {
                    new Plyr(`#${el.id}`,{
                        youtube: { noCookie: true }
                    });
                    el.classList.add('plyr-initialized');
                }
            });
        }

        // Inicializa Plyr al cargar
        initPlyrPlayers();

        // Recalcular Masonry y Plyr al cambiar de pestaña
        const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabButtons.forEach(btn => {
            btn.addEventListener('shown.bs.tab', function () {
                setTimeout(() => {
                    msnries.forEach(msnry => msnry.layout());
                    initPlyrPlayers(); // 👈 re-inicializa videos
                }, 300);
            });
        });
    });
    </script>


<?= $this->endSection() ?>