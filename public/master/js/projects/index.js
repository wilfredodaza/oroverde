const pageInfo = infoPage();
const url_page = `dashboard/projects`;

$(() => {
    let columns = [];
    columns = [
        {title: 'Projecto', data: 'name'},
        {title: 'Estado', data: 'state', render: (state) => `<span class="badge ${state.font} ${state.background}" >${state.name}</span>`},
        {title: 'Fecha', data: 'date'},
        {title: '% Utilidad', data: 'percentage_profit'},
        {title: 'Finca', data: 'farm'},
        {title: 'Años de vigencia', data: 'project_years'},
        {title: 'Unds. Productivas', data:'movements', render: (movements => {
            const total = movements.reduce((acc, m) => {
                switch (m.type_movement_id) {
                    case '1':
                        if(["7"].includes(m.state_id)){
                            acc += m.details.reduce((acc, d) => {
                                acc += parseInt(d.quantity);
                                return acc;
                            }, 0)
                        }
                        break;
                    case '2':
                        if(["9", "10"].includes(m.state_id)){
                            acc -= m.details.reduce((acc, d) => {
                                acc += parseInt(d.quantity);
                                return acc;
                            }, 0)
                        }
                        break;
                
                    default:
                        break;
                }
                return acc;
            }, 0);
            return total;
        })},
        {title: 'Valor Proyecto', data:'movements', render: (m) => {
            const movement = m.find(m => m.type_movement_id == 1);
            return movement ? formatPrice(parseFloat(movement.value)) : formatPrice(0);
        }},
        {title: 'Ubicación', data: 'ubication'},
        {title: 'Acciones', data: 'id', render: (id, _, p) => {
            let actions = p.state_id != 6 ? `
                <div class="d-inline-block">
                    <a href="javascript:void(0);" onclick="edit(${id})" class="btn btn-sm btn-text-primary rounded-pill btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="Editar"><i class="ri-file-edit-line"></i></a>
                    <a href="javascript:void(0);" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-line"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                        ${p.state_id == 3 ? `<li><a href="javascript:void(0);" onclick="loadInit(${id})" class="dropdown-item">Cargue Inicial</a></li>` : ""}
                        ${p.state_id == 4 ? `
                            <li><a href="javascript:void(0);" onclick="editMovement(${id})" class="dropdown-item">Editar Cargue</a></li>
                            <li><a href="${base_url(['dashboard/projects/kardex', id])}" class="dropdown-item">Kardex</a></li>
                            ${
                                isLast15DaysOfYear() ? `
                                    <li><a href="javascript:void(0);" onclick="utilities(${id})" class="dropdown-item">Crear utilidades</a></li>
                                `:""
                            }
                            <li><a href="javascript:void(0);" class="dropdown-item">Finalizar</a></li>
                        ` : ""}
                        ${p.support ? `<li><a target="_blank" href="${base_url(['uploads', p.support])}" class="dropdown-item">Soporte</a></li>` : ""}
                        <li><a href="javascript:void(0);" onclick="decline(${p.id})" class="dropdown-item text-danger">Rechazar</a></li>
                    </ul>
                </div>
            ` : ''
            return actions;
        }}
    ];

    const buttons = [
        pageInfo.button != "" ? {
            text: `<i class="ri-add-line ri-16px me-sm-2"></i> <span class="d-none d-sm-inline-block">${pageInfo.button}</span>`,
            className: 'btn btn-primary waves-effect waves-light mx-2 mt-2',
            action: () => {
                resetFormulario();

                $("#save-crud-Label").html(`Añadir proyecto`);

                const offCanvasElement = document.querySelector('#save-crud');
                let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
                offCanvasEl.show();
            }
        } : null,
    ].filter(Boolean)
    load_datatable(`${url_page}/data`, columns, buttons, url_page);

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


})

