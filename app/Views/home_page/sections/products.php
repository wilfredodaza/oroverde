<!-- Real customers reviews: Start -->
<section id="landingReviews" class="py-10 landing-reviews container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h1 class="text-center text-primary mb-2"><?= $banner_product->title ?></h1>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <h3 class="text-primary"><?= $banner_product->sub_title ?></h3>
                <?= $banner_product->description ?>
            </div>
        </div>
    </div>
    <div class="row gy-6 pt-md-4 justify-content-around">
        <!-- Basic Plan: Start -->
        <?php foreach($plans as $key => $plan): ?>
            <div class="col-xl-3 col-lg-6">
                <div class="card h-100 shadow-none border">
                    <img class="card-img-top" src="<?= $plan->image ? base_url(['master/img/pages/plans', $plan->image]) : base_url(['master/img/pages/home/vite.webp']) ?>" alt="Card image cap">
                    <div class="card-header border-0 p-2 p-sm-2 h-100">
                        <h4 class="p-0 m-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 text-center text-primary fw-bold">
                                    <?= $plan->stock ?> <?= $plan->product_name ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-end align-items-center flex-wrap">
                                    <small class="te">Precio: </small>
                                    <span class="text-primary fw-bold text-price w-100">
                                        $
                                        <?php
                                            $value = $plan->product_price * $plan->stock;
                                            if($plan->discount > 0)
                                                $value = $value - (($value * $plan->discount) / 100);
                                        ?>
                                        <?= number_format($value, '2', ',', '.') ?>
                                    </span>

                                </div>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body p-2">
                        <p class="card-text text-center">Un Vite equivale a la cosecha de 1 árbol de aguacate Hass durante 20 años.</p>
                        <!-- <hr /> -->
                        <div class="text-center">
                            <a href="payment-page.html" class="btn btn-primary w-100"><i class="ri-shopping-cart-2-line"></i> Comprar ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <!-- Basic Plan: End -->
        </div>
</section>
<!-- Real customers reviews: End -->