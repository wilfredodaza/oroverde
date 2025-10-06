<?php $contact = getContact(); ?>
<!-- Contact Us: Start -->
<section id="landingContact" class="section-py pt-0 landing-contact">
        <div class="container bg-icon-left position-relative">
            <div class="row gy-6">
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="bg-primary rounded-4 text-white card-body p-8">
                            <?php if(!empty($contact->sub_title)): ?>
                                <span class="fw-medium mb-1_5 tagline text-secondary">
                                    <?= $contact->sub_title ?>
                                </span>
                            <?php endif ?>
                            <?php if(!empty($contact->title)): ?>                                
                                <h1 class="text-white mb-5 title"><?= $contact->title ?></h1>
                            <?php endif ?>
                            <p class="mb-0 description">
                                <div class="row mb-12 g-6">
                                    <?php foreach ($contact->details as $key => $detail): ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $detail->title ?></h5>
                                                    <?= $detail->description ?>
                                                    <?php if(!empty($detail->url) && !empty($detail->icon)): ?>
                                                        <a href="<?= strpos($detail->url, 'http') !== false ? $detail->url : base_url([$detail->url]) ?>" class="btn btn-primary waves-effect waves-light w-100">
                                                            <?= $detail->icon ?>
                                                        </a>
                                                    <?php endif ?>
                                                    <!-- <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light">Go somewhere</a> -->

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us: End -->