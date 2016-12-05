<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.2016
 * Time: 21:39
 */
abstract class aEnter extends CActiveRecord {
    /**
     * @return aEnter
     */
    public function collectDataFromRequest() {
        //Если задан новый поисковой запрос, то нам необходимо выделить новый телефон.
        //Для корректного трекинга
        $temp = $this;
        $data = $_GET;
        if (($data['utm_term'] != $temp -> utm_term)&&(isset($data['utm_term']))) {
            $temp = aEnterFactory::getFactory() -> buildNew();
        }
        return $temp;
    }

    /**
     * @return string
     */
    public function primaryKey() {
        return 'id';
    }

    /**
     * Возвращает массив заходов, которые на данный момент не завершены.
     * @return static[]
     */
    abstract public function giveUnfinished();

    /**
     * @return bool
     */
    abstract public function endOneself();

    /**
     * @return aNumber
     */
    abstract public function obtainNumber();

    /**
     * @return aNumber
     */
    abstract public function getNumber();
    /**
     * @param aNumber $val
     */
    abstract public function setNumber(aNumber $val);

    /**
     * sets the inner number variable to NULL
     */
    abstract public function unsetNumber();

    /**
     * @return bool
     */
    abstract public function checkTimeValidity();

    /**
     * Записваем информацию о том, что заход был успешен
     * (позвонили)
     */
    abstract public function markAsSuccessful();

    /**
     * @param iApiCall $apiCall
     */
    abstract public function linkApiCall(iApiCall $apiCall);

    /**
     * @return iExperiment
     */
    abstract public function getExperiment();
}