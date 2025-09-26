const pageInfo = infoPage();

$(() => {
    const url = `dashboard/movements/data/${pageInfo.id}`;
    let columns = [];
    let buttons = [];
    switch (pageInfo.id) {
        case '1':
        case '5':
            columns = [
                {title: 'Resolución', data: 'resolution'},
                {title: 'Proyecto', data: 'project.name'},
                {title: 'Cliente', data: 'customer.name'},
                // {title: 'Metodo de pago', data: 'payment_method.name'},
                {title: 'Estado', data: 'state', render: (state) => `<span class="badge ${state.font} ${state.background}" >${state.name}</span>`},
                {title: 'Fecha', data: 'date'},
                {title: 'Valor', data: 'value', render:(v) => formatPrice(parseFloat(v))},
                {title: 'Unidades<br>Productivas', data:'detail.quantity'},
                {title: 'Acciones', data: 'id', render: (id, _, movement) => {
                    let actions = id ? `
                        <div class="d-inline-block">
                            ${
                                action(movement)
                            }
                        </div>
                    ` : ''
                    return actions;
                }}
            ];
            break;
        case '2':
            columns = [
                {title: 'Resolución', data: 'resolution'},
                {title: 'Proyecto', data: 'project.name'},
                {title: 'Cliente', data: 'customer.name'},
                {title: 'Metodo de pago', data: 'payment_method.name'},
                {title: 'Estado', data: 'state', render: (state) => `<span class="badge ${state.font} ${state.background}" >${state.name}</span>`},
                {title: 'Fecha', data: 'date'},
                {title: 'Valor', data: 'value', render:(v) => formatPrice(parseFloat(v))},
                {title: 'VxP', data: 'total_x_payable', render:(v, _, m) => {
                    if (m.payment_method_id == 1) v = 0;
                    return `<span class="${v == 0 ? "text-green" : (v < 0 ? "text-pink" : "text-orange")} text-darken-5">${formatPrice(v)}</span>`
                }, visible: pageInfo.id == 2},
                {title: 'Acciones', data: 'id', render: (id, _, movement) => {
                    let actions = id ? `
                        <div class="d-inline-block">
                            ${
                                action(movement)
                            }
                        </div>
                    ` : ''
                    return actions;
                }}
            ];

            buttons.push({
                text: `<i class="ri-add-line ri-16px me-sm-2"></i> <span class="d-none d-sm-inline-block">Crear Venta</span>`,
                className: 'btn btn-primary waves-effect waves-light mx-2 mt-2',
                action: () => {
                    resetFormulario();

                    $("#save-movement-Label").html(`Añadir proyecto`);

                    const offCanvasElement = document.querySelector('#save-movement');
                    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
                    offCanvasEl.show();
                }
            });
            break;
        case '3':
            columns = [
                {title: 'Resolución', data: 'resolution'},
                {title: 'Resolución<br>Referencia', data: 'resolution_reference'},
                {title: 'Movimiento<br>Referencia', data:'type_movement_resolution_reference'},
                {title: 'Proyecto', data: 'project.name'},
                {title: 'Cliente', data: 'customer.name'},
                // {title: 'Metodo de pago', data: 'payment_method.name'},
                {title: 'Estado', data: 'state', render: (state) => `<span class="badge ${state.font} ${state.background}" >${state.name}</span>`},
                {title: 'Fecha', data: 'date'},
                {title: 'Valor', data: 'value', render:(v) => formatPrice(parseFloat(v))},
                {title: 'Acciones', data: 'id', render: (id, _, movement) => {
                    let actions = id ? `
                        <div class="d-inline-block">
                            ${
                                action(movement)
                            }
                        </div>
                    ` : ''
                    return actions;
                }}
            ];
            break;
        case '4':
            buttons.push({
                text: `<i class="ri-add-line ri-16px me-sm-2"></i> <span class="d-none d-sm-inline-block">Crear cosecha</span>`,
                className: 'btn btn-primary waves-effect waves-light mx-2 mt-2',
                action: () => {
                    resetFormulario();

                    $("#save-movement-Label").html(`Añadir cosecha`);

                    const offCanvasElement = document.querySelector('#save-movement');
                    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
                    offCanvasEl.show();
                }
            });

            columns = [
                {title: 'Resolución', data: 'resolution'},
                {title: 'Proyecto', data: 'project.name'},
                // {title: 'Metodo de pago', data: 'payment_method.name'},
                {title: 'Estado', data: 'state', render: (state) => `<span class="badge ${state.font} ${state.background}" >${state.name}</span>`},
                {title: 'Fecha', data: 'date'},
                {title: 'Valor', data: 'value', render:(v) => formatPrice(parseFloat(v))},
                // {title: 'Utilidades', data:'utilities', render: (utilities) => {
                //     const total = utilities.reduce((acc, m) => acc += parseFloat(m.value), 0);
                //     return formatPrice(total);
                // }},
                {title: 'Cantidad', data:'detail.quantity', render: (q) => valueFormat(q)},
                {title: 'Acciones', data: 'id', render: (id, _, movement) => id ? `<div class="d-inline-block">${action(movement)}</div>` : ''}
            ];
            break;
    
        default:
            break;
    }

    const select2 = $('.form-select');
    
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            const placeholder = $this.attr('placeholder') || 'Seleccione una opción';
            select2Focus($this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder,
                dropdownParent: $this.parent()
            });
        });
    }
    
    const dateInput = $('.date-input');

    if (dateInput.length) {
        dateInput.flatpickr({
            locale:             "es",
            monthSelectorType:  'dropdown',
        });
    }

    load_datatable(url, columns, buttons, `dashboard/movements/${pageInfo.id}`)
})

