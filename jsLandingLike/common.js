var $regForm;
function getForm() {
	if (!$regForm) {
		$regForm = $("#callback-registration");
	}
	return $regForm;
}
function customPopup(text){
	var form = getForm();
	if (!text) {
		popup();
	} else {
		var variab = form.find('.variable');
		variab.html(text);
		popup(form);
	}
}
var priceFromAttrName = 'data-price';
function pricePopup($el) {
	var price = $el.closest("["+priceFromAttrName+"]").attr(priceFromAttrName);
	if (price) {
		var cont = $("<span>");
		cont.append($("<p>").append("Специалист-диагност поможет Вам выбрать исследование '" + price + "' в удобном для Вас месте по оптимальной цене."));
		cont.append($("<p>").append("Наш специалист перезвонит Вам в течение 5 минут!"));
		cont.append($("<p>").append("Консультация абсолютно бесплатна, ответим на любые вопросы по МРТ/КТ тематике."));
		customPopup(cont);
	} else {
		textPopup($el);
	}
}
var defaultFormText = $("<span>").append($("<p>").append("Вам перезвонят в течение 5 минут!"))
		.append($("<p>").append("Специалист-диагност подберет Вам подходящую клинику и наилучшую цену, а также запишет на обследование в удобное для Вас время."))
		.append($("<p>").append("Ответит на все вопросы, связанные с МРТ и КТ диагностикой."));
