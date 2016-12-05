<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.11.2016
 * Time: 18:37
 */
abstract class aGDCall extends CActiveRecord {
    private $_factory;
    /**
     * @var mixed[] - data from the entry. For internal use only
     */
    protected $_data;
    /**
     * Stores information about the GD line
     * @var string $external_id
     */
    public $external_id;
    /**
     * @param \Google\Spreadsheet\ListEntry $entry
     * @param aGDCallFactory $factory
     */
    public function initialize(Google\Spreadsheet\ListEntry $entry, $factory) {
        $this -> _data = $entry -> getValues();
        $xml = $entry -> getXml();
        //Потом по этой штуке мы сможем обращаться к строке гугл дока
        $this -> external_id = $xml -> id;
        //Чтобы потом искать похожие
        $this -> _factory = $factory;
    }

    /**
     * @return aGDCallFactory
     */
    public function getFactory() {
        return $this -> _factory;
    }

    /**
     * @return mixed - array of the fields
     */
    //abstract public function getFields();

    /**
     * @return string status
     * Returns the current status of the call.
     * Checks googleDoc if not set.
     */
    abstract public function getStatus();

    /**
     * @param aGDCall $gdCall
     * @return bool whether this entry corresponds to this object
     */
    abstract public function compareWith(aGDCall $gdCall);

    /**
     * @return string the number
     */
    abstract public function getNumber();

    /**
     * @return integer
     */
    abstract public function getCallTime();
}