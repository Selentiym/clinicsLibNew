<?php
/**
 * SiteSearch represents functionality for extended Site Search by parameters
 *
 * @version 0.1
 * @author Alina Vasilevich
 * @link http://con.cept.me
 */

class SiteSearch extends CWidget {
    
    public $filterForm;
    public $fromPage;
	public $modelName;
    
    public function run()
    {   
        
        
        /* get a set of filter values */
        /* 1 - metro stations */
        $metro_obj = Metro::model()->findAll(array('order' => 'name ASC'));
        $metro = CHtml::listData($metro_obj, 'id', 'name');

        /* 2 - districts */
        $districts_obj = Districts::model()->findAll(array('order' => 'name ASC'));
        $district = CHtml::listData($districts_obj, 'id', 'name');

        //$magnet_field, $magnet_type, $kids, $slice_number, $weight, $round_the_clock;
        /* All necessary triggers */
        /* TODO: organize a loop to iterate all necessary filters from options table */
        /*
        $triggers_obj = Triggers::model()->with('trigger_values')->findAll();
        $triggers = array();
        foreach ($triggers_obj as $trigger) {
            $triggers[$trigger->verbiage] = $trigger->trigger_values;
        }
        */
      
        $this->render('siteSearch', array('specialitiesCloud' => Filters::model() -> giveSpecialities(), 'district' => $district, 'metro' => $metro, 'filterForm' => $this->filterForm, 'modelName' => $this -> modelName, 'fromPage' => $this -> fromPage));
                                    
        
    }
}