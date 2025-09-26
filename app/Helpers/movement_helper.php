<?php 
function diferenciaPorUnidad($fechaInicio, $fechaFin, $unidad)
{
    $date1 = new DateTime($fechaInicio);
    $date2 = new DateTime($fechaFin);
    $diff  = $date1->diff($date2);

    switch (strtolower($unidad)) {
        case 'día':
        case 'dia':
        case 'días':
            return $diff->days;

        case 'semana':
        case 'semanas':
            return floor($diff->days / 7);

        case 'mes':
        case 'meses':
            return ($diff->y * 12) + $diff->m;

        case 'año':
        case 'años':
            return $diff->y;

        default:
            return null;
    }
}

function seleccionarPriceAge($unidadProductiva, $fechaInicio, $fechaFin)
{
    $unidad   = $unidadProductiva->unit_age;   // Ej: "Año"
    $diferencia = diferenciaPorUnidad($fechaInicio, $fechaFin, $unidad);

    $seleccionado = null;
    if (!empty($unidadProductiva->price_ages)) {
        foreach ($unidadProductiva->price_ages as $pa) {
            // comparamos con el campo age del price_age
            if ((int)$pa->age <= $diferencia) {
                if ($seleccionado === null || (int)$pa->age > (int)$seleccionado->age) {
                    $seleccionado = $pa;
                }
            }
        }
    }

    return $seleccionado;
}

function numeroALetras($numero) {
    $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

    // Parte entera
    $entero = floor($numero);
    $textoEntero = $formatter->format($entero);

    // Parte decimal
    $decimal = round(($numero - $entero) * 100); // hasta 2 decimales
    $textoDecimal = $decimal > 0 ? $formatter->format($decimal) : null;

    // Armar el texto final
    if ($textoDecimal) {
        return ucfirst($textoEntero) . " con " . $textoDecimal;
    } else {
        return ucfirst($textoEntero);
    }
}