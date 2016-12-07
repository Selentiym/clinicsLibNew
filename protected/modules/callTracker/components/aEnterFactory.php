<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.11.2016
 * Time: 16:27
 */
abstract class aEnterFactory {
    /**
     * @var CallTrackerModule
     */
    protected $_module;
    /**
     * @var CallTrackerModule $module
     * Это общий параметр для всех aEnterFabric
     * В нем хранится последний использованный модуль на случай, если
     * при очередном создании фабрики модуль опущен
     */
    public static $module;
    /**
     * @var aEnterFactory
     */
    protected static $_enterFactory;
    public function __construct(CallTrackerModule $module) {
        $this -> _module = $module;
    }
    /**
     * @return aEnter
     */
    abstract public function build();

    /**
     * Выдает новый объект, не используя никакие кэширования
     * @return aEnter
     */
    abstract public function buildNew();
    /**
     * @return aEnter[]
     */
    abstract public function giveUnfinished();

    /**
     * @param CallTrackerModule|null $module
     * @return aEnterFactory
     */
    public static function getFactory(CallTrackerModule $module = null) {
        if ($module !== null) {
            //Кэшируем модуль, для которого создаются фабрики
            static::setModule($module);
        } else {
            //Или достаем из кэша, если он нам не дан
            $module = self::getModule();
        }
        //Фабрику мы хотим создавать только одну на весь период пользования
        if (!static::$_enterFactory) {
            //Тут можно разместить алгоритм выбора конкретной фабрики
            static::$_enterFactory = new EnterFactory($module);
        }
        return static::$_enterFactory;
    }

    public static function setEnterFactory(aEnterFactory $factory){
        if ($factory) {
            static::$_enterFactory = $factory;
        }
    }

    /**
     * @param CallTrackerModule $module
     */
    public static function setModule(CallTrackerModule $module) {
        if ($module !== null) {
            self::$module = $module;
        }
    }
    protected static function getModule() {
        if (!self::$module) {
            self::setModule(Yii::app() -> getModule(CallTrackerModule::giveLastInstanceId()));
        }
        return self::$module;
    }
}