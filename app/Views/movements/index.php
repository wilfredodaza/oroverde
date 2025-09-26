<?= $this->extend('layouts/page'); ?>

<?= $this->section('title'); ?> - <?= $data->title ?><?= $this->endSection(); ?>


<?= $this->section('styles') ?>
    <?= $this->include('layouts/css_datatables') ?>
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/select2/select2.css']) ?>" />
    <link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/flatpickr/flatpickr.css']) ?>" />
<?= $this->endsection('styles') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <div class="col-lg-12 mt-0">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <h5 class="mb-1"><?= $data->title ?></h5>
                    </div>
                    <div id="description-indicadores"></div>
                </div>
                <div class="card-body d-flex justify-content-around flex-wrap gap-4 p-0 px-5" id="indicadores"></div>
            </div>
        </div>

        <div class="col-md-12 col-xxl-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-md-12">
                        <div class="card-body py-0">
                            <div class="col s12 card-datatable ">
                                <table class="datatables-basic table table-bordered text-center h-100" id="table_datatable"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($data->form_filter) && !empty($data->form_filter)): ?>
        <div class="row gy-2">
            <?= view('layouts/forms/filter'); ?>
        </div>
    <?php endif ?>

    <?php if(isset($data->form_cruds) && !empty($data->form_cruds)): ?>
        <div class="row gy-2">
            <?= view('layouts/forms/crud'); ?>
        </div>
    <?php endif ?>
</div>

<?= $this->endsection('content') ?>

<?= $this->section('javaScripts') ?>
    <script src="<?= base_url(['assets/vendor/libs/select2/select2.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/flatpickr/flatpickr.js']) ?>"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        const infoPage = () => (<?= json_encode($data) ?>);
    </script>
    <?= $this->include('layouts/js_datatables') ?>


    <script src="<?= base_url(['master/js/movements/index.js?v='.getCommit()]) ?>"></script>
<?= $this->endsection('javaScript') ?>