function action(movement){
    let action = ``;
    switch (movement.type_movement_id) {
        case '1':
            action = `
                ${
                    // <a href="javascript:void(0);" onclick="deleteMovement(${movement.id})" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" data-bs-original-title="Rechazar"><i class="ri-file-close-line"></i></a>
                    movement.state_id != 8 ? `
                        <a href="javascript:void(0);" onclick="editMovement(${movement.id})" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Editar ${movement.resolution}"><i class="ri-edit-2-line"></i></a>
                        <a href="${base_url(['dashboard/projects/kardex', movement.id])}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Kardex #${movement.resolution}"><i class="ri-plant-line"></i></a>                
                    ` : ""
                }
            `
            break;
        case '2':
            action = `
                <a href="${base_url(['dashboard/movements/contract', movement.id])}" target="_blank" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Ver contrato"><i class="ri-contract-line"></i></a>
                ${
                    movement.state_id != 11 ? `
                        <a href="javascript:void(0);" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-line"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                            <li><a href="javascript:void(0);" onclick="editMovement(${movement.id})" class="dropdown-item">Editar</a></li>
                            ${movement.state_id == 9 ? `<li><a onclick="payments(${movement.id})" href="javascript:void(0)" class="dropdown-item">Pagar</a></li>` : ""}
                            ${movement.support ? `<li><a target="_blank" href="${base_url(['uploads', movement.support])}" class="dropdown-item">Soporte</a></li>` : ""}
                            <li><a href="javascript:void(0);" onclick="deleteMovement(${movement.id})" class="dropdown-item text-danger">Rechazar</a></li>
                        </ul>
                    ` : ""
                }
            `
            break;
        case '3':
            action = `
                ${
                    movement.state_id != 13 ? `
                        <a href="javascript:void(0);" onclick="editMovement(${movement.id})" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Editar ${movement.resolution}"><i class="ri-edit-2-line"></i></a>
                        <a href="javascript:void(0);" onclick="deleteMovement(${movement.id})" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Rechazar ${movement.resolution}"><i class="ri-delete-back-2-line"></i></a>
                    ` : ""
                }
            `
            break;
        case '4':
            action = `
                ${
                    movement.state_id != 15 ? `
                        <a href="javascript:void(0);" onclick="editMovement(${movement.id})" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Editar ${movement.resolution}"><i class="ri-edit-2-line"></i></a>
                        <a href="javascript:void(0);" onclick="deleteMovement(${movement.id})" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Rechazar ${movement.resolution}"><i class="ri-delete-back-2-line"></i></a>
                        ` : ""
                        // <a href="javascript:void(0);" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-line"></i></a>
                        // <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                        //     <li><a href="javascript:void(0);" onclick="addUtility(${movement.id})" class="dropdown-item">Pagar utilidad</a></li>
                        //     <li><a href="javascript:void(0);" onclick="deleteMovement(${movement.id})" class="dropdown-item text-danger">Rechazar</a></li>
                        // </ul>
                }
            `
            break;
        case '5':
            action = `
                ${
                    movement.state_id == 17 ? `
                        <a onclick="payments(${movement.id})" href="javascript:void(0)" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-original-title="Pagar utlidad #${movement.resolution}"><i class="ri-currency-line"></i></a>
                    ` : ""
                        // <a href="javascript:void(0);" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-line"></i></a>
                        // <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                        //     <li><a href="javascript:void(0);" onclick="addUtility(${movement.id})" class="dropdown-item">Pagar utilidad</a></li>
                        //     <li><a href="javascript:void(0);" onclick="deleteMovement(${movement.id})" class="dropdown-item text-danger">Rechazar</a></li>
                        // </ul>
                }
            `
            break;
    
        default:
            break;
    }
    return action;

}

