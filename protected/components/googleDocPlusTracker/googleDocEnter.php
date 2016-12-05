<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.12.2016
 * Time: 20:47
 */

/**
 * Class googleDocEnter надстройка на Enter для реализации интерфейсов
 * вывода статистики.
 * The followings are the available model relations:
 * @property GDCallDBCached[] $cachedGDs
 * @property integer $cachedGDsNum
 */
class googleDocEnter extends Enter {
    /**
     * @var aGDCall[] $_gdCalls
     */
    private $_gdCalls;
    /**
     * @var integer $_status
     */
    private $_statusVar;

    /**
     * @var bool $_DBStatusOnly
     */
    private $_DBStatusOnly = true;

    public function relations(){
        return array_merge(parent::relations(),[
            'cachedGDs' => array(self::HAS_MANY, 'GDCallDBCached', 'id_enter'),
            'cachedGDsNum' => array(self::STAT, 'GDCallDBCached', 'id_enter'),
        ]);
    }

    public function getGDCalls() {
        if (!isset($this -> _gdCalls)) {
            if ($this -> cachedGDsNum > 0) {
                $this -> _gdCalls = $this -> cachedGDs;
            } else {
                $this->_gdCalls = $this->refreshGDCalls();
            }
        }
        return $this -> _gdCalls;
    }

    /**
     * @return aGDCall[]
     */
    public function refreshGDCalls() {
        unset($this -> _status);
        /**
         * @type googleDocEnter $target
         */
        $calls = $this -> tCalls;
        $mangos = [];
        foreach ($calls as $call) {
            $mango = preg_replace('/[^\d]/','',$call -> CallerIDNum);
            $mangos[$mango] = strtotime($call -> called);
        }
        $module = Yii::app() -> getModule('googleDoc');
        /**
         * @type GoogleDocModule $module
         */
        $rez = [];
        foreach ($mangos as $mango => $time) {
            $rez = array_merge($rez,$module -> lookForGD([
                'number' => $mango,
                'time' => $time
            ]));
        }
        $externals = array_map(function($gd){ return $gd -> external_id; },$this -> cachedGDs);
        foreach ($rez as $gdCall) {
            /**
             * @type GdCallDBCached $gdCall
             */
            if (!in_array($gdCall -> external_id, $externals)) {
                $gdCall -> id_enter = $this -> id;
                if (!$gdCall -> save()) {
                    $err = $gdCall -> getErrors();
                }
            }
        }
        return $rez;
    }
    /**
     * Возвращает статус звонка.
     * Сейчас работает по самому оптимистичному варианту.
     */
    public function getStatus() {
        if (!$this -> _statusVar) {
            $this -> _statusVar = $this -> getStatusByGdCalls($this->getGDCalls());
        }
        return $this -> _statusVar;
    }
    public function getCachedStatus() {
        if (!$this -> _statusVar) {
            $this -> _statusVar = $this -> getStatusByGdCalls($this->cachedGDs);
        }
        return $this -> _statusVar;
    }

    /**
     * @param GDCall[] $gdCalls
     * @return int
     */
    private function getStatusByGdCalls($gdCalls){
        $status = -1;
        foreach ($gdCalls as $gdCall) {
            if ($gdCall->getStatus() > $status) {
                $status = $gdCall->getStatus();
            }
        }
        return $status;
    }
    protected function instantiate($attributes) {
        $class=get_class($this);
        $model=new $class(null);
        return $model;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Enter the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}