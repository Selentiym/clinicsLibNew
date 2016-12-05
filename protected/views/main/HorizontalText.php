<?php
	/**
	 * view - array of:
	 * @var string text - the text to be displayed
	 * @var string url - href of the text
	 * @var string image_url - address of the image
	 */
?>
<div class="popular_blog_item">
	<a class="popular_blog_img" href="<?php echo $view['url']; ?>" target="_blank"><img src="<?php echo $view['image_url']; ?>" alt="<?php echo strip_tags($view['text']);  ?>"></a>
	<a class="popular_blog_name" href="<?php echo $view['url']; ?>" target="_blank"><?php echo $view['text']; ?></a>
</div>