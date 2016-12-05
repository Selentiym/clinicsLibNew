<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.11.2016
 * Time: 19:37
 */
class SimpleGDFactory extends aGDCallFactory{
    /**
     * @param string $link
     * @return GDCall|null
     */
    public function buildByLink($link) {
        if ($link) {
            $entry = $this -> api ->getEntryByUrl($link);
            if (is_a($entry, '\Google\Spreadsheet\ListEntry')) {
                return $this -> buildByEntry($entry);
            }
        }
        return null;
    }
    public function buildByRecord(aGDCall $gdCall) {
        if (!$gdCall) {
            throw new GoogleDocApiException('Invalid argument for '.__CLASS__.'::buildByRecord. (bool) = false!');
        }
        $rez = $this -> buildByLink($gdCall -> external_id);
        $lookMore = !$gdCall -> compareWith($rez);
        //Ищем через поля только если заметили какое-то несоответствие.
        //Это менее точный поиск, но что уж поделать
        if (!$lookMore) {
            return $rez;
        }
        $cond = ['number' => $gdCall -> getNumber()];
        $cond = array_merge($cond, $this -> getFrame($gdCall -> getCallTime()));
        return $this -> buildByInfo($cond);
    }

    private function getFrame($time = null) {
        if (!$time) {
            $time = time();
        }
        return [
            'time' => $time,
            'from' => $time - 3600 * 24 * 5,
            'to' => $time + 3600 * 24 * 5
        ];
    }

    public function buildByEntry($entry){
        $obj = new GdCallDBCached();
        $obj -> initialize($entry, $this);
        return $obj;
        //return new GDCall($entry, $this);
    }

    /**
     * @param Google\Spreadsheet\ListEntry[] $entries
     * @return GDCall[]
     */
    public function buildByEntries($entries){
        return array_map(function($entry) {
            if (is_a($entry, 'Google\Spreadsheet\ListEntry')) {
                return $this->buildByEntry($entry);
            }
            return false;
        }, $entries);
    }


    /**
     * @param mixed[] $info
     * @return Google\Spreadsheet\ListEntry[]
     */
    public function buildByInfo($info) {
        //Задаем параметры времени
        $time = $info['time'] > 0 ? $info['time'] : 'noTime';
        $corridor = $this -> getFrame($time == 'noTime' ? null : $time );
        if  ($info['from'] > 0) {
            $from = $info['from'];
        } /*elseif ($time != 'noTime') {
            $from = $time;
        }*/ else {
            $from = $corridor['from'];
        }
        if  ($info['to'] > 0) {
            $to = $info['to'];
        } /*elseif ($time != 'noTime') {
            $to = $time;
        } */ else {
            $to = $corridor['to'];
        }
        //Задали время. Теперь выдаем ошибочки, если они есть

        if ($from > $to) {
            return 'no from-to corridor left!';
        }
        if ($time != 'noTime') {
            if (($time > $to) || ($time < $from)) {
                return 'time ids not between from and to';
            }
        }
        $cond = $this -> getBaseCondition($info);
        /**
         * Запрос по конкретному времени, если таковое задано
         */
        if ($time != 'noTime') {
            $withDayCond = self::addCond($cond, 'дата = "'.date('j.m', $time).'"');
            $withDay = $this -> ScanGoogle(['sq' => $withDayCond['condition']], $time);
            if (!empty($withDay)) {
                return $this -> buildByEntries($withDay);
            }
        }
        /**
         * Конец запроса по времени
         */
        $rez = [];
        $scans = 0;
        $stopMonth = date('n', $to);
        $curMonth = date('n', $from);
        $stopMonth += $curMonth > $stopMonth ? 12 : 0;
        while($stopMonth >= $curMonth) {
            $scans++;
            $curMonth ++;
            $found = [];
            $found = $this -> ScanGoogle(['sq' => $cond['condition']], $from);
            $rez = array_merge($found, $rez);
            $from = strtotime('+1 month', $from);
            if ($scans > 3) {
                break;
            }
        }
        return $this -> buildByEntries($rez);
    }

    public function getYear() {
        return date('Y');
    }

    /**
     * @param mixed[] $args - an array to be given to the google api
     * @param integer $referenceTime
     * @return Google\Spreadsheet\ListEntry[]|null
     */
    private function ScanGoogle($args, $referenceTime) {
        if (!$referenceTime) {
            return null;
        }
        $months = [1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November',12 => 'December'];
        $arr = getdate($referenceTime);
        $month = $arr['mon'];
        $year = $arr['year'];
        //Получили название листа гугл дока.
        $work = $arr['month'].' '.$year;
        //$data = $this -> api -> giveData([],false,$work);
        $send = $this -> api -> setWorkArea(false, $work);
        //Если не удалось по какой-либо причине выбрать лист, то нафиг.
        if (!$send) {
            return [];
        }
        $data = $this -> api -> giveData($args,false,$work);

        return $data -> getEntries();
    }

    /**
     * @param mixed[] $info
     * @return mixed[] - the condition array. Counts the parameters
     */
    private function getBaseCondition($info) {
        $cond = ['condition' => '','params' => 0];
        //Базовые условия только на mangoTalker
        $num = preg_replace('/[^\d]/','',$info['number']);
        $str ='mangotalkerномер = "'.$num.'"';
        $cond = self::addCond($cond, $str);
        return $cond;
    }

    /**
     * @param $was
     * @param $toAdd
     * @param string $op
     * @return mixed
     */
    public static function addCond($was, $toAdd, $op = 'and') {
        if ($toAdd) {
            if ($was['params'] > 0) {
                $toAdd = " $op " . $toAdd;
            }
            $was['condition'] .= $toAdd;
            $was['params'] ++;
        }
        return $was;
    }
    //asd
}