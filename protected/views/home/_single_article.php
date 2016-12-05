<div class="thumbnail">
    <div class="row-fluid view single">
            <h1>
               <?php echo $data->name; ?>
            </h1>
            <br/><br/>
            <div>
                <?php echo substr ($data->text, 0, 300) . '...'; ?>
            </div>
            <br/>
            <p class="pull-right">
                <?php echo CHtml::link('Подробнее...' , Yii::app()->controller->createUrl('/article/' . $data->verbiage), array('class' => 'btn btn-info')); ?>
            </p>
    </div>
</div>