<?php foreach ($data->form_cruds as $key => $form): ?>
    <div class="col-lg-3 col-md-6">
        <div
            class="offcanvas offcanvas-end"
            tabindex="-1"
            id="<?= $form->id?>"
            aria-labelledby="<?= $form->id?>-Label">
                <div class="offcanvas-header">
                    <h5 id="<?= $form->id?>-Label" class="offcanvas-title"></h5>
                    <button
                        type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0">
                    <form action="<?= base_url($form->url) ?>" method="POST" id="<?= "form-{$form->id}" ?>" onsubmit="onSubmit(event, 'form-<?= $form->id ?>')">
                        <div class="row">

                            <?php foreach($form->inputs as $input): ?>
                                <?php switch($input->type):
                                    case 'hidden': ?>
                                        <input type="hidden" name="<?= $input->name ?>" id="<?= $input->name ?>" value="<?= $input->value ?>">
                                    <?php break;
                                    case 'select':
                                    case 'select_multiple': ?>
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-select <?= $input->required ? "required" : "" ?>" id="<?= $input->name ?>" name="<?= $input->name ?>" <?= isset($input->onchange) && !empty($input->onchange) ? 'onchange="'.$input->onchange.'"' : "" ?> <?= $input->type == "select_multiple" ? "multiple": "" ?>>
                                                    <option value="">Seleccionar</option>
                                                    <?php foreach($input->options as $option): ?>
                                                        <option value="<?= $option->id ?>" <?= $input->value == $option->id ? "selected" : "" ?>><?= "{$option->name}" ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label for="<?= $input->name ?>"><?= $input->required ? "* " : "" ?><?= $input->title ?></label>
                                                <span class="form-floating-focused"></span>
                                            </div>
                                        </div>
                                    <?php break;
                                    case 'number': ?>
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" onkeyup="onlyNumericKeypress(event)" class="form-control <?= $input->required ? "required" : "" ?>" name="<?= $input->name ?>" id="<?= $input->name ?>" placeholder="<?= $input->placeholder ?>">
                                                <label for="<?= $input->name ?>"><?= $input->required ? "* " : "" ?><?= $input->title ?></label>
                                            </div>
                                        </div>
                                    <?php break;
                                    case 'number_float': ?>
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" onkeyup="updateFormattedValue(this)" class="form-control <?= $input->required ? "required" : "" ?>" name="<?= $input->name ?>" value="<?= $input->value ?>" id="<?= $input->name ?>" placeholder="">
                                                <label for="<?= $input->name ?>"><?= $input->required ? "* " : "" ?><?= $input->title ?></label>
                                            </div>
                                        </div>
                                    <?php break;
                                    case 'date': ?>
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control date-input <?= $input->required ? "required" : "" ?>" placeholder="YYYY-MM-DD" name="<?= $input->name ?>" id="<?= $input->name ?>" placeholder="">
                                                <label for="<?= $input->name ?>"><?= $input->required ? "* " : "" ?><?= $input->title ?></label>
                                            </div>
                                        </div>
                                    <?php break;
                                    default: ?>
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control <?= $input->required ? "required" : "" ?>" name="<?= $input->name ?>" id="<?= $input->name ?>" placeholder="">
                                                <label for="<?= $input->name ?>"><?= $input->required ? "* " : "" ?><?= $input->title ?></label>
                                            </div>
                                        </div>
                                    <?php break; ?>
                                <?php endswitch ?>
                            <?php endforeach ?>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary mb-2 d-grid w-100 waves-effect waves-light">Guardar</button>
                        <button type="button" class="btn btn-danger mb-2 d-grid w-100 waves-effect waves-light" data-bs-dismiss="offcanvas">Cerrar</button>
                    </form>
                </div>
        </div>
    </div>
<?php endforeach ?>