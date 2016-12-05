<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.11.2016
 * Time: 13:38
 */
abstract class aApiCallFactory {
    /**
     * @var aApiCallFactory
     */
    protected static $_apiCallFactory;
    /**
     * @return iApiCall
     */
    abstract public function build();

    public static function getFactory() {
        //Фабрику мы хотим создавать только одну на весь период пользования
        if (!static::$_apiCallFactory) {
            //Тут можно разместить алгоритм выбора конкретной фабрики
            static::$_apiCallFactory = new TCallFactory();
        }
        return static::$_apiCallFactory;
    }
}