<?php
/**
 * @type integer $page
 * @type CActiveRecord $model
 */
$pageSize = 5;
if ($model) {
    $reviews = $model->approved_comments;
} else {
    $reviews = Comments::model() -> findAllByAttributes(['approved' => 1],['order' => 'num DESC']);
}

$showButton = $page < (ceil(count($reviews) / $pageSize) - 1);
$reviews = array_slice($reviews, $pageSize * $page, $pageSize);
if (empty($reviews)) {
    //Чтобы убрать ненужную кнопку.
    echo "<span> </span>";
    return;
}
foreach($reviews as $rev){
    $this -> renderPartial('//vk/_single_review',['model' => $rev]);
}
if ($showButton) {
    echo "<div id='showMoreReviews'>Показать еще</div>";
}
