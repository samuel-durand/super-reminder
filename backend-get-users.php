<?php
require_once('Class/Task.php');

$taskCrud = new TaskCrud($db);
$tasks = $taskCrud->getTasks();

header('Content-Type: application/json');
echo json_encode($tasks);
?>