var formTextAttrName = 'data-form-text';
function textPopup($el){
	var textHolder = $el.closest("["+formTextAttrName+"]");
	var text = textHolder.attr(formTextAttrName);
	if (!text) {
		text = defaultFormText;
	} else {
		text = $("<p>").append(text);
	}
	customPopup(text);
}
function consultTextPopup($el) {
	customPopup("<p>При прохождении обследования в ряде клиник, Вы можете получить консультацию врача бесплатно.</p><p>Специалист назначит соответсвующее лечение.</p><p>После заполнения формы Вам в течение 5 минут позвонит наш оператор-консультант, который способен ответить на любые Ваши вопросы.</p>");
}
function nightTextPopup($el) {
	customPopup("<p>Ночью наши цены становятся еще ниже.</p><p>Чтобы не стоять днем в пробках и не брать драгоценный отгул на работе, Вы можете записаться на ночное обследование. Приятным бонусом будет скидка до 50% при ночной процедуре.</p><p>Наш оператор позвонит Вам в течение 5 минут и ответит на все Ваши вопросы.</p>");
}
var funcAttrName = 'data-form-func';
$(document).on("click", ".formable", function(e){
	var $el = $(e.target);
	var definer = $el.closest("["+funcAttrName+"]");
	var func = definer.attr(funcAttrName);
	if (!$el.length) {
		console.log('no element found!');
		return;
	}
	if (typeof window[func] == 'function') {
		window[func]($el);
	} else {
		textPopup($el);
	}
	return false;
});
/*$(document).on("click","a[href='#callback-registration']", function(e){

});*/
$(document).ready(function(){
	//Попап менеджер FancyBox
	//Документация: http://fancybox.net/howto
	//$(".fancybox").fancybox();

	//doctors slider
	var owl2 = $(".carousel-doctors");
	owl2.owlCarousel({
		items : 2,
		autoHeight : false,
		stopOnHover : true,
		touchDrag : false,
		autoPlay : true
	});
	owl2.on("mousewheel", ".owl-wrapper", function (e) {
		if (e.deltaY > 0) {
			owl2.trigger("owl.prev");
		} else {
			owl2.trigger("owl.next");
		}
		e.preventDefault();
	});
	$(".next_button").click(function() {
		owl2.trigger("owl.next");
	});
	$(".prev_button").click(function() {
		owl2.trigger("owl.prev");
	});

	//end of slider
// Открыть/закрыть верхнее меню в моб.версии

	$(".main_mnu_button").click(function() {
		$(".main_menu ul").slideToggle();
	});


// Смена значения радиокнопки "Показать на карте" "Показать списком"

				var mainmap = $('#main-map');
				var maintext = $('#main-text');
				$('input[type=radio][name=view]').change(function() {
					if (this.value == 'list') {
						mainmap.css({
						'width' : '30%',
						'height' :  '250px'
						});
						maintext.css('width','70%');
					}
					else if (this.value == 'map') {
						mainmap.css({
						'width' : '100%',
						'height' :  '400px'
						});
						maintext.css('width','100%');
					}
				});
	
// Перерисовка верхнего меню при прокрутке страницы 		
	var $assignBottom = $("#assignBottom");
	var $assignBottomAnchor = $("#bottomAssignAnchor");
	var assignWidth = $assignBottom.width();
        $(window).scroll(function(){
			var fullScreen = $(window).width() >= '1200';
            if (( $(this).scrollTop() > 250 ) && $(window).width() >= '1200' ){
				$("header.header_topline").css({
					"position" : "fixed",
					"width" : "100%"
				});
								  
           } else if(($(this).scrollTop() <= 250)  && $(window).width() >= '1200') {
				$(".menu-desc").css('display','block');
				$(".menu-desc").css('display','block');
				$("header.header_topline").css({
					"position" : "relative",
					"width" : "auto"
				});
				$("a.logo > img").css("width","auto");
			}

			if (fullScreen) {
				var top = $assignBottomAnchor.offset().top;
				if ($(this).scrollTop() > top - 50) {
					$assignBottom.css({
						position: "fixed",
						top: "83px",
						width: assignWidth + "px"
					});
				} else {
					$assignBottom.attr('style','');
					$assignBottom.css({
						position: "static",
						width: "100%"
					});
					assignWidth = $assignBottom.width() + 40;
				}
			}



			
// Зафиксировать окно тегов			

           /* if (( $(this).scrollTop() > 920 ) && $(window).width() >= '1200' ){
                tagsblock.css('position','fixed');
                tagsblock.css('width','360px');
                tagsblock.css('top','40px');
				$("aside div.review-outer").css('display','none');
				if ($("div.tags-block-inner").height() > ($(window).height() - 50)){
					tagsblock.css('overflow-y','scroll');
				}
							  
			} else if(($(this).scrollTop() < 920)  && $(window).width() >= '1200') {
                tagsblock.css('position','relative');
                tagsblock.css('width','auto');
                tagsblock.css('top','0');
				$("aside div.review-outer").css('display','block');
				if ($("div.tags-block-inner").height() > ($(window).height() - 50)){
					tagsblock.css('overflow-y','hidden');
				}
				
			}
			*/
			

//Показать мобильную фильтрацию пр прокрутке

            if (( $(this).scrollTop() > 550 ) && $(window).width() < '900' ){
					$("div.filter-mob").css('display','block');
			}
            if (( $(this).scrollTop() <= 550 ) && $(window).width() < '900' ){
					$("div.filter-mob").css('display','none');
			}

//Показать кнопку "Перейти в каталог"

            if (( $(this).scrollTop() > 10 ) && $(window).width() < '900' ){
					$("a.quick-jump").css('display','none');
			}
            if (( $(this).scrollTop() <= 10 ) && $(window).width() < '900' ){
					$("a.quick-jump").css('display','block');
			}

		});//scroll	


				if ($(window).width() < '900'){
					$("div.aside-block > #tags-block").css('display','none');
					$("div.filter").css('display','none');
					mainmap.css('display','none');
					$("#map").css('display','none');
					$("a.quick-jump").css('display','block');
					$("aside div.review-outer").css('display','none');
				}
		
// Кнопка "показать весь прайс"/"свернуть прайс"
				$('a.all-prices').click(function(){
					var a = $(this).html();
					if (a == "Показать <span>весь прайс</span>") {
						$(".more_prices").toggle();
						$(this).html("Свернуть <span>весь прайс</span>");
						$(this).toggleClass('opened-price');
					}
					else{
						$(".more_prices").toggle();
						$(this).html("Показать <span>весь прайс</span>");
						$(this).toggleClass('opened-price');
					}
				});

//  Свернуть/Показать ответ
                $('.question-answer').on('click', '.toggle-answer', function(){
                    $(this).parent().parent().toggleClass("opened-answer");
                    $(this).siblings('.answer').toggle(1000);
                });	
				
				$('a.toggle-answer').click(function(){
					var a = $(this).text();
					if (a == "Посмотреть ответ") {
						$(this).text("Закрыть ответ");
					}
					else{
						$(this).text("Посмотреть ответ");
					}
				});

// Свернуть/Показать доп. информацию об акции

                $('.discount-inner').on('click', '.more-about-discount', function(){
                    $(this).siblings('.discount-text').toggle(1000);
                    $(this).parent().toggleClass("opened-discount");
               });	
				
				$('a.more-about-discount').click(function(){
					var a = $(this).text();
					if (a == "Подробнее") {
						$(this).text("Скрыть");
					}
					else{
						$(this).text("Подробнее");
					}
				});
				
	
	});

function showInfoAjaxButton(selector){
	$(selector).one('click',function(event){
		var url = $(this).attr('data-url');
		var param = $(this).attr('data-param');
		var $el = $(this);
		var show = $(this).attr('data-show');
		if (show) {
			$el.replaceWith(show);
		}
		$.post(url, {param:param},null, "JSON").done(function(data){
			if (!show) {
				$el.replaceWith(data.show);
			}
		});
		event.stopPropagation();
		return false;
	});
}
function sendVkLoginRequest() {

	$("body").on("click",'#send_post',function(){
		alert('asd');
		$('#ReviewTextHidden').val($('#post_field').html());
		$('#comment-form').submit();
	});
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
}