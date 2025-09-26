const product = getProduct();

function calculate_data(){
    const quantity = parseInt($("#quantity_simulate").val());
    const discount = parseInt($("#discount_simulate").val());
    const value_vite = format_number($('#value_vite').val());
    const data = product.harvests;
    
    let value_individual = product.individual_value;

    const
        value_undiscount = (quantity * value_vite),
        value_discount = (((quantity * value_vite) * discount) / 100),
        value = value_undiscount - value_discount,
        total_quantity = data.reduce((suma, item) => suma + (item.production * quantity), 0),
        prom_price = value_individual;

    const table_info = `
        <tbody>
            <tr>
                <td>Precio actual 1 Vite</td>
                <td>${formatPrice(value_vite)}</td>
                <td>Cantidad de vites</td>
                <td>${formatearMiles(quantity)}</td>
            </tr>
            <tr>
                <td>Descuento</td>
                <td>${discount} %</td>
                <td>Valor Total Compra Sin Descuento</td>
                <td>${formatPrice(value_undiscount)}</td>
            </tr>
            <tr>
                <td>Valor Total Compra Con Descuento</td>
                <td>${formatPrice(value)}</td>
                <td>Ahorro en tu compra</td>
                <td>${formatPrice(value_discount)}</td>
            </tr>
            <tr>
                <td>Cosecha estimada en 20 años (kg)</td>
                <td>${formatearMiles(total_quantity)}</td>
                <td>Valor estimado de esa producción hoy: <br>${formatearMiles(total_quantity)} * ${formatPrice(prom_price)}</td>
                <td>${formatPrice(total_quantity * prom_price)}</td>
            </tr>
        </tbody>
    `
    $('#table-info').html(table_info)
    
}

function simulate(){
    
    $('#div-data').html("")
    const quantity = parseInt($("#quantity_simulate").val());
    const discount = parseInt($("#discount_simulate").val());
    const value_vite = format_number($('#value_vite').val());
    const data = product.harvests;
    
    let value_individual = product.individual_value;

    const
        value_undiscount = (quantity * value_vite),
        value_discount = (((quantity * value_vite) * discount) / 100),
        value = value_undiscount - value_discount,
        total_quantity = data.reduce((suma, item) => suma + (item.production * quantity), 0),
        prom_price = value_individual;
    
    const data_entry = `

        <div class="table-responsive text-nowrap">
            <table class="table table-sm centered">
                <thead>
                    <tr>
                        <th>Tiempo</th>
                        <th>Producción<br>Estimada Kg por<br>1 Vite</th>
                        <th>Producción<br>Estimada<br>Kg total<br>de Vites</th>
                        <th>Precio Estimado<br>x Kg</th>
                        <th>% Anual<br>Estimado Neto<br>(${product.sales_percentage}% de la venta)</th>
                        <th>Ingreso Neto Anual<br>Estimado (${product.sales_percentage}% de<br>la venta)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Capital</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-danger">- ${formatPrice(value)}</td>
                    </tr>
                    ${data.reduce((acc, year) => {
                        if(year.year > 1)
                            value_individual = (value_individual*(1 + (parseFloat(product.ipc) / 100))).toFixed(0);

                        // console.log([value_individual, parseFloat(product.ipc)])

                        const entry = parseInt(((year.production * quantity) * value_individual) * (product.sales_percentage / 100)).toFixed(2);
                        // console.log(entry)
                        const td = `
                            <tr>
                                <td>Año ${year.year}</td>
                                <td>${year.production}</td>
                                <td>${year.production * quantity}</td>
                                <td>${formatPrice(value_individual)}</td>
                                <td>${((entry / value) * 100).toFixed(2)} %</td>
                                <td>${formatPrice(entry)}</td>
                            </tr>
                        `
                        acc.push(td)
                        return acc;

                    }, []).join("")}
                </tbody>
            </table>
        </div>
    `;

    const data_info = `
        <div class="table-responsive text-nowrap">
            <table class="table table-sm centered">
                <thead>
                    <tr>
                        <th colspan=2">Oro Verde - Estimado (Neto del 70% de la venta)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Valor Total Capital Inicial</td>
                        <td>${formatPrice(value)}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;

    $('#div-data').append(data_entry);
}

function obtenerDescuentoPorCantidad(quantity) {

    const plans = product.plans.map(p => ({
        stock: parseInt(p.stock),
        discount: parseInt(p.discount)
    }));

    // Filtramos los planes cuyo stock sea menor o igual a la cantidad seleccionada
    const availablePlans = plans.filter(p => quantity >= p.stock);

    if (availablePlans.length === 0) return 0; // Si no hay ninguno válido, descuento 0

    // Seleccionamos el plan con el mayor stock menor o igual a la cantidad
    const bestPlan = availablePlans.sort((a, b) => b.stock - a.stock)[0];

    return bestPlan.discount;
}

function loadSlider(){
    const sliderDiscount = document.getElementById('slider-discount');
    const sliderProduct = document.getElementById('slider-product');

    const min_discount = Math.min(...product.plans.map(p => p.discount));
    const max_discount = Math.max(...product.plans.map(p => p.discount));

    if (sliderDiscount) {
        noUiSlider.create(sliderDiscount, {
            start: [min_discount],
            behaviour: 'hover-snap-tap',
            tooltips: true,
            step: 1,
            connect: [true, false],
            direction: isRtl ? 'rtl' : 'ltr',
            range: {  
                min: min_discount,
                max: max_discount
            }
        });

        sliderDiscount.noUiSlider.on('update', function (values, handle) {
            $('#discount_simulate').val(values[handle]);
            calculate_data()
        });
    }

    const min_product = Math.min(...product.plans.map(p => p.stock));


    if (sliderProduct) {
        noUiSlider.create(sliderProduct, {
            start: [min_product],
            behaviour: 'hover-snap-tap',
            tooltips: true,
            step: 1,
            connect: [true, false],
            direction: isRtl ? 'rtl' : 'ltr',
            range: {  
                min: min_product,
                max: 100
            }
        });
        sliderProduct.noUiSlider.on('update', function (values, handle) {
            const quantity = values[handle]
            $('#quantity_simulate').val(quantity);
            const discount = obtenerDescuentoPorCantidad(quantity);
            
            if (sliderDiscount && sliderDiscount.noUiSlider) {
                sliderDiscount.noUiSlider.set(discount);
            }
        
            calculate_data();
        });
    }
}

loadSlider();