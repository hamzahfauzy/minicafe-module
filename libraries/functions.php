<?php

use Core\Database;
use Core\Event;

Event::register('crud/create/minicafe/users', function($createData){
    if(isset($_GET['filter']))
    {
        $db = new Database;
        $role = $_GET['filter']['role_name'];
        $role = $db->single('roles', [
            'name' => $role
        ]);
    
        $db->insert('user_roles', [
            'role_id' => $role->id,
            'user_id' => $createData->id
        ]);

        $db->insert('mc_employees', [
            'user_id' => $createData->id,
            'cafe_id' => $_POST['cafe']
        ]);
    
        $role_name = strtolower($role->name) . 's';
        $role_name_locale = __('minicafe.label.'.$role_name);
    
        set_flash_msg(['success'=>"$role_name_locale berhasil ditambahkan"]);
        header('location:'.routeTo('minicafe/'.$role_name));
        die;
    }
});

Event::register('crud/delete/minicafe/users', function($createData){
    if(isset($_GET['filter']))
    {
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
    }
});

\Modules\Default\Libraries\Sdk\Dashboard::add('minicafeDashboardMenu');

function minicafeDashboardMenu()
{
    return view('minicafe/views/dashboard/menu');
}

$auth = auth();
$db = new Database;
if($auth && in_array(get_role($auth->id)->name, ['Operator','Waiter','Kitchen']))
{
    $employee = $db->single('mc_employees', [
        'user_id' => $auth->id
    ]);

    $employee->cafe = $db->single('mc_cafes',[
        'id' => $employee->cafe_id
    ]);

    $_SESSION['employee'] = $employee;
}