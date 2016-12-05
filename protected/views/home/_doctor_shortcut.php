<div class="info_about_doctor">
	<img src="<?php echo $doctor -> giveImageFolderRelativeUrl() . $doctor -> logo;?>" alt="<?php echo $doctor -> verbiage; ?>">
	<h4><?php echo $doctor -> name; ?></h4>
	<p>
		<?php echo $doctor -> rewards; ?>
	</p>
	<p>
		<?php echo $doctor -> short; ?>
	</p>
</div>