<div class="thumbnail">
    <div class="row-fluid view single">
    <!-- Left side pane-->
        <div class="span9">
    
            <div class="span2">
                <?php if (trim($data->logo) !=''): ?>
                    <img border="1" align="ABSMIDDLE" src="<?php echo $data -> giveImageFolderRelativeUrl() . $data -> logo;/*Yii::app()->baseUrl.'/images/doctors/' . $data->id . '/' .$data->logo*/ ?>" alt="<?php echo CHtml::encode($data->name);?>">
                <?php endif; ?>
            </div>
            <div class="span10">
                <div class="rating">
                    <span class="pull-left"> <?php echo CHtml::encode('Рейтинг: ') . $data->rating; ?> </span>
                    <br/><br/>
                    <div class="rateit" data-rateit-value="<?php echo $data->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                </div>
    
                <br/>
                    <p> <?php echo CHtml::link(CHtml::encode($data->name), Yii::app()->baseUrl.'/doctors/'.$data->verbiage, array('class' => 'Title')); ?> </p>
                        <?php if ($data->address): ?> <p> <?php echo '<b>' .CHtml::encode('Адрес: ') . '&nbsp;&nbsp;</b>' . CHtml::encode($data->address); ?> </p> <?php endif; ?>
                        <?php if ($data->phone): ?> <p> <?php echo '<b>' .CHtml::encode('Телефон:') . '&nbsp;&nbsp;</b>' . CHtml::encode($data->phone); ?> </p> <?php endif; ?>
                        <?php if ($data->fax): ?> <p> <?php echo '<b>' .CHtml::encode('Факс: ') . '&nbsp;&nbsp;</b>' . CHtml::encode($data->fax); ?> </p> <?php endif; ?>
                        <?php if ($data->districts_display): ?> <p> <?php echo '<b>' .CHtml::encode('Район: ') . '&nbsp;&nbsp;</b>' . CHtml::encode($data->districts_display); ?> </p> <?php endif; ?>
                        <?php if ($data->metros_display): ?> <p> <?php echo '<b>' .CHtml::encode('Метро: ') . '&nbsp;&nbsp;</b>' . CHtml::encode($data->metros_display); ?> </p> <?php endif; ?>
    
                <?php if ($data->services): ?>
                    <p>
                        <?php echo '<b>' . CHtml::encode('Услуги: ') . '&nbsp;&nbsp;</b>'; ?>
                        <?php
                            $services = '';
                            if (!empty($data->services)) {
                                foreach ($data->services as $service)
                                    $services .= $service->name . (!empty($service->price_from)? ' (от ' . $service->price_from . ')' :'') . ', ';
                            }
                            echo substr($services, 0, strrpos($services, ','));;
                        ?>
                    </p>
                <?php endif; ?>
                
                <?php if ($data->working_days): ?>
                    <p> <?php echo '<b>' . CHtml::encode('Часы работы: ') . '&nbsp;&nbsp;</b>' . CHtml::encode($data->working_days). (($data->working_hours)? ', ' . CHtml::encode($data->working_hours): ''); ?> </p>
                <?php endif;?>
                
                <p class="pull-right">
                    <?php echo CHtml::link('Подробнее...' , Yii::app()->baseUrl.'/doctors/'.$data->verbiage, array('class' => 'btn btn-info')); ?>
                </p>
            </div>
    
        </div>
        <!-- End Left side pane-->
    
        <!-- Right side pane-->
        
		<?php if (!empty($data->triggers_display)) { 
			echo '<div class="span3 well">';
			foreach($data->triggers_display as $trigger) {
				echo '<p>';
				if (trim($trigger->trigger->logo) !=''){
					echo '<img border="1" align="ABSMIDDLE" src="' . $trigger -> trigger -> giveImageFolderRelativeUrl() . $trigger -> trigger -> logo /*Yii::app()->baseUrl.'/images/triggers/' . $trigger->trigger->id . '/' . $trigger->trigger->logo*/ .'" style="max-width: 20%; max-height: 20%; padding-right: 5%;">';
				}
	
				echo CHtml::encode($trigger->value) . '</p>';
			}
			echo '</div>';
		} ?>
    </div>
</div>