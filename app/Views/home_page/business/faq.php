<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Simulación <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/blog.css"]) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/typeahead-js/typeahead.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/nouislider/nouislider.css']) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <?= view('home_page/sections/banner') ?>
    
    <div class="container-xxl flex-grow-1 container-p-y">
    <section id="landingFAQ" class="section-py mt-0 landing-faq">
    <div class="container bg-icon-right">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-4">
                <div class="text-center">
                    <img src="<?= $banner->image ? base_url(['master/img/pages/home', $banner->image]) : base_url(['assets/img/front-pages/landing-page/sitting-girl-with-laptop.png']) ?>" alt="sitting girl with laptop" class="faq-image scaleX-n1-rtl">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="accordion mt-1" id="accordionFront-">
                <?php foreach($banner->details as $key => $faq): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="head-One-<?= $key ?>-<?= $faq->id ?>">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-<?= $key ?>-<?= $faq->id ?>" aria-expanded="false" aria-controls="faq-<?= $key ?>-<?= $faq->id ?>">
                                    <?= $faq->title ?>
                                </button>
                            </h2>
                            <div id="faq-<?= $key ?>-<?= $faq->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFront" aria-labelledby="faq-<?= $key ?>-<?= $faq->id ?>" style="">
                                <div class="accordion-body">
                                    <?= $faq->description ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
            </div>
        </div>
    </div>  
</section>
    </div>

    <?= view('home_page/sections/contacts') ?>


<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
    <script src="<?= base_url(['assets/vendor/libs/nouislider/nouislider.js']) ?>"></script>
    <!-- <script src="<?= base_url(['assets/js/forms-sliders.js']) ?>"></script> -->


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
        
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
<?= $this->endSection() ?>