<?php
/**
 *
 * @var HomeController $this
 */
echo "check home";
echo '<br/>'.http_build_query([
    "CallID" =>"1479144949.4665265",
    "CallerIDNum"=>"+79523660187",
    "CallerIDName"=>"79523660187",
    "CalledDID"=>"78126271521",
    "CalledExtension"=>"13298*001",
    "CallStatus"=>"CALLING",
    "CallFlow"=>"in",
    "CallerExtension"=>"",
    "CallAPIID"=>"ystbaxji6g4vnts3wted",
    "nonumber"=>1
]);
var_dump(Yii::app() -> getModule('tracker') -> enter);