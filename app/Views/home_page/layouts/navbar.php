<?php $menus = getMenu() ?>
<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none pt-5 px-10" id="nav-page">
    <div class="navbar navbar-expand-lg landing-navbar border-top-0 px-8 py-4 px-md-8 border-radius-50">
        <!-- Menu logo wrapper: Start -->
        <div class="navbar-brand app-brand demo d-flex py-0 py-lg-6 me-6">
            <!-- Mobile menu toggle: Start-->
            <button
            class="navbar-toggler border-0 px-0 me-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="tf-icons ri-menu-fill ri-24px align-middle"></i>
            </button>
            <!-- Mobile menu toggle: End-->
            <a href="<?= base_url() ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span style="color: #666cff">
                Oro Verde
                </span>
            </span>
            </a>
        </div>
        <!-- Menu logo wrapper: End -->
        <!-- Menu wrapper: Start -->
        <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
            <button
            class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="tf-icons ri-close-fill"></i>
            </button>


            <ul class="navbar-nav me-auto p-4 p-lg-0  d-flex align-items-center justify-content-center width-100">
                <?php foreach($menus as $key => $menu):?>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" aria-current="page" href="<?= base_url([$menu->url]) ?>"><?= $menu->option ?></a>
                    </li>
                <?php endforeach ?>
            <li class="nav-item mega-dropdown">
                <a
                    href="javascript:void(0);"
                    class="nav-link dropdown-toggle navbar-ex-14-mega-dropdown mega-dropdown fw-medium"
                    aria-expanded="false"
                    data-bs-toggle="mega-dropdown"
                    data-trigger="hover">
                        <span data-i18n="Pages">Cultivando historias</span>
                </a>
                <div class="dropdown-menu p-4 p-lg-6">
                    <div class="row gy-4">
                        <div class="col-12 col-lg">
                            <!-- <div class="h6 d-flex align-items-center mb-2 mb-lg-4">
                                <div class="avatar avatar-sm flex-shrink-0 me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="ri-layout-grid-line"></i></span>
                                </div>
                                <span class="ps-1">Other</span>
                            </div> -->
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link mega-dropdown-link d-flex align-items-center" href="<?= base_url(['blog']) ?>">
                                        <i class="menu-icon tf-icons ri-circle-line me-2"></i>
                                        <span data-i18n="Pricing">Blog</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mega-dropdown-link d-flex align-items-center" href="<?= base_url(['testimonials']) ?>">
                                        <i class="menu-icon tf-icons ri-circle-line me-2"></i>
                                        <span data-i18n="Payment">Testimonios</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mega-dropdown-link d-flex align-items-center" href="<?= base_url(['galery']) ?>">
                                        <i class="menu-icon tf-icons ri-circle-line me-2"></i>
                                        <span data-i18n="Checkout">Galeria</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-medium" href="landing-page.html#landingTeam">Comprar ahora</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-medium" href="../vertical-menu-template/index.html" target="_blank">Quiero ser parte</a>
            </li>
            </ul>
        </div>
        <div class="landing-menu-overlay d-lg-none"></div>
        <!-- Menu wrapper: End -->
        <!-- Toolbar: Start -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- navbar button: Start -->
            <li>
            <a
                href="<?= base_url(['login']) ?>"
                class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4"
                target="_blank"
                ><span class="tf-icons ri-user-line me-md-1"></span
                ><span class="d-none d-md-block">Ingresar</span></a
            >
            </li>
            <!-- navbar button: End -->
        </ul>
        <!-- Toolbar: End -->
    </div>
</nav>
<!-- Navbar: End -->