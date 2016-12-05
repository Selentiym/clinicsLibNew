<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.11.2016
 * Time: 16:53
 */
interface iApiCall {
    /**
     * @param mixed[] $data
     * @return iApiCall
     */
    public function setData($data);

    /**
     * @return aEnter|null
     */
    public function lookForEnter();

    /**
     * @param aEnter $enter
     */
    public function linkEnter(aEnter $enter);

    /**
     * @return bool
     */
    public function saveChanges();
}