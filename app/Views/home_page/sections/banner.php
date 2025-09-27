<section class="about"style="
            background-image: url('<?= base_url(['master/img/pages/home', isset($banner) && !empty($banner->image) ? $banner->image :'heroImage.webp']) ?>');
            background-size: cover;        /* Cubre todo el contenedor */
            background-position: center;   /* Centrada */
            background-repeat: no-repeat;
                    ">
        <div class="contanier py-7 px-10 text-center">
            <?= isset($banner->title) && !empty($banner->title) ? '<h5 class="text-secondary">'.$banner->title.'</h5>' : "" ?>
            <?= isset($banner->sub_title) && !empty($banner->sub_title) ?
            '<h1 class="text-white">'.$banner->sub_title.'</h1>'
            : '<h1 class="text-white">Los frutos del aguacate HASS Colombiano son para todos<br>“Cultivamos y vendemos por ti”</h1>' ?>

            <?php if((isset($banner->button) && !empty($banner->button)) && (isset($banner->url) && !empty($banner->url))): ?>
                <a href="<?= esUrlValida($banner->url) ? $banner->url : base_url([$banner->url]) ?>" class="btn text-primary btn-lg btn-secondary p-3 me-10 btn-home-1 waves-effect waves-light"><?= $banner->button ?></a>
            <?php endif ?>
            
        </div>
    </section>