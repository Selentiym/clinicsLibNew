<?php
/* @var $this ClinicsController */
/* @var $model clinics */

$this->breadcrumbs=array(
	'clinics'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List clinics', 'url'=>array('index')),
	array('label'=>'Manage clinics', 'url'=>array('admin')),
);
?>

<h1>Create clinics</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>