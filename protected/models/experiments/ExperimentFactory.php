<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.11.2016
 * Time: 18:38
 */

/**
 * Class ExperimentFactory
 * Заготовка для в дальнейшем абстрактной фабрики, но пока что просто фабрика GlobalExperiment
 */
class ExperimentFactory {

    private static $_instance;

    private function __construct(){}

    /**
     * @return self
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * @param aEnter|null $enter
     * @return iExperiment
     */
    public function build(aEnter $enter = null) {
        $exp = null;
        if (is_a($enter, 'aEnter')) {
            $exp = $enter -> getRelated("experiment", true);
        }
        if (!is_a($exp, 'iExperiment')) {
            $exp = new GlobalExperiment();
        }
        $exp -> initialize($enter);
        $exp -> save();
        return $exp;
    }
}