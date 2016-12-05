<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.12.2016
 * Time: 20:04
 */
//Загружаем composer, там лежит определитель устройства юзера
require_once( dirname(__FILE__) . '/../../vendor/autoload.php');
use UserAgentParser\Exception\NoResultFoundException;
use UserAgentParser\Provider\Http\UserAgentStringCom;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
class browserInfoHolder {
    /**
     * @var \UserAgentParser\Model\UserAgent $result
     */
    private static $result;
    private static $canGive = false;
    private function __construct() {
        self::$canGive = true;
    }

    /**
     * @return null|\UserAgentParser\Model\UserAgent
     */
    public static function getInstance() {
        if (!((self::$result)&&(self::$canGive))) {
            self::$result = new Mobile_Detect();
            self::$canGive = true;
            /*$client = new Client([
                'handler' => HandlerStack::create(new CurlHandler()),
            ]);

            $provider = new UserAgentStringCom($client);

            try {
                $result = $provider->parse($_SERVER['HTTP_USER_AGENT']);
                self::$canGive = true;
                self::$result = $result;
            } catch (NoResultFoundException $ex) {
                // nothing found
                return null;
            }*/
        }
        return self::$result;
    }
}