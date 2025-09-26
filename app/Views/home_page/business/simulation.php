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
        <div class="row g-6">

            

            <div class="col-md">

                <!-- <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="value_vite" value="2.500.000,00" placeholder="">
                            <label for="value_vite">Valor</label>
                        </div>
                        <div id="value_vite_help" class="form-text">
                            Valor individual por Vite.
                        </div>
                    </div>
                </div> -->
                
                <div class="card mb-3 h-100">
                    <h5 class="card-header">Descuento</h5>
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Descuento</small> -->
                        <div id="slider-discount" class="my-6"></div>
                    </div>
                    <h5 class="card-header">Cantidad de Vites</h5>
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Cantidad de Vites</small> -->
                        <div id="slider-product" class="my-6"></div>
                    </div>
                </div>
            </div>

            <div class="col-md">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive text-wrap">
                            <table class="table table-sm centered" id="table-info">
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="discount_simulate" value="<?= $product->plans[0]->discount ?>">
            <input type="hidden" id="quantity_simulate" value="<?= $product->plans[0]->stock ?>">
            <input type="hidden" id="value_vite" value="<?= number_format($product->price, 0, ",", ".") ?>">

            <!-- <div class="col-md">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="form-floating">
                            <input type="number" min="3" class="form-control" id="quantity_simulate" value="3" placeholder="">
                            <label for="quantity_simulate">Cantidad de vites.</label>
                        </div>
                        <div id="quantity_simulate_help" class="form-text">
                            Cantidad minima de vites (3)
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="d-flex justify-content-center w-100 mt-5">
            <a href="javascript:void(0)" onclick="simulate()" class="btn btn-lg btn-secondary waves-effect waves-light text-primary">Calcular</a>
        </div>
    </div>

    <div class="container-xxl flex-grow-1 container-p-y mt-10 bg-body" id="div-data">
    </div>

    <?= view('home_page/sections/contacts') ?>


<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
    <script src="<?= base_url(['assets/vendor/libs/nouislider/nouislider.js']) ?>"></script>
    <!-- <script src="<?= base_url(['assets/js/forms-sliders.js']) ?>"></script> -->


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= env('key.google_maps', strtotime(date('Y-m-d H:i:s'))) ?>">
        
    </script>
    <script>
        const getProduct = () => (<?= json_encode($product) ?>);
    </script>
    <script src="<?= base_url(["master/js/home-page/index.js"]) ?>"></script>
    <script src="<?= base_url(["master/js/home-page/simulation.js?v=".getCommit()]) ?>"></script>
<?= $this->endSection() ?>