async function onSubmit(e, id_form){
    e.preventDefault();
    const form = $(`#${id_form}`);

    const {isValid, data} = validData(id_form);
    if(!isValid){
        alert('Campos obligatorios', 'Por favor llenar los campos requeridos.', 'warning', 5000);
        return false;
    }

    const url = form.attr('action');

    const method = form.attr('method');
    let response;
    switch (method) {
        case 'POST':
            response = await fetchHelper.post(url, data, {}, 500);
            break;
        case 'PUT':
            const id = url.split("\/").at(-1);
            if(!isNaN(Number(id))){
                const projects = getDataDT();
                const project = projects.find(p => p.id == id);
                const movement = project.movements.find(m => m.id == id);
                const send_data = {
                    // customer:       data.customer ? data.customer : movement.customer_id,
                    // payment_method: data.payment_method ? data.payment_method : movement.payment_method_id,
                    // discount:       data.discount,
                    // valor:          data.valor ? data.valor : movement.value,
                    // fecha:          data.fecha ? data.fecha : movement.date,
                    details: [],
                    // beneficiaries:  data.beneficiaries
                }
                if (movement.details.length != 0) {
                    const cantidad = data.cantidad ?? movement.detail.quantity;
                
                    if (cantidad) { // 👈 evita que vaya vacío o 0 si no quieres
                        send_data.details.push({
                            id: movement.details[0].id,
                            cantidad: cantidad
                        });
                    }
                }
                await fetchHelper.put(url, send_data, {}, 500);
            }
            // response = await fetchHelper.put(url, data, {}, 500);
            break;
    
        default:
            break;
    }


    resetFormulario();
    $('.btn-close').click();

    reloadTable();
}

function edit(id_project){
    const projects = table_datatable[0].rows().data().toArray();
    const project = projects.find(p => p.id == id_project);

    $("#form-save-crud #proyecto").val(project.id);
    $("#form-save-crud #nombre").val(project.name);
    $("#form-save-crud #fecha").val(project.date);
    $("#form-save-crud #utilidad").val(project.percentage_profit);
    $("#form-save-crud #finca").val(project.farm);
    $("#form-save-crud #ubicacion").val(project.ubication);
    $("#form-save-crud #estado").val(project.state_id);
    $("#form-save-crud #year_project").val(project.project_years);

    $("#save-crud-Label").html(`Editar ${project.name}`);

    const offCanvasElement = document.querySelector('#save-crud');
    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
}

function editMovement(id_project){
    const formulario = pageInfo.form_cruds.find(f => f.id == 'save-movement');
    const form = $('#form-save-movement');
    const projects = getDataDT();
    const project = projects.find(p => p.id == id_project);
    const movement_load = project.movements.find(m => m.type_movement_id == 1);

    $('#save-movement #payment_method').attr('disabled', true).val(movement_load.payment_method_id).trigger('change');
    $('#save-movement #project').attr('disabled', true).val(movement_load.project_id).trigger('change');
    $('#save-movement #fecha').attr('disabled', true).val(movement_load.date);
    $('#save-movement #unit_productive').attr('disabled', true).val(movement_load.details[0].unit_productive_id).trigger('change');
    $('#save-movement #cantidad').val(movement_load.details[0].quantity);

    form.attr('method', 'PUT');
    form.attr('action', base_url([formulario.url, movement_load.id]));
    $("#save-movement-Label").html(`Editar Cargue #${movement_load.resolution}`);

    const offCanvasElement = document.querySelector('#save-movement');
    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
}

