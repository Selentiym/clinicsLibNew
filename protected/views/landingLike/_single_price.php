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

<tr <?php if ($num == 1) { echo 'class="padding-top"'; } ?>>
    <td class="price-name"><span><?php echo $price->text; ?></span></td>
    <td class="price-new"><?php echo round($basePrice * $coeff / 100) * 100; ?>р.</td>
    <td class="price-old"><?php echo round($basePrice * $coeff * $oldCoeff / 100) * 100; ?>р.</td>
</tr>
