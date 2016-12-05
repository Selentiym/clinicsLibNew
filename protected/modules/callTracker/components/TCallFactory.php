<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.11.2016
 * Time: 13:44
 */
class TCallFactory extends aApiCallFactory {
    public function build() {
        return new TCall();
    }
}