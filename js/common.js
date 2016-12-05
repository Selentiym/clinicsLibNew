$(document).ready(function(){
	$("div.filter-mob form").change(function(){
		$(this).submit();
	});
	//Попап менеджер FancyBox
	//Документация: http://fancybox.net/howto
	$(".fancybox").fancybox();


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
					setTimeout(function(){
						window.allClinicsMap.container.fitToViewport();
					}, 1000);

					console.log(window.allClinicsMap);
				});
	
// Перерисовка верхнего меню при прокрутке страницы 		
		var tagsblock = $("div.aside-block");
		
        $(window).scroll(function(){

            if (( $(this).scrollTop() > 250 ) && $(window).width() >= '1200' ){
				$(".menu-desc").css('display','none');
				$("div.header_topline").css({
					"position" : "fixed",
					"width" : "1170px"
				});
				$("li.discount > a > .menu-title").html("<img src='"+baseUrl+"/img/percent.png'>Скидки, акции");
				$("a.logo > img").css("width","41px");
 				$("a.logo > span").css("font-size","16px")
								  .html("Каталог клиник МРТ и КТ");
								  
           } else if(($(this).scrollTop() <= 250)  && $(window).width() >= '1200') {
				$(".menu-desc").css('display','block');
				$("div.header_topline").css({
					"position" : "relative",
					"width" : "auto"
				});
				$("li.discount > a > .menu-title").html("<img src='"+baseUrl+"/img/percent.png'>Самые горячие<br>предложения по СПб");
				$("a.logo > img").css("width","auto");
 				$("a.logo > span").css("font-size","16px")
								  .html("Полный каталог <span>МРТ</span> и <span>КТ</span><br> клиник Cанкт-Петербурга");
			} 
			





			
// Зафиксировать окно тегов			
			
            if (( $(this).scrollTop() > 920 ) && $(window).width() >= '1200' ){
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
					$("a.logo > span").css("font-size","15px")
									  .html("Каталог клиник<br>МРТ и КТ в СПб");
					maintext.css('display','none');
					$("div.aside-block > #tags-block").css('display','none');
					$("div.filter").css('display','none');
					mainmap.css('display','none');
					$("div.main_page > h1").text('Наиболее полный каталог МРТ и КТ центров в СПб');
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
	var clinicInfoContainer = $("#toShowClinicInfo");
	function loadClinicInfo(id) {
		if (clinicInfoContainer.length) {
			clinicInfoContainer.html($("<img>",{
				src:baseUrl + '/img/loading.gif',
				class:'loadingGif'
			}));
			$.post(baseUrl + '/home/getClinicPage/' + id).done(function (data) {
				clinicInfoContainer.html(data);
				//активируем "показать телефон"
				showInfoAjaxButton(".ajaxShow");
			});
		}
	}