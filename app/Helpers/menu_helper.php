<?php

use App\Models\Menu;
use App\Models\Permission;


function menu($type_menu)
{
    $menu = new Menu();
    if (session()->get('user')->role_id == 1) {
        $data = $menu->where(['type' => 'primario', 'status' => 'active', 'type_menu' => $type_menu])
            ->get()
            ->getResult();
    } else {
        $permission = new Permission();
        $data = $permission->select('menus.*')
            ->where('role_id', session()->get('user')->role_id)
            ->where('menus.type', 'primario')
            ->where('menus.type_menu', $type_menu)
            ->join('menus', 'menus.id = permissions.menu_id')
            ->join('roles', 'roles.id = permissions.role_id')
            ->get()
            ->getResult();
    }
    return $data;
}

function menus($type_menu){
    $m_model = new Menu();
    $permission = new Permission();
    if (session()->get('user')->role_id == 1) {
        $data = $m_model->where(['type' => 'primario', 'status' => 'active', 'type_menu' => $type_menu])
            ->orderBy('position', 'ASC')->findAll();
    } else {
        $data = $permission->select(['menus.*'])
            ->where([
                'role_id'       => session('user')->role_id,
                'menus.type'    => 'primario',
                'menus.type_menu' => $type_menu
            ])
            ->join('menus', 'menus.id = permissions.menu_id', 'left')
            ->join('roles', 'roles.id = permissions.role_id', 'left')
            ->orderBy('position', 'ASC')
            ->findAll();
    }

    foreach ($data as $key => $menu) {
        if (session('user')->role_id == 1) {
            $menu->menu_secundario = $m_model->where([
                'type'          => 'secundario',
                'status'        => 'active',
                'references'    => $menu->id
            ])->orderBy('position', 'ASC')->findAll();
            foreach ($menu->menu_secundario as $key => $menu_secundario) {
                // Cargar menús terciarios para cada menú secundario
                $menu_secundario->menu_terciario = $m_model->where([
                    'type'          => 'terciario',
                    'status'        => 'active',
                    'references'    => $menu_secundario->id
                ])->orderBy('position', 'ASC')->findAll();
                foreach ($menu_secundario->menu_terciario as $key => $menu_terciario) {
                    $menu_terciario->base_url = urlOption($menu_terciario->id, 'terciario');
                }
                // Si tiene menús terciarios, el base_url debe ser JavaScript:void(0)
                $menu_secundario->base_url = count($menu_secundario->menu_terciario) > 0 ? urlOption() : urlOption($menu_secundario->id, 'secundario');
            }
        }else {
            $menu->menu_secundario = $permission->select('menus.*')
            ->where([
                'role_id'       => session('user')->role_id,
                'menus.type'    => 'secundario',
                'references'    => $menu->id
            ])
            ->join('menus', 'menus.id = permissions.menu_id')
            ->join('roles', 'roles.id = permissions.role_id')
            ->orderBy('position', 'ASC')
            ->findAll();
            foreach ($menu->menu_secundario as $key => $menu_secundario) {
                // Cargar menús terciarios para cada menú secundario
                $menu_secundario->menu_terciario = $permission->select('menus.*')
                    ->where([
                        'role_id'       => session('user')->role_id,
                        'menus.type'    => 'terciario',
                        'references'    => $menu_secundario->id
                    ])
                    ->join('menus', 'menus.id = permissions.menu_id')
                    ->join('roles', 'roles.id = permissions.role_id')
                    ->orderBy('position', 'ASC')
                    ->findAll();
                foreach ($menu_secundario->menu_terciario as $key => $menu_terciario) {
                    $menu_terciario->base_url = urlOption($menu_terciario->id, 'terciario');
                }
                // Si tiene menús terciarios, el base_url debe ser JavaScript:void(0)
                $menu_secundario->base_url = count($menu_secundario->menu_terciario) > 0 ? urlOption() : urlOption($menu_secundario->id, 'secundario');
            }
        }
        $menu->base_url = count($menu->menu_secundario) > 0 ? urlOption() : urlOption($menu->id);

        

    }

    return $data;
}

function submenu($refences, $type = 'secundario')
{
    $menu = new Menu();
    if (session()->get('user')->role_id == 1) {
        $data = $menu->where(['type' => $type, 'status' => 'active', 'references' => $refences])
            ->get()
                ->getResult();
    } else {
        $permission = new Permission();
        $data = $permission->select('menus.*')
            ->where([
                'role_id'       => session('user')->role_id,
                'menus.type'    => $type,
                'references'    => $refences
            ])
            ->join('menus', 'menus.id = permissions.menu_id')
            ->join('roles', 'roles.id = permissions.role_id')
            ->get()
            ->getResult();
    }
    return $data;
}

function countMenu($references, $type = 'secundario')
{
    $menu = new Menu();
    $data = $menu->where(['type' => $type, 'status' => 'active', 'references' => $references])
        ->get()
        ->getResult();
    if (count($data) > 0) {
        return true;
    }
    return false;
}

function urlOption($references = null, $type = 'secundario')
{
    if ($references) {
        $menu = new Menu();
        $data = $menu->find($references);
        if ($data->component == 'table') {
            if($data->type_menu == "Pagina" && $data->type == $type)
                $data->url = "{$data->url}/{$data->references}";
            return base_url(["table", $data->url]);
        } else if ($data->component == 'controller') {
            return base_url(["dashboard", $data->url]);
        }
    } else {
        return 'JavaScript:void(0)';
    }

}

function isActive($data)
{
    if(base_url(uri_string()) == $data) {
        return 'active';
    }
}

function subActive($id, $type = 'secundario'){
    $m_model = new Menu();
    $data = $m_model->where([
        'type'          => $type,
        'status'        => 'active',
        'references'    => $id
    ])->findAll();
    $valid = '';
    foreach($data as $menu){
        if(base_url(uri_string()) == urlOption($menu->id, $type))
            $valid = 'active open';
        
        // Si es secundario, también verificar si algún terciario está activo
        if($type == 'secundario') {
            $terciarios = $m_model->where([
                'type'          => 'terciario',
                'status'        => 'active',
                'references'    => $menu->id
            ])->findAll();
            foreach($terciarios as $terciario){
                if(base_url(uri_string()) == urlOption($terciario->id, 'terciario'))
                    $valid = 'active open';
            }
        }
    }
    return $valid;
}

