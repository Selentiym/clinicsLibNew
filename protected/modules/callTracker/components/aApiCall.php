<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.11.2016
 * Time: 16:55
 */
abstract class aApiCall extends CActiveRecord implements iApiCall {
    public function saveChanges() {
        return $this -> save();
    }
}