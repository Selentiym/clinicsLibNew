<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.12.2016
 * Time: 18:11
 */
class CustomEnterFactory extends EnterFactory {
    public function buildNew() {
        return new CustomEnter();
    }
}