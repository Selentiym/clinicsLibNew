<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.12.2016
 * Time: 18:21
 */
class CustomEnter extends Enter {
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ct_enter';
    }
    /**
     * //В общем случае будет self::NUMBER_CLASS
     * @return aNumber
     */
    public function obtainNumber() {

        //Выдаем номер с каруселькой только если человек пришел с рекламы
        if ($this -> fromDirect()) {
            $num = parent::obtainNumber();
        }
        if (!is_a($num, 'aNumber')) {
            $num = $this->numberForSearch();
        }
        if (!is_a($num, 'aNumber')) {
            $num  = current(phNumber::model() -> getReserved());
        }
        $this -> setNumber($num);
        return $num;
    }

    public function numberForSearch() {
        return phNumber::model() -> findByAttributes(['forSearch' => 1, 'noCarousel' => 1]);
    }
    /**
     * @return bool
     */
    public function fromDirect() {
        return ($_GET["utm_medium"]=="cpc");
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