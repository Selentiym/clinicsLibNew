<?php
	Yii::app() -> getClientScript() -> registerScript("sendData",'
		$("#client_form").submit(function(event) {
			var ser = $(this).serialize();
			event.preventDefault();
			$.ajax({
				url: "'.Yii::app() -> baseUrl.'/regCall",
				method: "post",
				data: {
					"serialized":ser
				}
			}).done(function(data) {
				if (data == "ok") {
					//location.href = "/";
					history.go(-1);
				} else {
					alert("Ошибка при отправке данных, попробуйте еще раз.");
					//alert(data);
				}
			});
		});
	',CClientScript::POS_READY);
?>
<div id="form-container">
	<form name="become_partner" method="post" id="client_form">
		<div id="left-column">
			<div class="block">
				<div class="heading">Стать партнером</div>
				<div class="elements">
					<div class="label">ФИО</div>
					<input type="text" name="fio" class="black_text">
					<div class="label">ПОЧТА</div>
					<input type="text" name="email" class="black_text">
				</div>
			</div>
			<div class="block">
				<div class="heading"></div>
				<div class="elements">
					<div class="label">Специализация</div>
					<input type="text" name="spec" class="black_text">
					<div class="label">Места работы <span class="label_comment">(поликлиника1, поликлиника2)</span></div>
					<input type="text" name="addr" class="black_text">
					<div class="label">Телефон</div>
					<input type="text" name="tel" class="black_text">
					<div class="label">Номер карты</div>
					<input type="text" name="card" class="black_text">
					<div class="checkbox">
						<input type="checkbox" name="permanent_clients" value="1"><span>Я имею постоянных клиентов</span>
					</div>
				</div>
			</div>
		</div>
		<div id="right-column">
			<div id="form_image_container">
				<div id="form_doctor_image"></div>
			</div>
			<div class="block">
				<div class="heading"></div>
				<div class="elements">
					<div id="count_cont">
						<div class="label">Количество пациентов</div>
						<input type="text" name="count" class="white text"><div class="big_comment_image"></div><div class="big_comment">Ориентировочное количество пациентов, нуждающихся в платном исследовании МРТ/КТ</div>
						
					</div>
					<div class="label">Сообщение</div>
					<textarea rows="6" name="mess" class="textarea black text"></textarea>
					<div class="submit">
						<input type="submit" value="ОТПРАВИТЬ">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>