<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <!-- custom CSS -->
    <?php Yii::app()->bootstrap->register(); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/styles.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/clinics.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/jquery-ui.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/chosen.min.css'); ?>

    <?php Yii::app()->getClientScript()->registerCoreScript('jquery.ui'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/functions.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/chosen.jquery.min.js'); ?>

    <title><?php echo CHtml::encode(Yii::app()->name . ' - Админка'); ?></title>
</head> 

<body>

<div id="container" class="container-fluid">
        <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/logout_small.png', CHtml::encode('Выйти')), Yii::app()->baseUrl.'/admin/logout/', array('class' => 'pull-right')); ?>

    <div class="row-fluid">
        <?php if ($this->isSuperAdmin()): ?>
            <div class="span2">
                <div id="leftside-cols">
                    <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items'=>array(
                                array('label'=> CHtml::encode('Общие настройки'), 'url'=>array('admin/settings'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Пункты меню'), 'url'=>array('admin/MenuButtons'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Клиники'), 'url'=>array('admin/clinics'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Доктора'), 'url'=>array('admin/doctors'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Статьи'), 'url'=>array('admin/articles'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Триггеры'), 'url'=>array('admin/triggers'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Поля для клиник'), 'url'=>array('admin/clinicsFieldsGlobal'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Поля для докторов'), 'url'=>array('admin/doctorsFieldsGlobal'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Специализация'), 'url'=>array('admin/specialities'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Фильтры для сортировки (клиники)'), 'url'=>array('admin/clinicsFilters'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Фильтры для сортировки (доктора)'), 'url'=>array('admin/doctorsFilters'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Комментарии'), 'url'=>array('admin/comments'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Описания при поиске'), 'url'=>array('admin/Descriptions'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Баннеры'), 'url'=>array('admin/banners'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Пользователи'), 'url'=>array('admin/users'), 'itemOptions' => array('class' => 'page_item')),
                            ),
                        ));
                    ?>
                </div>
            </div>
        
            <div class="span10">   
                <?php echo $content;?>
				<?php CustomFlash::showFlashes(); ?>
            </div> <!-- span10 Left Pane -->
        <?php else: ?>
              <?php echo $content;?>      
			  <?php CustomFlash::showFlashes(); ?>
        <?php endif;?>  
		
    </div>

<?php Yii::app()->controller->renderPartial('//layouts/_footer'); ?>

</div> <!-- container -->

</body>
</html>
