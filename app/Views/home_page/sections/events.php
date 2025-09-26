<!-- Useful features: Start -->
<section id="landingFeatures" class="section-py landing-features pt-10 bg-body">
    <div class="container">
        <h5 class="text-center mb-2">
            <span class="display-3 fw-bold text-primary"><?= $events->title ? $events->title : "Oro Verde en medios" ?></span>
        </h5>
        <div class="features-icon-wrapper row gx-0 gy-12 gx-sm-6 mt-n4 mt-sm-0">
            <?php foreach($events->details as $detail): ?>
                <div class="col-lg-2 col-sm-6 text-center features-icon-box">
                    <div class="features-icon mb-4 p-1">
                        <a href="<?= strpos($detail->url, 'http') !== false ? $detail->url : base_url([$detail->url]) ?>">
                            <img class="h-100 w-100" src="<?= base_url(['master/img/pages/details', $detail->file]) ?>" alt="laptop charging" />
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<!-- Useful features: End -->