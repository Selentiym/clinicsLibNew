<?php
/* @var $this ClinicsController */
/* @var $model clinics */

$this->breadcrumbs=array(
	'clinics'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List clinics', 'url'=>array('index')),
	array('label'=>'Create clinics', 'url'=>array('create')),
	array('label'=>'View clinics', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage clinics', 'url'=>array('admin')),
);
?>

<h1>Update clinics <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>