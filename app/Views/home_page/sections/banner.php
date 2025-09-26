<section class="about"style="
            background-image: url('<?= base_url(['master/img/pages/home', $banner->image ? $banner->image :'heroImage.webp']) ?>');
            background-size: cover;        /* Cubre todo el contenedor */
            background-position: center;   /* Centrada */
            background-repeat: no-repeat;
                    ">
        <div class="contanier py-7 px-10 text-center">
            <?= !empty($banner->sub_title) ? '<h5 class="text-secondary">'.$banner->sub_title.'</h5>' : "" ?>
            <?= !empty($banner->title) ?
            '<h1 class="text-white">'.$banner->title.'</h1>'
            : '<h1 class="text-white">Los frutos del aguacate HASS Colombiano son para todos<br>“Cultivamos y vendemos por ti”</h1>' ?>
            
        </div>
    </section>