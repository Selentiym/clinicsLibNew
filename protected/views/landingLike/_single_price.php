<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 17:26
 */
/**
 * @type Price $price
 * @type integer $num
 */
$basePrice = $price -> price;
$oldCoeff = 1.3;

if (!$coeff) { $coeff = 1; }
?>

<tr data-form-func="pricePopup" data-price="<?php echo $price -> text; ?>" class="single_price <?php if ($price -> getHighlight()){echo "active-price";} ?> <?php if ($num == 1) { echo "padding-top"; } ?>">
    <td class="price-name"><span class="formable"><?php echo $price->text; ?></span></td>
    <td class="price-new"><span class="formable"><?php echo round($basePrice * $coeff / 1) * 1; ?>р.</span></td>
    <td class="price-old formable"><?php echo round($basePrice * $coeff * $oldCoeff / 1) * 1; ?>р.</td>
</tr>
