<?php
	$base = Yii::app() -> baseUrl;
	/**
	 * @type clinics $model
	 */
	Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/map.js');
	Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/widget_comments.css');
	Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/vk_lite.css');
	Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/vk_page.css');
	Yii::app()->getClientScript()->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
	Yii::app()->getClientScript()->registerScript("send_request","

		VK.Auth.getLoginStatus(function(data){
			var button = $('#show_input');
			if (data.session) {
				button.parent().remove();
				VK.Api.call('users.get', {user_ids:data.session.mid, fields:'domain, photo_50'}, function(userData){
					console.log(userData);
					if (userData.response.length) {
						var user = userData.response[0];
						$('#vk_avatar_round_small').attr('src',user.photo_50);
						var url = 'http://vk.com/';
						if (user.domain) {
							url += user.domain;
						} else {
							url += 'id' + user.uid;
						}
						$('#vk_avatar_link').attr('href',url);
						$('.wcomments_form').show();
						$('#VkIdHidden').val(user.uid);
						$('#post_field').keyup(function(){
							if ($(this).html().length > 0) {
								$('.placeholder').hide();
							} else {
								$('.placeholder').show();
							}
						});
						$('#send_post').click(function(){
							$('#ReviewTextHidden').val($('#post_field').html());
							$('#comment-form').submit();
						});
					} else {
						alert('Ошибка авторизации');
					}
				});
			} else {
				button.click(function(){
					var params = {
						client_id:5711487,
						redirect_uri:window.location.host + window.location.pathname,
						response_type:'token'
					};
					location.href = 'https://oauth.vk.com/authorize?'+$.param(params);
				});
			}
		});


	",CClientScript::POS_READY);

if ($model -> map_coordinates) {
	$coordinates = array_map('trim',explode(',',$model -> map_coordinates));
	Yii::app() -> getClientScript() -> registerScript('mapScript','
		addCoords('.json_encode(["coords" => $coordinates, "hint" => $model->name.", ".$model->address], JSON_NUMERIC_CHECK ).');
	',CClientScript::POS_READY);
} else {
	Yii::app() -> getClientScript() -> registerScript('mapScript','
		$("#map").html("Не найдено на карте. Возможно, указан неверный адрес.");
	',CClientScript::POS_READY);
}
?>
<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript">
	VK.init({
		apiId: 5711487
	});
	var logged;
	VK.Auth.getLoginStatus(function(data){
		console.log(data);
	});
</script>
<div id="content" class="clinic-page">
	<div class="bread"><a href="<?=$base.'/'?>">Полный каталог клиник</a><i class="fa fa-angle-right" aria-hidden="true"></i><span><?=$model->name?></span></div>
	<div class="clinic-h1"><div style="float:left"><img alt="" src="<?=$model->giveImageFolderRelativeUrl().$model->logo?>"></div><h1><?=$model->name?></h1></div>
	<div class="clear"></div>
	<div class="row">
		<div class="col-md-5">
			<div class="point-line"></div>
			<div class="center-mrtkt">
				<b>МРТ и КТ</b>
				<table><tbody>
					<tr><td>Модель МРТ: </td><td><a href="#"><?=$model->mrt?></a></td></tr>
					<tr><td>Модель КТ: </td><td><a href="#"><?=$model->kt?></a></td></tr>
				</tbody></table>
			</div>
			<div class="point-line"></div>
			<?php
			$tel = $model -> phone;
			$shortTel = preg_replace('/[^\d]/','',$tel);
			if (!$tel) {
				$tel = ' - ';
			}
			?>
			<?php if ($model -> partner): ?>
				<div class="center-phone"><a href="tel:8812<?php echo CallTrackerModule::getShortNumber(); ?>"><?php echo CallTrackerModule::getFormattedNumber(); ?></a></div>
			<?php else: ?>
				<div class="center-phone"><a href="tel:<?=$shortTel?>"><? CHtml::ajaxShowButton(Yii::app() -> baseUrl.'/site/viewClinicPhone','Показать телефон',$model -> id, $tel); ?></a></div>
				<?
			endif;
			$distr = CHtml::giveStringFromIdString('Districts', $model -> district, 'name');
			?>
			<div class="point-line"></div>
			<? $distr = CHtml::giveStringFromIdString('Districts', $model -> district, 'name'); ?>
			<div class="center-address"><?=$model->address?><br><a href="#"><?=$distr?> район</a></div>
			<div class="point-line"></div>
			<div class="center-hours"><?=$model->working_hours?></div>
			<div class="point-line"></div>
			<div class="center-stars">
				<p>Рейтинг по отзывам посетителей:</p>
				<?php
				$i = 0;
				while($i < 5){
					if ($i <= $model -> rating) {
						$color = "red";
					} else {
						$color = "grey";
					}
					echo "<div class='$color-star'></div>";
					$i++;
				}
				?>
				<a class="fancybox to_sign" href="#callback-registration">Записаться</a>
			</div>

		</div>
		<div class="col-md-7">
			<div id="map" style="min-height:250px;">
				<!--<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=fD_GXuTC_DICAhHVgiVGleFRK3TRwpR4&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;sourceType=constructor&amp;"></script>-->
			</div>
			<?php if (!$model -> partner) : ?>
				<div class="left-images-block">
					<h4>Нужна помощь в подборе клиники?</h4>
					<p>Вы можете обратиться в бесплатный консультативный колл-центр, где специалист-диагност:</p>
					<ul class="red-label">
						<li>Абсолютно бесплатно подберет Вам оптимально <b>подходящую клинику</b> и <b>наилучшую цену</b>, а также запишет Вас на обследование в удобное для Вас время.</li>
						<li>Ответит на все вопросы, связанные с МРТ и КТ диагностикой.</li>
					</ul>
					<p class="callcenter">Телефон колл-центра:  <a class="callcenter-phone" href="tel:8812<?php echo CallTrackerModule::getShortNumber(); ?>"><?php echo CallTrackerModule::getFormattedNumber(); ?></a></p>
				</div>
			<?php endif; ?>
		</div>

	</div>


	<div class="clear"></div>
	<div class="line"></div>

	<h2>Цены на некоторые исследования</h2>

	<div class="row prices">
		<div class="col-md-12">
			<?php
				$prices = $model -> prices;
				$extra_prices = array_splice($prices, 5);

			?>
			<table><tbody>
				<?php
					foreach ($prices as $pr) {
						echo "<tr><td>$pr->name</td><td>от $pr->price руб.</td></tr>";
					}
				?>
				</tbody></table>
			<?php if (count($extra_prices)) : ?>
			<table class="more_prices"><tbody>
				<?php
					foreach ($extra_prices as $pr) {
						echo "<tr><td>$pr->name</td><td>от $pr->price руб.</td></tr>";
					}
				?>
				</tbody></table>
			<a class="all-prices">Показать <span>весь прайс</span></a>
			<div class="clear"></div>
			<?php endif; ?>
		</div>
	</div>
	<div class="line"></div>

	<h2>Врачи клиники</h2>

	<div class="row doctors">
		<?php
			foreach ($model->doctors as $doctor) {
				$this -> renderPartial('//doctors/_for_clinic',['model' => $doctor]);
			}
		?>
	</div>
	<div class="line"></div>

	<h2>Отзывы посетителей</h2>

	<div class="reviews">
		<div class="wcomments_page _wcomments_page wcomments_section_posts">
			<div class="wcomments_head _wcomments_head clear_fix">
				<a class="wcomments_logo" href="/dev/Comments"></a>
				<span class="wcomments_count _wcomments_count">
					<?php
						$toShow = $model -> approved_comments;
						$total = count($toShow);
						$word = 'комментари';
						$num = $total%10;
						if (($num == 0)||($num >= 5)||(($num >= 10)&&($num <= 20))) {
							$word .= 'ев';
						} elseif ($num == 1) {
							$word .= 'й';
						} elseif (($num >= 2) && ($num <= 4)) {
							$word .= 'я';
						}
						echo $total.' '.$word;
					?> </span>
			</div>

			<div class="_wcomments_content wcomments_content">
				<div class="_wcomments_form clear_fix">
					<div class="wcomments_form" style="display:none">
						<div id="submit_post_error" class="box_error wcomments_post_error"></div>
						<a href="http://vk.com" id="vk_avatar_link" class="wcomments_form_avatar"><img id="vk_avatar_round_small" src="http://vk.com/images/camera_50.png"></a>
						<div id="submit_post_box" class="wcomments_post_box shown clear_fix">
							<div class="_emoji_field_wrap">
								<div id="post_field" class="wcomments_post_field dark submit_post_inited" contenteditable="true"></div>
								<div class="placeholder"><div class="ph_input"><div class="ph_content">Ваш комментарий...</div></div></div></div>
							<div id="submit_post" class="wcomments_submit_post clear_fix">
								<div id="media_preview" class="clear_fix media_preview"></div>
								<div class="addpost_button_wrap" id="reply_box_main">
									<button class="flat_button addpost_button" id="send_post">Отправить</button>
								</div>

							</div>
						</div>
					</div>
					<div class="wcomments_form" style="text-align:center">
						<button class="flat_button" id="show_input">Оставить свой отзыв</button>
					</div>
				</div>
				<?php CustomFlash::showFlashes(); ?>
				<div class="_wcomments_posts_outer wcomments_posts_outer no_post_click wall_module wide_wall_module">
					<div class="wcomments_posts_inner">
						<div id="wcomments_posts" class="wcomments_posts">

							<?php
							if (!empty($toShow)) {
								foreach($toShow as $rev){
									$this -> renderPartial('//vk/_single_review',['model' => $rev]);
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	</div>

	<div class="line"></div>
<?php
$form=$this->beginWidget('CActiveForm', array(
		'id'=>'comment-form',
		'action'=> Yii::app()->baseUrl.'/clinics/comment',
));
/**
 * @type CActiveForm $form
 */
$comment = new Comments();
$comment -> user_first_name = 'vk';
echo $form -> hiddenField($comment, 'user_first_name');
echo $form -> hiddenField($comment, 'text', ['id' => 'ReviewTextHidden']);
echo $form -> hiddenField($comment, 'vk_id', ['id' => 'VkIdHidden']);
echo CHtml::hiddenField('object_id', $model -> id);


$this->endWidget();

?>