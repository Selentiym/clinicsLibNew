<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 16:41
 */
/**
 * @type PriceBlock $block
 */
$count = 0;
$blockName = preg_replace('/([а-я]+)/ui','<b>$1</b>',$block -> name, 1, $count);
if ($count == 0) {
    $blockName = "<b>$blockName</b>";
}
?>

<tr>
    <th colspan="3"><?php echo $blockName; ?></th>
</tr>
<?php
    $experiment = Yii::app() -> getModule('tracker') -> enter -> getExperiment();
    /**
     * @type iExperiment $experiment
     */
    $coeff = $experiment -> getProperty('price');
    $num = 0;
    foreach ($block -> prices as $price) {
        $num++;
        $this -> renderPartial('//landingLike/_single_price',['price' => $price, 'num' => $num, 'coeff' => $coeff]);
    }
?>
