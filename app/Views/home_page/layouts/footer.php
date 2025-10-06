<?php $footer = getFooter() ?>

<!-- Footer: Start -->
<footer class="landing-footer">
      <div class="footer-top bg-primary position-relative overflow-hidden">
        <div class="container position-relative">
            <?php if(!empty($footer->title)): ?>
              <h2 class="text-center text-secondary"><?= $footer->title ?></h2>
            <?php endif ?>
            <div class="d-flex justify-content-between align-items-center">
                <?php if(!empty($footer->image)): ?>
                  <div>
                      <a href="<?= base_url() ?>" class="app-brand-link">
      
                        <span class="app-brand-logo demo">
                            <span class="d-flex align-items-center justify-content-center flex-wrap">
                                <img src="<?= base_url(['master/img/pages/home', isset($footer->image) && !empty($footer->image) ? $footer->image : 'logo2.png']) ?>" alt="" height="100">
                            </span>
                        </span>
                      </a>
                  </div>
                <?php endif ?>
                <div class="d-flex justify-content-center align-items-center">
                  <?php foreach ($footer->details as $key => $detail): ?>
                    <?php if($detail->type == "enlaces"): ?>
                        <a href="<?= strpos($detail->url, 'http') !== false ? $detail->url : base_url([$detail->url]) ?>" class="btn btn-lg btn-secondary waves-effect waves-light text-primary mx-5"><?= $detail->title ?></a>
                    <?php endif ?>
                  <?php endforeach ?>
                </div>
            </div>
        </div>
      </div>
      <div class="footer-bottom py-5">
        <div
          class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
          <div class="mb-2 mb-md-0">
            <span class="footer-text"
              >©
              <script>
                document.write(new Date().getFullYear());
              </script>
              , Realizado por
            </span>
            <a href="https://pixinvent.com" target="_blank" class="footer-link fw-medium footer-theme-link"
              >Iplanet Colombia</a
            >
            <span class="footer-text">| All rights reserved.</span>
          </div>
          <div>
            <a href="https://github.com/pixinvent" class="footer-link me-4" target="_blank"
              ><i class="ri-github-fill"></i
            ></a>
            <a href="https://www.facebook.com/pixinvents/" class="footer-link me-4" target="_blank"
              ><i class="ri-facebook-circle-fill"></i
            ></a>
            <a href="https://twitter.com/pixinvents" class="footer-link me-4" target="_blank"
              ><i class="ri-twitter-fill"></i
            ></a>
            <a href="https://www.instagram.com/pixinvents/" class="footer-link" target="_blank"
              ><i class="ri-instagram-line"></i
            ></a>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer: End -->