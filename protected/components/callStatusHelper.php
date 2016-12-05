<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.12.2016
 * Time: 21:26
 */
class callStatusHelper {
    public static $statuses = [
        'verified' => 60,
        'missed' => 30,
        'cancelled' => 40,
        'side' => 10,
        'declined' => 20,
        'assigned' => 50,
    ];
    public static function getStatusesArray(){
        return self::$statuses;
    }
    public static function getClassName($id) {
        $flipped = array_flip(self::getStatusesArray());
        return $flipped[$id];
    }
    public static function getClassId($name){
        return self::getStatusesArray()[$name];
    }

    /**
     * Obtain status grounding on the standard rules
     * @param string $report report string from the data source
     * @param string $state call state
     * @return integer $id
     */
    public static function standardProcedure($report, $state){
        //Если у звонка проставлен статус(поле SA), то смотрим на него.
        $arr = self::getStatusesArray();
        switch ($state) {
            case 'Y':
                return $arr['verified'];
                break;
            case 'N':
                return $arr['missed'];
                break;
            case 'O':
                return $arr['cancelled'];
                break;
        }
        //Если есть слово отмена в отчете, значит запись отменена.
        if (strstr($report, 'отмена')) {
            return $arr['cancelled'];
        }
        //Если есть слово спам в отчете, значит звонок нецелевой.
        if (strstr($report, 'спам')) {
            return $arr['side'];
        }
        //Если в поле "отчет" есть буквы, то НЕ записан.
        if (preg_match('/[a-zA-Zа-яА-Я]/',$report)) {
            return $arr['declined'];
        } else {
            return $arr['assigned'];
        }
    }
}