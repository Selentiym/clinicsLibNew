<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.11.2016
 * Time: 21:11
 */
class NumberTest extends DbTestCase {
    public $fixtures=array(
        'numbers'=>'phNumber',
    );
    public function testSum(){
        //123
        //$number = current($this -> fixtures['numbers']);
        $this -> assertEquals(8, phNumber::sum(3,5));
    }
}