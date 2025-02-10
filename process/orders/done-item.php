<?php

use Core\Database;

$db = new Database;
$item = $db->single('mc_order_items', ['id' => $_GET['id']]);
$logs = $item->logs ? json_decode($item->logs, 1) : [];
$logs[date('Y-m-d H:i:s')] = "DONE by " . auth()->name . " (".auth()->id.") at ". date('Y-m-d H:i:s');
$db->update('mc_order_items', [
    'status' => 'DONE',
    'logs'   => json_encode($logs)
], [
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>"Pesanan berhasil diselesaikan"]);

header('location:'.routeTo('crud/index', ['table' => 'mc_order_items']));
die();