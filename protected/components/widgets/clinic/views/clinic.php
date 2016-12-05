<div class="view">

    <div class="question-headline">
        <?php echo CHtml::link($data->question, Yii::app()->baseUrl.'/question/view/id/'.$data->q_id); ?>
    </div>
    <div>
        <?php echo CHtml::encode($data->detail); ?>
    </div>


    <div class="post-infoblock">
        <?php if ($data->profile_picture != ''): ?>

            <div style="float:left">
                <img border="1" style="padding-right: 8px ;max-width:50px;max-height:50px;" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture?>" alt="profile picture" />
            </div>
        <?php endif; ?>

        <div class='boxbyphoto'>
            <div class='question-nonboldaction'>
                <b>New answer</b>
                <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$data->create_at);?>
            </div>
            <div class='question-detail'>
                <?php echo $data->answer ?>...
            </div>
            <div class='question-nonboldaction'>
                <b><a target="_blank" href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$data->answerer?>"><?php echo $data->firstname. ' ' . $data->lastname?></a></b>, <?php echo $data->location?>
            </div>

        </div>
    </div>
    <div style="clear:both"></div>
</div>
<br />
