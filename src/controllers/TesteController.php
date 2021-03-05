<?php
// Controller temporário
loadModel('WorkingHours');

$wh = WorkingHours::loadFromUserAndDate(1, date('Y-m-d'));
$workedInterval = $wh->getWorkedInterval()->format('%H:%I:%S');
$lunchInterval = $wh->getLunchInterval()->format('%H:%I:%S');

var_dump($workedInterval);
echo "<br>";
var_dump($lunchInterval);