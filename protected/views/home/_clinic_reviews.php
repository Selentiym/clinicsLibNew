<div id="review_list">
	<h2>Отзывы о клинике</h2>
	<?php
		if (!empty($reviews)) {
			foreach($reviews as $review){
				$this -> renderPartial('//home/_single_review', array('review' => $review));
				/*echo $review ->user_first_name;
				echo "<br/>";
				echo $review ->create_at;
				echo "<br/>";
				echo $review ->text;
				echo "<br/>";*/
			}
		} else {
			echo "Ни одного отзыва не найдено.";
		}
	?>
</div>
<div id="add_review">
	<h2>Добавить новый отзыв</h2>
	<?php 
		$form=$this->beginWidget('CActiveForm', array(
				'id'=>'comment-form-' . $object_id,
				'action'=> Yii::app()->baseUrl.'/clinics/comment',
		));
	?>
	<div class="hiddens">
	<?php
		echo CHtml::hiddenField('object_id', $id);
		//echo CHtml::hiddenField('verbiage', $model -> verbiage);
		$comment = new Comments();
	?>
	</div>
	<div id="textarea_cont">
		<div class="note">Напишите свой отзыв о клинике</div>
		<?php echo $form->textArea($comment,'text',array('id' => 'textarea_input','placeholder' => 'Ваш отзыв')); ?>
		
	</div>
	<div id="first_name_input_cont">
		<?php echo $form->textField($comment,'user_first_name',array('id' => 'name_input','placeholder' => 'Ваше имя')); ?>
	</div>
	<?php echo CHtml::htmlButton(CHtml::encode('Добавить отзыв'), array('class'=>'search_submit', 'id'=>'review_submit', 'type'=>'submit')); ?>
	
<?php $this->endWidget(); ?>
</div>