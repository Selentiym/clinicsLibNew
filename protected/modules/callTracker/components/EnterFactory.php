<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.11.2016
 * Time: 15:56
 */
class EnterFactory extends aEnterFactory {
    /**
     * @return aEnter
     */
    public function build() {
        $enter = null;
        //Для случая ajax обращения к серверу.
        if ($id = $_POST['id_enter']) {
            $enter = Enter::model()->findByPk($id);
        }

        $temp = $this -> _module -> getCachedId();
        if (!is_a($enter, 'aEnter')) {
            $enter = Enter::model() -> findByPk($temp);
            //Обнуляем заход, если давно не было обращений и он загружен из куки.
            if (is_a($enter, 'aEnter')) {
                if (!((int)$enter -> active)) {
                    $enter = null;
                }
            }
        }
        //Если не найден заход, то создаем его заново
        if (!is_a($enter, 'aEnter')) {
            $enter = $this -> buildNew();
        }
        return $enter;
    }
    public function buildNew() {
        return new Enter();
    }

    /**
     * @return aEnter[]
     */
    public function giveUnfinished(){
        $crit = new CDbCriteria();
        $crit -> compare('active','1');
        return Enter::model() -> findAll($crit);
    }
}