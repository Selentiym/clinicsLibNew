<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.11.2016
 * Time: 19:04
 */
abstract class aGDCallFactory {
    private static $_api;
    private static $_mainFact;

    /**
     * @var GoogleDocApiHelper $api
     */
    public $api;

    /**
     * @param string $link
     * @return aGDCall
     */
    abstract public function buildByLink($link);

    /**
     * @param aGDCall $gdCall
     * @return aGDCall
     */
    abstract public function buildByRecord(aGDCall $gdCall);

    /**
     * Searches the google doc file in order to find rows with
     * corresponding data
     * @param mixed $info
     * @return aGDCall
     */
    abstract public function buildByInfo($info);
    /**
     * @param Google\Spreadsheet\ListEntry $entry
     * @return aGDCall
     */
    abstract public function buildByEntry($entry);
    /**
     * @param GoogleDocApiHelper $api
     */
    public function __construct($api = null) {
        if (!is_a($api, 'GoogleDocApiRecord')) {
            $this -> api = self::$_api;
        } else {
            $this -> api = $api;
        }
    }

    /**
     * @param GoogleDocApiHelper $api
     */
    public static function setApi($api) {
        self::$_api = $api;
    }

    public static function getFactory($info = []){
        if (!self::$_mainFact) {
            self::$_mainFact = new SimpleGDFactory(self::$_api);
        }
        return self::$_mainFact;
    }
}