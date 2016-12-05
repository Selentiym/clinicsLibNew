<?php
/*
 * Clinic widget represents compact description for every single clinic
 *
 * @version 0.1
 * @author Alina Vasilevich
 */

class Clinic extends CWidget {

    public $id;

    public function run()
    {
        $model = new clinics($id);
        $this->render('//home/_single_clinic', array('data'=>$model));
    }
}