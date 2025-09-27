<?php

use App\Models\Configuration;

function configInfo()
{
    $config = new Configuration();
    if($data = $config->find(1)){
        return $data;
    }
    return [];
}

function hexToRgb($hex) {
    // Quitar el símbolo '#' si está presente
    $hex = ltrim($hex, '#');

    // Si el formato es abreviado (e.g., "fff"), expandirlo
    if (strlen($hex) === 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Convertir hexadecimal a decimal
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return "$r, $g, $b";
}

function darkenColor($hex, $percent) {
    // Quitar el carácter '#' si está presente
    $hex = str_replace('#', '', $hex);

    // Convertir el valor HEX a RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Interpolar cada componente RGB hacia negro (0, 0, 0)
    $r = $r * (1 - $percent / 100);
    $g = $g * (1 - $percent / 100);
    $b = $b * (1 - $percent / 100);

    // Convertir de vuelta a HEX y retornar el nuevo color
    return sprintf("#%02x%02x%02x", (int)$r, (int)$g, (int)$b);
}

function lightenColor($hex, $percent) {
    // Quitar el carácter '#' si está presente
    $hex = str_replace('#', '', $hex);

    // Convertir el valor HEX a RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Interpolar cada componente RGB hacia blanco (255, 255, 255)
    $r = $r + (255 - $r) * ($percent / 100);
    $g = $g + (255 - $g) * ($percent / 100);
    $b = $b + (255 - $b) * ($percent / 100);

    // Convertir de vuelta a HEX y retornar el nuevo color
    return sprintf("#%02x%02x%02x", (int)$r, (int)$g, (int)$b);
}

function getCommit(){
    return env('GIT_COMMIT_HASH', strtotime(date('Y-m-d H:i:s')));
}

function meses(){
    $meses = [
        (object)[ 'name' => 'Enero',     'abbr' => 'Ene', 'mes' => 0 ],
        (object)[ 'name' => 'Febrero',   'abbr' => 'Feb', 'mes' => 1 ],
        (object)[ 'name' => 'Marzo',     'abbr' => 'Mar', 'mes' => 2 ],
        (object)[ 'name' => 'Abril',     'abbr' => 'Abr', 'mes' => 3 ],
        (object)[ 'name' => 'Mayo',      'abbr' => 'May', 'mes' => 4 ],
        (object)[ 'name' => 'Junio',     'abbr' => 'Jun', 'mes' => 5 ],
        (object)[ 'name' => 'Julio',     'abbr' => 'Jul', 'mes' => 6 ],
        (object)[ 'name' => 'Agosto',    'abbr' => 'Ago', 'mes' => 7 ],
        (object)[ 'name' => 'Septiembre','abbr' => 'Sep', 'mes' => 8 ],
        (object)[ 'name' => 'Octubre',   'abbr' => 'Oct', 'mes' => 9 ],
        (object)[ 'name' => 'Noviembre', 'abbr' => 'Nov', 'mes' => 10 ],
        (object)[ 'name' => 'Diciembre', 'abbr' => 'Dic', 'mes' => 11 ],
    ];

    return $meses;
    
}

function formatNumber($val) {
    if ($val >= 1e9) {
        return rtrim(rtrim(number_format($val / 1e9, 1), '0'), '.') . ' B';
    }
    if ($val >= 1e6) {
        return rtrim(rtrim(number_format($val / 1e6, 1), '0'), '.') . ' M';
    }
    if ($val >= 1e3) {
        return rtrim(rtrim(number_format($val / 1e3, 1), '0'), '.') . ' K';
    }
    return number_format($val); // 👈 formato normal con separadores de miles
}

function esUrlValida($cadena) {
    return filter_var($cadena, FILTER_VALIDATE_URL) !== false;
}