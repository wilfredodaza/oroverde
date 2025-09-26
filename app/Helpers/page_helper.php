<?php
use App\Models\ConfigPage;
use App\Models\Menu;

function getConfigPage(){
    $c_model = new ConfigPage();
    $config = $c_model->first();
    return $config;
}

function getMenu(){
    $m_modal = new Menu();
    $menus = $m_modal->where([
        'type_menu' => 'Pagina',
        'show'      => 'Si'
    ])->findAll();

    
    foreach($menus as $key => $menu) {
        $menu->sub_menu = $m_modal->where(['references' => $menu->id])->findAll();
    }
    return $menus;
    // var_dump($menus); die;
}

function convertirPesoArchivo($rutaArchivo) {
    $rutaArchivo = FCPATH . $rutaArchivo;
    if (!file_exists($rutaArchivo)) return false;

    $bytes = filesize($rutaArchivo);

    if ($bytes >= 1073741824) {
        $size = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $size = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $size = number_format($bytes / 1024, 2) . ' KB';
    } else {
        $size = $bytes . ' bytes';
    }



    return $size;
}

function getIconFile($nombreArchivo) {
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

    $iconos = [
        // Documentos
        'pdf' => 'ri-file-pdf-line',
        'doc' => 'ri-file-word-line',
        'docx' => 'ri-file-word-line',
        'xls' => 'ri-file-excel-line',
        'xlsx' => 'ri-file-excel-line',
        'ppt' => 'ri-file-ppt-line',
        'pptx' => 'ri-file-ppt-line',
        'txt' => 'ri-file-text-line',

        // Imágenes
        'jpg' => 'ri-image-line',
        'jpeg' => 'ri-image-line',
        'png' => 'ri-image-line',
        'gif' => 'ri-image-line',
        'svg' => 'ri-image-line',
        'webp' => 'ri-image-line',

        // Videos
        'mp4' => 'ri-video-line',
        'avi' => 'ri-video-line',
        'mov' => 'ri-video-line',
        'mkv' => 'ri-video-line',

        // Audios
        'mp3' => 'ri-music-line',
        'wav' => 'ri-music-line',

        // Archivos comprimidos
        'zip' => 'ri-folder-zip-line',
        'rar' => 'ri-folder-zip-line',

        // Código
        'html' => 'ri-code-line',
        'css' => 'ri-code-line',
        'js' => 'ri-code-line',
        'php' => 'ri-code-line',

        // Otros
        'default' => 'ri-file-line',
    ];

    return $iconos[$extension] ?? $iconos['default'];
}
