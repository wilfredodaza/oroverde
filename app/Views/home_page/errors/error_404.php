<?= $this->extend('home_page/layouts/main'); ?>

<?= $this->section('title'); ?> | Error 404 <?= $this->endSection() ?>

<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url(["master/css/home-page/home.css"]) ?>" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

    <section class="section mx-3 r home-1 mx-3" >
        <div class="container flex-wrap d-flex justify-content-center align-items-center">
            <h1 class="w-100 text-center">Pagina en mantenimiento</h1>
            <img src="<?= base_url(['master/img/pages/errors/mantenimiento.png']) ?>" alt="">
</div>
    </secti>
    

<?= $this->endSection() ?>



<?= $this->section('scripts'); ?>

<?= $this->endSection() ?>