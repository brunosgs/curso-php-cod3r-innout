<?php
session_start();
requireValidSession();
loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
$currentTime = strftime('%H:%M:%S', time());

$records->innout($currentTime);
header("Location: DayRecordsController.php");