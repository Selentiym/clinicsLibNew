<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.12.2016
 * Time: 20:09
 */
/**
 * @type googleDocEnter[] $data
 */
$statuses = [];
foreach ($data as $enter) {
    $statuses[$enter -> getCachedStatus()] ++;
}
$named = [];
foreach($statuses as $key => $count){
    $named[callStatusHelper::getClassName($key)] = $count;
}
var_dump($named);
?>