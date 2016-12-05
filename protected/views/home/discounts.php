<!--<div class="main_content">
	<div class="in_main_content">
		<div class="in_main_content_left">

		</div>
		<?php $this -> renderPartial('//layouts/right_column', true,false); ?>
	</div>
</div>-->
<style>
	.article_left .article_content ul li{
		text-align:justify;
		margin-top:10px !important;
	}
	.article_left .article_content ul a{
		text-decoration:none;
	}
	.article_left .article_content ul a li{
		margin-top:5px !important;
		color:#008fd3 !important;
	}
	#table_ul{
		margin-right:20px;
		margin-top: 40px;

	}
	#table_ul li{
		border-top:1px solid #958f8a;
		padding:5px 10px;
	}
	#table_ul li span{
		display:block;
	}
	#table_ul li span:first-child{
		float:left;
	}
	#table_ul li span:nth-child(2){
		float:right;
	}
</style>
<div class="in_main_content">
	<div class="in_main_content_left article_left ">
		<div class="article_content">
			<img src="<?php echo Yii::app() -> baseUrl; ?>/images/discounts.png"/>

		</div>
	</div>
	<?php $this -> renderPartial('//layouts/right_column'); ?>
</div>