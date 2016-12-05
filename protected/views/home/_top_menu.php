<?php
    /*
    $top_menu = Options::model()->findByAttributes(array('name' => 'top_menu'));
    $menu_items = array_map('trim', explode(';', $top_menu->value));
    $menu = array();
    foreach($menu_items as $item) {
        $item = array_map('trim', explode('=', $item));
        $menu[] = array('label'=>$item[0], 'url'=>array(Yii::app()->baseUrl . '/article/' . $item[1]));
    }
    */
    //$top_menu = Articles::model()->findAllByAttributes(array('category' => ''));
	
?>

<?php
    $this->widget('bootstrap.widgets.TbNavbar', array(
            //'brand'=> CHtml::encode('Главная'),
            'brand'=> CHtml::encode('Главная'),
            //'brandUrl'=> '/',//Yii::app()->baseUrl,
            'fixed' => 'no',
            'items'=>array(
                array(
                    'class'=> 'bootstrap.widgets.TbMenu',
                    'htmlOptions'=>array('class'=>'pull-left'),
                    'items'=>MenuButtons::model() -> giveMenu()
                ),

            ),
        )
    );
?>