function resetFormulario(){
    pageInfo.form_cruds.map((form) => {
        $(`#${form.id}`).attr('method', 'POST');
        $(`#${form.id}`).attr('action', base_url([form.url]));
        form.inputs.map(input => {
            $(`#${form.id} #${input.name}`).val(input.value)
            if(input.type == "select"){
                $(`#${form.id} #${input.name}`).trigger('change');
            }
        })
    });

    $('.offcanvas .btn-close').click();
}

function changeCustomer(id_customer){
    if(id_customer != undefined && id_customer != ""){
        const customers = pageInfo.form_cruds.find(f => f.id == "save-movement").inputs.find(input => input.name == "customer").options;
        console.log(customers)
        const customer = customers.find(c => c.id == id_customer);
    
        $("#beneficiaries").empty(); // Limpia opciones previas
        customer.beneficiaries.map(opt => {
            $("#beneficiaries").append(new Option(opt.name, opt.id, false, false));
        });
    }

}

function changeProject(id_proyect){
    if(id_proyect != undefined && id_proyect != ""){
        const projects = pageInfo.form_cruds.find(f => f.id == "save-movement").inputs.find(input => input.name == "project").options;
        const project = projects.find(p => p.id == id_proyect);
        const movement = project.movements.find(m => m.type_movement_id == 1);
        const detail = movement.details[0];
        $("#unit_productive").val(detail.unit_productive_id);
    }
}

function changeMethod(method_payment_id){
    if(method_payment_id != undefined && method_payment_id != ""){
        const states = pageInfo.form_cruds.find(f => f.id == "save-movement").inputs.find(input => input.name == "state").options;
        $('#state').val(method_payment_id == 1 ? states[1].id : states[0].id)
    }
}

function payments(movement_id){
    $("#save-movement-payment-Label").html(`Registrar Pago`);
    const offCanvasElement = document.querySelector('#save-movement-payment');
    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();

    $(`#save-movement-payment #movement_reference`).val(movement_id);
}

