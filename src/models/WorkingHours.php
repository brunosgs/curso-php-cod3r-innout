<?php
class WorkingHours extends Model
{
    protected static $tableName = 'working_hours';
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];

    public static function loadFromUserAndDate($userId, $workDate)
    {
        $registry = self::getOne([
            'user_id' => $userId,
            'work_date' => $workDate
        ]);

        if (!$registry) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ]);
        }

        return $registry;
    }

    public static function getMonthlyReport($userId, $date)
    {
        $registries = [];
        $startDate = getFirstDayOfMonth($date)->format('Y-m-d');
        $endDate = getLastDayOfMonth($date)->format('Y-m-d');

        $result = static::getResultSetFromSelect([
            'user_id' => $userId,
            'raw' => "work_date between '{$startDate}' and '{$endDate}' "
        ]);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $registries[$row['work_date']] = new WorkingHours($row);
            }
        }

        return $registries;
    }

    public function getNextTime()
    {
        if (!$this->time1) {
            return 'time1';
        }

        if (!$this->time2) {
            return 'time2';
        }

        if (!$this->time3) {
            return 'time3';
        }

        if (!$this->time4) {
            return 'time4';
        }

        return null;
    }

    public function getActiveClock()
    {
        $nextTime = $this->getNextTime();

        if ($nextTime === 'time1' || $nextTime === 'time3') {
            return 'exitTime';
        } else if ($nextTime === 'time2' || $nextTime === 'time4') {
            return 'workedInterval';
        } else {
            return null;
        }
    }

    public function innout($time)
    {
        $timeColumn = $this->getNextTime();

        if (!$timeColumn) {
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }

        $this->$timeColumn = $time;

        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    function getWorkedInterval()
    {
        [$t1, $t2, $t3, $t4] = $this->getTimes();
        $morning = new DateInterval('PT0S'); // Criando um DateInterval que tem 0 segundos.
        $evening = new DateInterval('PT0S');

        if ($t1) {
            $morning = $t1->diff(new DateTime());
        }

        if ($t2) {
            $morning = $t1->diff($t2);
        }

        if ($t3) {
            $evening = $t3->diff(new DateTime());
        }

        if ($t4) {
            $evening = $t3->diff($t4);
        }

        return sumIntervals($morning, $evening);
    }

    function getLunchInterval()
    {
        [, $t2, $t3,] = $this->getTimes();
        $lunchInterval = new DateInterval('PT0S');

        if ($t2) {
            $lunchInterval = $t2->diff(new DateTime());
        }

        if ($t3) {
            $lunchInterval = $t2->diff($t3);
        }

        return $lunchInterval;
    }

    function getExitTime()
    {
        [$t1,,, $t4] = $this->getTimes();
        $workday = DateInterval::createFromDateString('8 hours');

        if (!$t1) {
            return (new DateTimeImmutable())->add($workday);
        } elseif ($t4) {
            return $t4;
        } else {
            $total = sumIntervals($workday, $this->getLunchInterval());

            return $t1->add($total);
        }
    }

    private function getTimes()
    {
        $times = [];

        if ($this->time1) {
            array_push($times, getDateFromString($this->time1));
        } else {
            array_push($times, null);
        }

        if ($this->time2) {
            array_push($times, getDateFromString($this->time2));
        } else {
            array_push($times, null);
        }

        if ($this->time3) {
            array_push($times, getDateFromString($this->time3));
        } else {
            array_push($times, null);
        }

        if ($this->time4) {
            array_push($times, getDateFromString($this->time4));
        } else {
            array_push($times, null);
        }

        return $times;
    }
}
