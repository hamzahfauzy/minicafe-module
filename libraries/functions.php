<?php

use Core\Database;
use Core\Event;

Event::register('crud/create/default/users', function($createData){
    $db = new Database;
    $role = $_GET['filter']['role_name'];
    $role = $db->single('roles', [
        'name' => $role
    ]);

    $db->insert('user_roles', [
        'role_id' => $role->id,
        'user_id' => $createData->id
    ]);

    $role_name = strtolower($role->name) . 's';
    $role_name_locale = __('minicafe.label.'.$role_name);

    set_flash_msg(['success'=>"$role_name_locale berhasil ditambahkan"]);
    header('location:'.routeTo('minicafe/'.$role_name));
    die;
});

Event::register('crud/delete/default/users', function($createData){
    $db = new Database;
    $role = $_GET['filter']['role_name'];
    $role = $db->single('roles', [
        'name' => $role
    ]);

    $role_name = strtolower($role->name) . 's';
    $role_name_locale = __('minicafe.label.'.$role_name);

    set_flash_msg(['success'=>"$role_name_locale berhasil dihapus"]);
    header('location:'.routeTo('minicafe/'.$role_name));
    die;
});

\Modules\Default\Libraries\Sdk\Dashboard::add('minicafeDashboardMenu');

function minicafeDashboardMenu()
{
    return view('minicafe/views/dashboard/menu');
}