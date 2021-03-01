<?php
loadModel('WorkingHours');

// É executado as querys para limpar o banco
Database::executeSQL('delete from working_hours');
Database::executeSQL('delete from users where id > 5');

function getDayTemplateByOdds($regularRate, $extraRate, $lazyRate)
{
    $regularDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME
    ];

    $extraHourDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '18:00:00',
        'worked_time' => DAILY_TIME + 3600
    ];

    $lazyDayTemplate = [
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME - 1800
    ];

    $lazyRate = $regularRate + $extraRate;
    $value = rand(0, 100);

    if ($value <= $regularRate) {
        return $regularDayTemplate;
    } elseif ($value <= $lazyRate) {
        return $extraHourDayTemplate;
    } else {
        return $lazyDayTemplate;
    }
}

function populateWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate)
{
    $currentDate = $initialDate;
    $yesterday = new DateTime();
    $yesterday->modify('-1 day');

    $columns = [
        'user_id' => $userId,
        'work_date' => $currentDate
    ];

    while (isBefore($currentDate, $yesterday)) {
        if (!isWeekend($currentDate)) {
            $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);
            $columns = array_merge($columns, $template);
            $workingHours = new WorkingHours($columns);

            $workingHours->insert();
        }

        $currentDate = getNextDay($currentDate)->format('Y-m-d');
        $columns['work_date'] = $currentDate;
    }
}

$lastMoth = strtotime('first day of last month');

populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);
populateWorkingHours(3, date('Y-m-d', $lastMoth), 20, 75, 5);
populateWorkingHours(4, date('Y-m-d', $lastMoth), 20, 10, 70);

echo 'Ok';