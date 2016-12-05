<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.11.2016
 * Time: 17:46
 */
/**
 * @type doctors $model
 */
$doctor = $model;
?>
<div class="col-md-6">
    <div class="doctor">
        <?php
            $url = $doctor -> giveImageFolderRelativeUrl() . $doctor -> logo;
        //echo $url;
            if ((file_exists($doctor -> giveImageFolderAbsoluteUrl() . $doctor -> logo)&&($doctor -> logo))) :
            //if (true) :
        ?>
       <div class="doctor-img"><img alt="<?php echo $doctor -> verbiage; ?>" src="<?php echo $url;?>"></div>
        <?php endif; ?>
        <h4><?php echo $doctor -> name; ?></h4>
        <p><?php echo $doctor -> description; ?></p>
    </div>
</div>
