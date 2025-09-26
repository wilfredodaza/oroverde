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

    <!-- Total Transactions & Report Chart -->
    <div class="col-12 col-xxl-12">
      <div class="card h-100">
        <div class="row row-bordered g-0 h-100">
          <div class="col-md-7 col-12 order-2 order-md-0">
            <div class="card-header">
              <h5 class="mb-0">Utilidades</h5>
            </div>
            <div class="card-body">
              <?php
                $type_utilities = array_filter($type_movements, function($tm) {
                  return $tm->id == 5; // o $tm['id'] == 2 si es array
                });
                $type_utilities = reset($type_utilities);
              ?>
              <div class="card-body d-flex justify-content-between flex-wrap gap-4">
                <?php foreach ($type_utilities->states as $key => $state): ?>
                  <?php $color = explode(" ", $state->background)[0] ?>
                  <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                      <div class="avatar-initial bg-label-<?= $color ?> rounded">
                        <i class="<?= $state->icon ?> ri-24px"></i>
                      </div>
                    </div>
                    <div class="card-info">
                      <?php
                        $total_state = array_reduce($movements, function($acc, $movement) use($state) {
                          return $acc + (in_array($movement->type_movement_id, ["5"]) && in_array($movement->state_id, [$state->id]) ? (float) $movement->value : 0);
                        }, 0);
                      ?>

                      <?php
                        $total_state_count = array_reduce($movements, function($acc, $movement) use($state) {
                          return $acc + (in_array($movement->type_movement_id, ["5"]) && in_array($movement->state_id, [$state->id]) ? 1 : 0);
                        }, 0);
                      ?>
                      
                      <h5 class="mb-0">$ <?= number_format($total_state, 0, '', '.') ?></h5>
                      <p class="mb-0"><?= $state->name ?>: <?= number_format($total_state_count, 0, '', '.') ?></p>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-12">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <h5 class="mb-1">Balance</h5>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 border-end">
                  <div class="d-flex flex-column align-items-center">
                    <div class="avatar">
                      <div class="avatar-initial bg-label-red rounded-3">
                        <div class="ri-line-chart-line ri-24px"></div>
                      </div>
                    </div>
                    <p class="mt-3 mb-1">Valor Invertido</p>
                    <?php
                      $total_sale = array_reduce($movements, function($acc, $movement) use($stateMapping) {
                        return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, $stateMapping[2]) ? $movement->value : 0);
                      }, 0);
                    ?>
                    
                    <h6 class="mb-0">$ <?= number_format($total_sale, 0, '', '.') ?></h6>
                  </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 border-end">
                  <div class="d-flex flex-column align-items-center">
                    <div class="avatar">
                      <div class="avatar-initial bg-label-blue rounded-3">
                        <div class="ri-wallet-3-fill ri-24px"></div>
                      </div>
                    </div>
                    <p class="mt-3 mb-1">Valor Utilidades</p>
                    <?php
                      $total_utilities = array_reduce($movements, function($acc, $movement) use($stateMapping) {
                        return $acc + (in_array($movement->type_movement_id, ["5"]) && in_array($movement->state_id, $stateMapping[5]) ? (float) $movement->total_x_payable : 0);
                      }, 0);
                    ?>
                    
                    <h6 class="mb-0">$ <?= number_format($total_utilities, 0, '', '.') ?></h6>
                  </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 border-end">
                  <div class="d-flex flex-column align-items-center">
                    <div class="avatar">
                      <div class="avatar-initial bg-label-green rounded-3">
                        <div class="ri-money-dollar-circle-line ri-24px"></div>
                      </div>
                    </div>
                    <?php
                    $retorno_valor = $total_utilities - $total_sale;
                    
                    // evitar división por cero
                    $retorno_porcentaje = $total_sale > 0
                        ? ($total_utilities / $total_sale) * 100
                        : 0;
                    ?>
                    
                    <p class="mt-3 mb-1">Retorno</p>
                    <h6 class="mb-0 text-<?= $retorno_valor < 0 ? "red" : "green" ?>">
                      $ <?= number_format($retorno_valor, 0, '', '.') ?>
                    </h6>
                    <h6 class="mb-0">
                      <?= number_format($retorno_porcentaje, 2, '.', '') ?>%
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Total Transactions & Report Chart -->

    
    <!-- Sessions line chart -->
    <?php
      $movements_sales = array_reduce($movements, function($acc, $movement) use($stateMapping) {
        (in_array($movement->type_movement_id, ["2"]) ? $acc[] = $movement : null);
        return $acc;
      });
    ?>

    <div class="col-xxl-8 col-12">
      <div class="card h-100">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center mb-1 flex-wrap">
            <h5 class="mb-0 me-1">Inversiones</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Estado</th>
                  <th>Valor</th>
                  <th>Cantidad</th>
                  <th>Und. Productivas</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <?php
                  $type_sales = array_filter($type_movements, function($tm) {
                    return $tm->id == 2; // o $tm['id'] == 2 si es array
                  })[0];
                ?>
                <?php foreach ($type_sales->states as $key => $state): ?>
                  
                  <?php
                    $total_state_quantity = array_reduce($movements, function($acc, $movement) use($state) {
                      return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, [$state->id]) ? (int) $movement->detail->quantity : 0);
                    }, 0);
                  ?>

                  <?php if($total_state_quantity > 0): ?>
                    <tr>
                      <td><span class="badge <?= $state->background ?> <?= $state->font ?>"> <?= $state->name ?></span></td>
                      <td>
                        <?php
                          $total_state = array_reduce($movements, function($acc, $movement) use($state) {
                            return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, [$state->id]) ? $movement->value : 0);
                          }, 0);
                        ?>
                        $ <?= number_format($total_state, 0, '', '.') ?>
                      </td>
                      <td>
                      <?php
                          $total_state_count = array_reduce($movements, function($acc, $movement) use($state) {
                            return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, [$state->id]) ? 1 : 0);
                          }, 0);
                        ?>
                        <?= number_format($total_state_count, 0, '', '.') ?>
                      </td>
                      <td>
                        <?= number_format($total_state_quantity, 0, '', '.') ?>
                      </td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
                <tr class="grey lighten-4">
                  <td>Total Valido</td>
  
                  <td>
                    <?php
                      $total_state = array_reduce($movements, function($acc, $movement) use($stateMapping) {
                        return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, $stateMapping[2]) ? $movement->value : 0);
                      }, 0);
                    ?>
                    $ <?= number_format($total_state, 0, '', '.') ?>
                  </td>
  
                  <td>
                    <?php
                      $total_state_count = array_reduce($movements, function($acc, $movement) use($stateMapping) {
                        return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, $stateMapping[2]) ? 1 : 0);
                      }, 0);
                    ?>
                    <?= number_format($total_state_count, 0, '', '.') ?>
                  </td>
                  
                  <td>
                    <?php
                      $total_state_quantity = array_reduce($movements, function($acc, $movement) use($stateMapping) {
                        return $acc + (in_array($movement->type_movement_id, ["2"]) && in_array($movement->state_id, $stateMapping[2]) ? $movement->detail->quantity : 0);
                      }, 0);
                    ?>
                    <?= number_format($total_state_quantity, 0, '', '.') ?>
                  </td>
                </tr>
              </tbody>
              <thead>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--/ Sessions line chart -->

    <!-- Creditos -->

    <div class="col-12 col-xl-4">
      <div class="card h-100">
        <div class="row">
          <div class="col-md-7 col-12 border-end">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <h5 class="mb-1">Créditos</h5>
                <?php
                  $movementsCredits = array_reduce($movements, function($acc, $movement) use($stateMapping) {
                    (in_array($movement->type_movement_id, ["2"]) && in_array($movement->payment_method_id, ["2"]) && in_array($movement->state_id, $stateMapping["2"]) ? $acc[] = $movement : null);
                    return $acc;
                  });
                ?>

                <!-- Desde $TypesMovements obtener el tipo 2 -->

                <?php
                  $type2 = array_filter($type_movements, function($tm) {
                    return $tm->id == 2; // o $tm['id'] == 2 si es array
                  });

                  $total_credits = array_reduce($movements, function($acc, $movement) use($stateMapping){
                    (in_array($movement->type_movement_id, ["2"]) && in_array($movement->payment_method_id, ["2"]) && in_array($movement->state_id, $stateMapping["2"]) ? $acc += (float) $movement->value : 0);
                    return $acc;
                  }, 0);

                  $total_credits_count = array_reduce($movements, function($acc, $movement) use($stateMapping){
                    (in_array($movement->type_movement_id, ["2"]) && in_array($movement->payment_method_id, ["2"]) && in_array($movement->state_id, $stateMapping["2"]) ? $acc += 1 : 0);
                    return $acc;
                  }, 0);

                  $total_credits_payable = array_reduce($movements, function($acc, $movement) use($stateMapping){
                    if ((int)$movement->type_movement_id == 2 && (int)$movement->payment_method_id == 2 && in_array($movement->state_id, $stateMapping["2"])) {
                        $acc += (float)$movement->total_x_payable;
                    }
                    return $acc;
                }, 0);
                ?>
              </div>
            </div>
            <div class="card-body pt-4">
              <div class="d-flex align-items-center mb-6">
                <div class="avatar">
                  <div class="avatar-initial bg-label-orange rounded">
                    <i class="ri-bank-card-line ri-24px"></i>
                  </div>
                </div>
                <div class="ms-3 d-flex flex-column">
                  <h6 class="mb-1">Total Créditos</h6>
                  <small>$ <?= number_format($total_credits, 0, '', '.') ?></small>
                </div>
              </div>
              <div class="d-flex align-items-center mb-6">
                <div class="avatar">
                  <div class="avatar-initial bg-label-green rounded">
                    <i class="ri-money-dollar-box-line ri-24px"></i>
                  </div>
                </div>
                <div class="ms-3 d-flex flex-column">
                  <h6 class="mb-1">Total pagado</h6>
                  <small>$ <?= number_format($total_credits_payable, 0, '', '.') ?></small>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="avatar">
                  <div class="avatar-initial bg-label-indigo rounded">
                    <i class="ri-coins-line ri-24px"></i>
                  </div>
                </div>
                <div class="ms-3 d-flex flex-column">
                  <h6 class="mb-1">Valor por pagar</h6>
                  <small>$ <?= number_format(($total_credits - $total_credits_payable), 0, '', '.') ?></small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-12 order-2 order-md-0">
            <div class="card-header">
              <h5 class="mb-0">% Pagado</h5>
            </div>
            <div class="card-body" style="position: relative;">
              <div id="overviewChart" class="d-flex align-items-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!--/ Inversiones -->
  </div>
</div>
<?php $this->endSection() ?>

<?= $this->section('javaScripts'); ?>


  <script src="<?= base_url(['assets/vendor/libs/swiper/swiper.js?v='.getCommit()]) ?>"></script>
  <script src="<?= base_url(['assets/vendor/libs/apex-charts/apexcharts.js?v='.getCommit()]) ?>"></script>

  <script>
    const getTypeMovements = () => <?= json_encode($type_movements) ?>;
    const getMovements = () => <?= json_encode($movements) ?>;
  </script>
  <!-- Page JS -->
  <!-- <script src="<?= base_url(["assets/js/dashboards-analytics.js"]) ?>"></script> -->
  <script src="<?= base_url(['master/js/home/customer.js?v='.getCommit()]) ?>"></script>
<?= $this->endSection() ?>