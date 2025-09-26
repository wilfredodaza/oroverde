const project = infoPage();
$(() => {

    console.log(project.movements);
    const data = project.movements.filter(m => [1, 2].includes(parseInt(m.type_movement_id)));
    const columns = [
        {title: '# Resolution', data: 'resolution'},
        {title: 'Tipo Movimiento', data: 'type_movement.name'},
        {title: 'Estado', data: 'state', render: (state) => `<span class="badge ${state.font} ${state.background}" >${state.name}</span>`},
        {title: 'Cantidad', data: 'total'},
        {title: 'Entrada', data:'total', render: (_, __, m) => {
            switch (m.type_movement_id) {
                case '1':
                    return _;
                    break;
            
                default:
                    return 0;
                    break;
            }
        }},
        {title: 'Salida', data:'total', render: (_, __, m) => {
            switch (m.type_movement_id) {
                case '2':
                    return _;
                    break;
            
                default:
                    return 0;
                    break;
            }
        }},
        {title: 'Balance', data:'kardex'}
    ];

    load_datatable_total(columns, data.slice().reverse())
})