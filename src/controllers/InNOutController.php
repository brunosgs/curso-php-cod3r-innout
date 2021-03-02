<?php
session_start();
requireValidSession();
loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

try {
    $currentTime = strftime('%H:%M:%S', time());
    
    $records->innout($currentTime);
    
    addSuccessMessage('Ponto inserido com sucesso!');
} catch (AppException $e) {
    addErrorMessage($e->getMessage());
}

header("Location: DayRecordsController.php");