function utilities(id_project){
    const projects = getDataDT();
    const project = projects.find(p => p.id == id_project);
    const currentYear = new Date().getFullYear();
    const movements = project.movements.filter(m => (m.type_movement_id == 4 && m.state_id == 14));
    
    if(movements.length == 0){
        return Swal.fire({
            title: `No existen cosechas para crear utilidades`,
            confirmButtonText: "ok",
            customClass: {
                confirmButton: "btn btn-primary"
            },
        })
    }

    const movements_harvest = movements.reduce((acc, m) => {
        acc.push(m.id);
        return acc;
    }, []);
    console.log(movements_harvest)
    
    const harvest_total = movements.reduce((acc, m) => acc += parseFloat(m.value), 0);
    const total_harvest_kg = movements.reduce((acc, m) => {
        const total = m.details.reduce((acc, md) => acc += parseInt(md.quantity), 0);
        acc += total;
        return acc;
    }, 0);
    
    const harvest_discount = harvest_total * (project.percentage_profit / 100);
    Swal.fire({
        title: `Crear utilidades de cosechas.`,
        width: "80%",
        html: `
            <table class="table table-striped w-100 table-bordered table-center">
                <thead>
                    <tr>
                        <th>Valor Cosechas</th>
                        <th>Total Cosechas</th>
                        <th>% Utilidad</th>
                        <th>Valor Utilidades</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${formatPrice(harvest_total)}</td>
                        <td>${valueFormat(total_harvest_kg)} Kg</td>
                        <td>${project.percentage_profit}</td>
                        <td>${formatPrice(harvest_discount)}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-striped w-100 table-bordered table-center">
                <thead>
                    <tr>
                        <th># Resolución</th>
                        <th>Fecha</th>
                        <th>Total Cosecha</th>
                        <th>Total Cosecha Kg</th>
                        <th>Total Utilidad</th>
                    </tr>
                    <tbody>
                        ${
                            movements.slice().reverse().reduce((acc, m) => {
                                const value_percentage = m.value * (parseFloat(project.percentage_profit) / 100);
                                const tr = `
                                    <tr>
                                        <td>${m.resolution}</td>
                                        <td>${m.date}</td>
                                        <td>${formatPrice(m.value)}</td>
                                        <td>${valueFormat(m.details[0].quantity)}</td>
                                        <td>${formatPrice(value_percentage)}</td>
                                    </tr>
                                `;
                                acc.push(tr)
                                return acc;
                            }, []).join('')
                        }
                    </tbody>
                </thead>
            </table>
        `,
        confirmButtonText: "ok",
        customClass: {
            confirmButton: "btn btn-primary"
        },
    }).then(async (result) => {
        if(result.isConfirmed){
            const data = {
                type_movement:  5,
                project:        project.id,
                harvest:        movements_harvest
            };

            const url = base_url(['dashboard/movements/save']);

            const response = await fetchHelper.post(url, data, {}, 500);

            console.log(response)
        }
    });
}

function resetFormulario(){
    pageInfo.form_cruds.map((form) => {
        form.inputs.map(input => {
            $(`#${form.id} #${input.name}`).val(input.value)
            if(input.type == "select"){
                $(`#${form.id} #${input.name}`).trigger('change');
            }
        })
    });
}

async function decline(id_project){
    const projects = table_datatable[0].rows().data().toArray();
    const project = projects.find(p => p.id == id_project);

    Swal.fire({
        title: `Rechazar el proyecto "#${project.name}"`,
        text: `Recuerde que al rechazar el proyecto no se podra revertir.`,
        showCancelButton: true,
        confirmButtonText: "Rechazar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-outline-danger"
        },
      }).then(async (result) => {
        if (result.isConfirmed) {
            const data = {
                proyecto: project.id,
                nombre: project.name,
                fecha: project.date,
                utilidad: project.percentage_profit,
                finca: project.farm,
                ubicacion: project.ubication,
                estado: 6
            };

            const form = $("#form-save-crud");
            const url = form.attr('action');
            const response = await fetchHelper.post(url, data, {}, 500);
            resetFormulario();
            reloadTable();
        }
    });
}

function loadInit(id_project){
    const projects = table_datatable[0].rows().data().toArray();
    const project = projects.find(p => p.id == id_project);
    const form = $('#form-save-movement');
    $("#save-movement-Label").html(`Carga inicial para "${project.name}"`);

    const offCanvasElement = document.querySelector('#save-movement');
    let offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();

    $('#form-save-movement #project').val(id_project)
}

function changeCustomer(id_customer){
    if(id_customer != undefined && id_customer != ""){
        const customers = pageInfo.form_cruds[1].inputs.find(input => input.name == "customer").options;
        console.log(customers)
        const customer = customers.find(c => c.id == id_customer);
    
        $("#beneficiaries").empty(); // Limpia opciones previas
        customer.beneficiaries.map(opt => {
            $("#beneficiaries").append(new Option(opt.name, opt.id, false, false));
        });
    }

}

