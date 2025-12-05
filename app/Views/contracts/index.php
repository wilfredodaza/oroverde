
<?= $this->extend('layouts/page'); ?>

<?= $this->section('styles'); ?>

<link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css']) ?>" />
<link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/typeahead-js/typeahead.css']) ?>" />
<link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/quill/typography.css']) ?>" />
<link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/quill/katex.css']) ?>" />
<link rel="stylesheet" href="<?= base_url(['assets/vendor/libs/quill/editor.css']) ?>" />

<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header py-3 pb-2 align-items-center d-flex flex-wrap">
                    <h5 class="card-action-title card-title" id="form-search">
                        Contrato vigente
                    </h5>
                </div>
                <div class="card-body">
                    <span class="text-muted">Los campos con un asterisco (*) son requeridos para completar el formulario.</span>
                </div>
            </div>
            <!-- Change Password -->
            <form id="form-contract" method="GET" onsubmit="sendContract(event)">

                <input type="hidden" name="contrato" id="contrato" value="<?= $contract->id ?? "" ?>">

                <div class="card mb-6">
                    <div class="card-body p-0 px-5 pt-5">
                        <div class="row">
                            <div class=" col-md-12 col-lg-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline mb-6">
                                    <input
                                        class="form-control required"
                                        type="text"
                                        name="title"
                                        id="title"
                                        value="<?= $contract->title ?? "" ?>"
                                        placeholder="Titulo" />
                                    <label for="title">Titulo *</label>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-12 col-lg-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="version"
                                            name="version"
                                            value="<?= $contract->version ?? "" ?>"
                                            placeholder="Ejemplo: 1.0" />
                                        <label for="version">Versión *</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-6">
                    <h5 class="card-header">Contrato</h5>
                    <div class="card-body">
                        <div id="full-editor" class="full-editor-2">
                            <?= $contract->description ?? "
                                {{TITLE}}
    
    ({{Numero_Contrato}})
    
    Entre los suscritos: (1) {{COMPANY.NAME}}, sociedad comercial identificada con NIT {{COMPANY.NIT}}, domiciliada en {{COMPANY.UBICATION}}, inscrita en la Cámara de Comercio de {{COMPANY.ORIGIN}}, representada legalmente por {{COMPANY.REPRESENTATIVE}}, mayor de edad, identificado con {{COMPANY.REPRESENTATIVE_TYPE_DOCUMENT}} {{COMPANY.REPRESENTATIVE_NUMBER}} de {{COMPANY.REPRESENTATIVE_ISSUED}}, quien en adelante se denominará LA COMPAÑÍA; y (2) {{CUSTOMER.NAME}}, mayor de edad, identificado(a) con {{CUSTOMER.TYPE_DOCUMENT}} No. {{CUSTOMER.NUMBER}} de {{CUSTOMER.ISSUED}}, quien en adelante se denominará EL COMPRADOR, se celebra el presente {{TITLE}}, el cual se regirá por lo dispuesto en los artículos 1863, 1869 del Código Civil, 917 del Código de Comercio y demás normas aplicables, atendiendo las siguientes cláusulas:
                            " ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary me-3" id="btn-send">Guardar</button>
                    </div>
                </div>
            </form>
            <!--/ Change Password -->
            


        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javaScripts'); ?>

    <script src="<?= base_url(['assets/vendor/libs/quill/katex.js']) ?>"></script>
    <script src="<?= base_url(['assets/vendor/libs/quill/quill.js']) ?>"></script>

  <!-- Page JS -->
  <script src="<?= base_url(['master/js/contracts/index.js?v='.getCommit()]) ?>"></script>
<?= $this->endSection() ?>