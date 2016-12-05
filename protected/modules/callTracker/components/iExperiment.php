<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.11.2016
 * Time: 18:15
 */
interface iExperiment {
    /**
     * @return mixed[] - realizations of the experiment
     */
    public function getParams();

    /**
     * @param string @property - property to be gained
     * @return mixed
     */
    public function getProperty($property);
}