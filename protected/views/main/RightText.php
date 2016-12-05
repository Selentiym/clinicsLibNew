<?php
	/**
	 * view - array of:
	 * @var string text - the text to be displayed
	 * @var string url - href of the text
	 * @var string image_url - address of the image
	 */
?>
<li class="icon_link_item">
	<a href="<?php echo $view['url']; ?>">
	<table>
	<tr>
		<td><img src="<?php echo $view['image_url']; ?>" alt="<?php echo strip_tags($view['text']); ?>"></td>
		<td><span><?php echo $view['text']; ?></span></td>
	</tr>
	</table>
	</a>
</li>