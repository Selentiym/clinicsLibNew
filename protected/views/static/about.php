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
</style>
<div class="in_main_content">
	<div class="in_main_content_left article_left ">
		<div class="article_content">
			<p>Здравствуйте!</p>
			<ul id="about_ul" style="text-align:justify">
			<li>Рады видеть Вас на страницах нашего сайта. Мы стараемся создать полезный и интересный информационный ресурс по всем основным медицинским вопросам, с которыми может столкнуться человек.</li>
			<li><ol>
				<li>На нашем сайте Вы можете найти информацию о различных патологиях, методах диагностики, вариациях лечения и много другой полезной информации – раздел БИБЛИОТЕКА</li>
				<li>Также при желании на страницах нашего сайта Вы можете подобрать для себя Врача, Клинику или Диагностический центр, определиться с ценами на необходимые виды услуг, узнать контактные данные, получить информацию о Скидках и Акциях, изучить отзывы лечащих врачей и пациентов – разделы:
				<ul style="margin-top:10px;">
					<a href="<?php echo Yii::app() -> baseUrl; ?>/clinics/"><li>Диагностика МРТ, КТ, УЗИ и другие виды</li></a>
					<a href="#"><li>Клиники</li></a>
					<a href="#"><li>Врачи</li></a>
				</ul>
				</li>
				<li>Получить консультацию специалиста по вопросам МРТ и КТ диагностики:
                    <a href="#" class="order_button" onclick="$('#exampleModal1').arcticmodal()">Заказать звонок</a>
				</li>
			</ol></li>
			</ul>
		</div>
	</div>
	<?php $this -> renderPartial('//layouts/right_column'); ?>
</div>