<?= $this->extend('layouts/page'); ?>

<?= $this->section('styles'); ?>
  <link rel="stylesheet" href="<?= base_url(["assets/vendor/css/pages/cards-statistics.css"]) ?>" />
  <link rel="stylesheet" href="<?= base_url(["assets/vendor/css/pages/cards-analytics.css"]) ?>" />
  <link rel="stylesheet" href="<?= base_url(["assets/vendor/libs/swiper/swiper.css"]) ?>" />
  <link rel="stylesheet" href="<?= base_url(["assets/vendor/libs/apex-charts/apex-charts.css"]) ?>" />
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row g-6">
    <!-- Gamification Card -->
    <div class="col-md-12 col-xxl-4">
      <div class="card h-100">
        <div class="d-flex align-items-end row">
          <div class="col-md-12 order-2 order-md-1">
            <div class="card-body">
              <h4 class="card-title mb-4">Bienvenido <span class="fw-bold"><?= session('user')->name ?></span> 🎉</h4>
              <p class="mb-0">You have done 68% 😎 more sales today.</p>
              <p>Check your new badge in your profile.</p>
              <a href="javascript:;" class="btn btn-primary">View Profile</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Gamification Card -->

    <div class="col-md-12 col-xxl-8">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-center">
            <h4 class="mb-1">Proyectos</h4>
          </div>
          <div class="d-flex align-items-center justify-content-around card-subtitle">
            <div class="me-2"><b>Total Proyectos:</b> <?= number_format(count($projects), 0, '', '. ') ?></div>
              <?php
                $totalProjects = array_reduce($projects, function($carry, $project){
                    $movementsTotal = array_reduce($project->movements, function($acc, $movement){
                      return $acc + (in_array($movement->type_movement_id, ["1"]) && in_array($movement->state_id, ["7"]) ? $movement->value : 0);
                    });
                    return $carry + (in_array($project->state_id, ["4", "5"]) ? $movementsTotal : 0);
                }, 0);
              ?>
            <div class="me-2"><b>Valor Proyectos:</b> $ <?= number_format($totalProjects, 0, '', '.') ?></div>

            <?php
                $totalProjectsUnd = array_reduce($projects, function($carry, $project){
                    $movementsTotal = array_reduce($project->movements, function($acc, $movement){
                      return $acc + (in_array($movement->type_movement_id, ["1"]) && in_array($movement->state_id, ["7"]) ? $movement->details[0]->quantity : 0);
                    });
                    return $carry + (in_array($project->state_id, ["4", "5"]) ? $movementsTotal : 0);
                }, 0);
              ?>
            <div class="me-2"><b>U.P:</b> <?= number_format($totalProjectsUnd, 0, '', '.') ?></div>
          </div>
        </div>
        <div class="card-body d-flex justify-content-around flex-wrap gap-4">
          <?php foreach ($states as $key => $state): ?>
              <?php
                $countState = array_reduce($projects, function($carry, $project) use ($state) {
                    return $carry + ($project->state_id == $state->id ? 1 : 0);
                }, 0);
                $color = explode(" ", $state->background)[0];
              ?>
            <div class="d-flex align-items-center gap-4">
              <div class="avatar">
                <div class="avatar-initial bg-label-<?= $color ?> rounded">
                  <i class="<?= $state->icon ?> ri-24px"></i>
                </div>
              </div>
              <div class="card-info">
                <h5 class="mb-0"><?= number_format($countState, 0, '', '.') ?></h5>
                <p class="mb-0"><?= $state->name ?></p>
              </div>
            </div>
          <?php endforeach ?>

          
        </div>
      </div>
    </div>

    <!-- Weekly Sales with bg-->
    <div class="col-12 col-xxl-8 col-md-6">
      <div
        <?php $color = "green" ?>
        class="swiper-container swiper-container-horizontal swiper h-100"
        id="swiper-weekly-sales-with-bg">
        <div class="swiper-wrapper">
          <?php foreach($projects as $key => $project): ?>
            <?php
              $movementsTotal = array_reduce($project->movements, function($acc, $movement){
                return $acc + (in_array($movement->type_movement_id, ["1"]) && in_array($movement->state_id, ["7"]) ? $movement->value : 0);
              });
            ?>
            <div class="swiper-slide pb-5">
              <div class="row">
                <div class="col-12">
                  <h5 class="mb-1 text-center"><?= $project->name ?></h5>
                  <div class="d-flex flex-wrap justify-content-around align-items-center gap-2 mb-2">
                    <div><b>Total:</b> $ <?= number_format($movementsTotal, 0, '', '.') ?></div>
                    <div><b>Estado:</b><span class="badge <?= $project->state->background ?> <?= $project->state->font ?>"> <?= $project->state->name ?></span></div>
                  </div>
                  <div class="d-flex flex-wrap justify-content-around align-items-center gap-2 mb-2">
                    <?php
                      $fechaInicio = new DateTime($project->date);
                      $hoy = new DateTime();

                      $aniosTranscurridos = $hoy->diff($fechaInicio)->y; 
                      $vigenciaRestante = $project->project_years - $aniosTranscurridos;
                    ?>
                    <div><b>Fecha Inicio:</b> <?= $project->date ?></div>
                    <div><b>Vigencia:</b> <?= $vigenciaRestante >= 0 ? $vigenciaRestante : 0 ?> <?= $vigenciaRestante != 1 ? "años" : "año" ?> </div>
                  </div>
                  <div class="d-flex flex-wrap justify-content-around align-items-center gap-2 mb-2">
                    <?php
                      $unidsProduc = array_reduce($project->movements, function($acc, $movement){
                        return $acc + (in_array($movement->type_movement_id, ["1"]) && in_array($movement->state_id, ["7"]) ? $movement->details[0]->quantity : 0);
                      });

                      $unidsProducSale = array_reduce($project->movements, function($acc, $movement) use($stateMapping) {
                        return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, $stateMapping[2]) ? $movement->details[0]->quantity : 0);
                      });
                    ?>
                    <div><b>Unidades Productivas:</b> <?= number_format($unidsProduc, 0, "", ".") ?></div>
                    <div><b>Unidades Productivas Vendidas:</b> <?= number_format($unidsProducSale, 0, "", ".") ?></div>
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 order-2 order-md-1 mt-1">
                  <!-- <h6 class="mt-0 mt-md-4 mb-4 py-1">Movimientos del proyecto</h6> -->
                  <?php
                    $total = count($type_movements);
                    $size = ceil($total / 2);
                    $type_movements_chunks = array_chunk($type_movements, $size);
                  ?>
                  <div class="row g-4">
                    <?php foreach ($type_movements_chunks as $key => $type_movements_chunk): ?>
                      <div class="col-sm-6">
                        <ul class="list-unstyled mb-0">
                          <?php foreach ($type_movements_chunk as $key => $type_chunk): ?>
                            <li class="d-flex mb-5 align-items-center justify-content-center">
                              <?php
                                $movementTotal = array_reduce($project->movements, function($acc, $movement) use ($type_chunk, $stateMapping){
                                  return $acc + (in_array($movement->type_movement_id, [$type_chunk->id]) && in_array($movement->state_id, $stateMapping[$type_chunk->id]) ? $movement->value : 0);
                                });
                              ?>
                              <span class="badge text-<?= $type_chunk->color ?> text-darken-5 <?= $type_chunk->color ?> lighten-5">$ <?= number_format($movementTotal, 0, '', '.') ?></span>
                              <p class="mb-0 mx-2 text-truncate"><?= $type_chunk->name ?></p>
                            </li>
                          <?php endforeach ?>
                        </ul>
                      </div>
                    <?php endforeach ?>
                    <!-- <div class="col-sm-6">
                      <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-5 align-items-center">
                          <p class="mb-0 me-3 weekly-sales-text-bg-primary fw-medium">50</p>
                          <p class="mb-0 text-truncate">Accessories</p>
                        </li>
                        <li class="d-flex align-items-center">
                          <p class="mb-0 me-3 weekly-sales-text-bg-primary fw-medium">38</p>
                          <p class="mb-0 text-truncate">Computers</p>
                        </li>
                      </ul>
                    </div> -->
                  </div>
                  <!-- Total Impression & Order Chart -->
                <div class="col-lg-12 col-sm-12 col-md-12">
                  <div class="h-100">
                    <div class="card-body pb-0">
                      <div class="d-flex align-items-center justify-content-center gap-4">
                        <?php
                          $unidadesCargadas = array_reduce($project->movements, function($acc, $movement) use ($stateMapping) {
                              return $acc + (
                                  in_array($movement->type_movement_id, [1]) 
                                  && in_array($movement->state_id, $stateMapping[1]) 
                                  ? ($movement->details[0]->quantity ?? 0) 
                                  : 0
                              );
                          }, 0);
                          
                          $unidadesVendidas = array_reduce($project->movements, function($acc, $movement) use ($stateMapping) {
                              return $acc + (
                                  in_array($movement->type_movement_id, [2]) 
                                  && in_array($movement->state_id, $stateMapping[2]) 
                                  ? ($movement->details[0]->quantity ?? 0) 
                                  : 0
                              );
                          }, 0);
                          
                          // Evitar división por cero
                          $porcentaje = $unidadesCargadas > 0 
                              ? number_format(($unidadesVendidas * 100) / $unidadesCargadas, 0, '.', '') 
                              : 0;
                        ?>
                        <div>
                          <div
                            class="chart-progress"
                            data-color="primary"
                            data-series="<?= $porcentaje ?>"
                            data-icon=""></div>
                        </div>
                        <div>
                          <div class="card-info">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                              <h5 class="mb-0"><?= number_format($unidadesVendidas, 0, '', '.') ." de ". number_format($unidadesCargadas, 0, '', '.') ?> unidades</h5>
                            </div>
                            <p class="mb-0 mt-1">Total Unidades Vendidas</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Total Impression & Order Chart -->
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
        <div class="swiper-pagination text-green"></div>
      </div>
    </div>
    <!--/ Weekly Sales with bg-->

    <!-- Sales Country Chart -->
    <div class="col-12 col-xxl-4 col-md-6">
      <div class="card h-100">
        <div class="card-header pb-1">
          <div class="d-flex justify-content-between">
            <h5 class="mb-0">Movimientos</h5>
          </div>
        </div>
        <div class="card-body pb-1 px-0 pt-0">
          <div id="graph-movements"></div>
        </div>
      </div>
    </div>
    <!--/ Sales Country Chart -->
  </div>
</div>
<?php $this->endSection() ?>

<?= $this->section('javaScripts'); ?>


  <script src="<?= base_url(['assets/vendor/libs/swiper/swiper.js?v='.getCommit()]) ?>"></script>
  <script src="<?= base_url(['assets/vendor/libs/apex-charts/apexcharts.js?v='.getCommit()]) ?>"></script>

  <script>
    const getProjects = () => <?= json_encode($projects) ?>;
    const getTypeMovements = () => <?= json_encode($type_movements) ?>;
  </script>
  <!-- Page JS -->
  <script src="<?= base_url(["assets/js/dashboards-analytics.js"]) ?>"></script>
  <script src="<?= base_url(['master/js/home/admin.js?v='.getCommit()]) ?>"></script>
<?= $this->endSection() ?>