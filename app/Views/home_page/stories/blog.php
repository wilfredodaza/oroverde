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
                        <?php foreach($banner->details as $detail): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="<?= base_url(["blog", $detail->id]) ?>">
                                    <div class="card p-2 h-100 shadow-none border rounded-3">
                                        <div class="rounded-4 text-center mb-5">
                                            <img class="img-fluid img-blog" src="<?= base_url(['master/img/pages/blogs', !empty($detail->file) ? $detail->file : 'blog_default.webp']) ?>" alt="tutor image 1">
                                            
                                        </div>
                                        <div class="card-body p-3 pt-0">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="badge rounded-pill bg-label-primary"><i class="ri-calendar-line"></i> <?= formatDate(date("Y-m-d", strtotime($detail->created_at))) ?></span>
                                                
                                            </div>
                                            <h5 class="card-title"><?= $detail->title ?></h5>
                                            <p class="mt-1"><?= truncateHtml($detail->description, 150) ?></p>
                                            
                                        </div>
                                    </div>
                                </a>
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
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
<?= $this->endSection() ?>