function editMovement(movement_id){
    const movements = getDataDT();
    const movement = movements.find(m => m.id == movement_id);
    console.log(movement)
    const formulario = pageInfo.form_cruds[0];
    const form = $(`#form-${formulario.id}`);
    form.attr('action', base_url([formulario.url, movement.id]))
    form.attr('method', "PUT");

    $(`#${formulario.id}-Label`).html(`Editar ${pageInfo.title} #${movement.resolution}`);
    formulario.inputs.map(input => {
        if(input.name == "cantidad"){
            $(`#form-${formulario.id} #${input.name}`).val(movement.detail.quantity);
        }else if(input.name == "beneficiaries"){
            const beneficiaries = movement[input.field].reduce((acc, b) => {
                acc.push(b.beneficiary_id);
                return acc;
            }, []);
            $(`#form-${formulario.id} #${input.name}`).val(beneficiaries);
        }else{
            $(`#form-${formulario.id} #${input.name}`).val(movement[input.field]);
        }

        if(input.type == "select" || input.type == "select_multiple"){
            $(`#${formulario.id} #${input.name}`).trigger('change');
        }
    });

    const offCanvasElement = document.querySelector('#save-movement');
    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
}

function deleteMovement(movement_id){
    const movements = getDataDT();
    const movement = movements.find(m => m.id == movement_id);
    const state = pageInfo.states.at(-1);
    const state_name = pageInfo.states.at(-1).option_state ? pageInfo.states.at(-1).option_state : pageInfo.states.at(-1).name;

    Swal.fire({
        title: `${state_name} ${pageInfo.title.toLowerCase()} <br>#${movement.resolution}`,
        text: `Recuerde que al ${state_name.toLowerCase()} el movimiento se perdera toda información.`,
        showCancelButton: true,
        confirmButtonText: state_name,
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-outline-danger"
        },
    }).then(async (result) => {
        if (result.isConfirmed) {
            const data = {
                movement_id,
                state_id: state.id
            }
            const form = pageInfo.form_cruds[0];
            // const formulario = $(`#form-${form.id}`);
            const url = base_url([form.url, movement_id]);
            // const url = base_url(['invoices/decline']);
            const res = await fetchHelper.delete(url, data, {}, 500);
            Swal.fire({
                icon: 'success',
                title: res.title,
                showConfirmButton: true,
                allowOutsideClick: false,
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            reloadTable()
        }
    })
}

function addUtility(movement_id){
    const movements = getDataDT();
    const movement = movements.find(m => m.id == movement_id);
    console.log(movement);
}

async function onSubmit(e, id_form){
    e.preventDefault();
    const form = $(`#${id_form}`);

    const {isValid, data} = validData(id_form);
    if(!isValid){
        alert('Campos obligatorios', 'Por favor llenar los campos requeridos.', 'warning', 5000);
        return false;
    }

    const url = form.attr('action');
    
    if(form.attr('method') == "POST")
        await fetchHelper.post(url, data, {}, 500);
    else{
        const id = url.split("\/").at(-1);
        if(!isNaN(Number(id))){
            const movements = getDataDT();
            const movement = movements.find(m => m.id == id);
            const send_data = {
                customer:       data.customer ? data.customer : movement.customer_id,
                payment_method: data.payment_method ? data.payment_method : movement.payment_method_id,
                discount:       data.discount,
                valor:          data.valor ? data.valor : movement.value,
                fecha:          data.fecha ? data.fecha : movement.date,
                details: [],
                beneficiaries:  data.beneficiaries
            }
            if (movement.detail && movement.detail.id) {
                const cantidad = data.cantidad ?? movement.detail.quantity;
            
                if (cantidad) { // 👈 evita que vaya vacío o 0 si no quieres
                    send_data.details.push({
                        id: movement.detail.id,
                        cantidad: cantidad
                    });
                }
            }
            await fetchHelper.put(url, send_data, {}, 500);
        }
    }
        // console.log("POST")
    // return false;


    resetFormulario();

    reloadTable();
    $('#save-movement .btn-close').click();
}