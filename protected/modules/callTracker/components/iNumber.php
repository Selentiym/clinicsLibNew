<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.2016
 * Time: 22:50
 */
interface iNumber {

    /**
     * @return string - the number itself
     */
    public function getNumberString();

    /**
     * @return string - short and unformatted number.
     */
    public function getShortNumberString();
    /**
     * @param CDbCriteria|NULL $criteria
     * @return aEnter last user entry
     */
    public function lastEnter(CDbCriteria $criteria = NULL);
    /**
     * @return static[]
     */
    public static function getReserved();
    /**
     * @param static[] $numbers
     * @return static|null
     */
    public static function selectLongest(array $numbers);
    /**
     * @return aNumber[] номера, на которые записаны в настоящий момент меньше всего человек.
     * Визит считается завершенным, если called = 1 или active = 0
     */
    public static function freestNumbers();
}