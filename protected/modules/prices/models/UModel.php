<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.04.2016
 * Time: 22:44
 */
class UModel extends CActiveRecord {

    /**
     * @arg array get - the $_GET variable.
     * This function is used to set some initial properties of the model
     * that are populated from the url
     */
    public function readData($get){
        return;
    }
    /**
 * @return integer - id of the first price
 */
    public static function trivialId(){
        return self::model() -> find() -> id;
    }

    /**
     * @return bool whether the user has the right to create, update or delete
     * a record of this class
     */
    public function checkCreateAccess(){
        return true;
    }
    public function checkUpdateAccess(){
        return true;
    }
    public function checkDeleteAccess(){
        return true;
    }
    /**
     * Sets CustomFlash with information about errors;1
     */
    public function explainErrors(){
        return;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Price the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * Function to be used in ViewModel action to have more flexibility
     * @arg mixed arg - the argument populated from the controller.
     * @arg string scenario - scenario that is to be assigned to the model
     */
    public $scenario = false;
    public function customFind($arg, $external = false, $scenario = false){
        $model =  $this -> model() -> findByPk($arg);
        if ($scenario) {
            $model -> setScenario($scenario);
        }
        return $model;
    }
}
?>