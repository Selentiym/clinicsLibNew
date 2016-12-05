<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.11.2016
 * Time: 11:55
 */
/**
 * @type
 */
$obj = current(VkAccount::showRandom());
var_dump($obj);
$criteria = new CDbCriteria();
$criteria -> addCondition('vk_id IS NULL');
$review = Comments::model() -> find($criteria);
echo $review -> text;
?>
<form method="post">
    <?php if ($review) : ?>
    <input type="submit" name="addAccount" value="Ок"/>
    <input type="submit" value="Нет"/>
    <?php endif; ?>
    <input type="hidden" name="VkAccount[vk_id]" value="<?=$obj->id?>"/>
    <input type="hidden" name="VkAccount[first_name]" value="<?=$obj->first_name?>"/>
    <input type="hidden" name="VkAccount[last_name]" value="<?=$obj->last_name?>"/>
    <input type="hidden" name="VkAccount[photo]" value="<?=$obj->photo_50?>"/>
    <input type="hidden" name="VkAccount[domain]" value="<?=$obj->domain?>"/>
    <input type="hidden" name="reviewId" value="<?=$review->id?>"/>
</form>
<?php
    if ($obj -> domain) {
        $url = "https://vk.com/".$obj -> domain;
    } else {
        $url = "https://vk.com/id".$obj -> id;
    }
    echo Html::link($obj -> first_name.' '.$obj -> last_name, $url);
?>
