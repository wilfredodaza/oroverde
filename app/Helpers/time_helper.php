<?php

use CodeIgniter\I18n\Time;

function different($data)
{
    $myTime = new Time('now', 'America/Bogota', 'es_CO');
    $time = Time::parse($data, 'America/Bogota', 'es_CO');
    $diff =  $time->difference($myTime, 'America/Bogota');
    return $diff->humanize();
}

function formatDate($fecha){
    $meses = [
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
    ];
    
    // $fecha = date('Y-m-d'); // "2025-03-11"
    $partes = explode('-', $fecha);
    
    $dia = (int)$partes[2];
    $mes = $meses[(int)$partes[1]];
    $anio = $partes[0];
    
    return "$dia de $mes de $anio";
    
}

function formatDateDay($fecha){
    $meses = [
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
    ];
    
    // $fecha = date('Y-m-d'); // "2025-03-11"
    $partes = explode('-', $fecha);
    
    $dia = (int)$partes[2];
    $mes = $meses[(int)$partes[1]];
    
    return "$dia de $mes";
    
}

function getImagesByYear($images, $year) {
    return array_filter($images, function($img) use ($year) {
        return $year == date('Y', strtotime($img->created_at));
    });
}

function getYearsImage($fechas){
    
    // Extraer solo el año de cada fecha
    $anios = array_map(fn($f) => date('Y', strtotime($f->created_at)), $fechas);
    
    // Eliminar duplicados
    $aniosUnicos = array_unique($anios);
    
    // Reindexar el array (opcional)
    $aniosUnicos = array_values($aniosUnicos);

    rsort($aniosUnicos);

    return $aniosUnicos;
}

function groupImagesByReadableDate($images) {
    $grouped = [];

    foreach ($images as $img) {
        // Obtener el formato "1 de junio" (puedes usar tu propia función formatDateDay)
        $key = formatDateDay($img->created_at);
        $key = trim(ucfirst($key));

        if (!isset($grouped[$key])) {
            $grouped[$key] = (object) [
                "date" => $key,
                "images" => [],
                "timestamp" => strtotime($img->created_at) // 🔹 Guardamos la fecha para ordenar luego
            ];
        }

        $grouped[$key]->images[] = $img;
    }

    // 🔹 Ordenar las imágenes dentro de cada grupo (menor a mayor)
    foreach ($grouped as &$group) {
        usort($group->images, function($a, $b) {
            return strtotime($a->created_at) - strtotime($b->created_at);
        });
    }

    // 🔹 Ordenar los grupos por timestamp (no por texto)
    usort($grouped, function($a, $b) {
        return $a->timestamp - $b->timestamp; // menor a mayor
    });

    // 🔹 Remover el timestamp antes de devolver
    return array_map(function($g) {
        unset($g->timestamp);
        return $g;
    }, $grouped);
}

function getEmbedUrl($url) {
    if (strpos($url, 'watch?v=') !== false) {
        $videoId = explode('watch?v=', $url)[1];
        $videoId = explode('&', $videoId)[0]; // elimina parámetros extra
        return "https://www.youtube.com/embed/{$videoId}";
    }
    return $url; // si ya es embed o es de otro tipo
}