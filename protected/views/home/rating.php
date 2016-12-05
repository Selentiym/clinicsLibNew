<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 29.02.2016
     * Time: 19:56
     */

Yii::app()->getClientScript()->registerScript("ready","
$('.zapis_na_priem').click(function(e) { e.preventDefault(); $('#exampleModal1').arcticmodal();});
",CClientScript::POS_READY);
?>
<div class="main_content">
	<div class="in_main_content">
		<div class="in_main_content_left">
            <!--<div class="zagolovok">
                <h1>Самые популярные клиники</h1>
                <form>
                    <input type="button" id="sortByPrice" value="Сортировать по цене" style="cursor:pointer;">
                </form>
            </div>-->
            <div style="color:#008fd3; font-size:22px; font-weight:bold;font-family:Calibri;">
                <h2>В каких медицинских учреждениях Вы сможете пройти исследование наиболее <span style="text-decoration:underline">качественно</span>?</h2>
                <span style="font-style: italic">или</span>
                <h2>Где <span style="color:red">НЕ</span> стоит проходить МРТ или КТ диагностику??</h2>
            </div>
            <div style="text-align:justify;font-size:15px;margin:20px;line-height:19px;color:#958f8a;">
                <p>Чтобы пройти качественное исследование, ведь именно это залог верного диагноза и как следствие правильного лечения и здоровья , Вам необходимо узнать ответ всего на два вопроса:</p>
                <ol style="margin-left: 40px;"><li>Что такое качественное исследование ?</li>
                <li>Где можно пройти качественную МРТ/КТ диагностику?</li></ol>
                <p>Качественное МРТ или КТ исследование базируется на следующих моментах:</p>
                <ul style="list-style-type: disc;margin-left: 40px;">
                <li><span class="list-heading">Хорошее оборудование</span> – получаемые МР и КТ изображения (которые описывает врач рентгенолог и на основании которых ставится диагноз) должны быть соответствующего качества, чего чаще всего невозможно достичь на устаревшей аппаратуре.</li>
                <li><span class="list-heading">Экспертность врача</span> – даже очень хорошее оборудование, на котором получаются великолепные МР и КТ изображения, не может поставить диагноз самостоятельно. Залогом верного диагноза является опытный и грамотный доктор.</li>
                <li><span class="list-heading">Время</span> – количество времени уделяемое каждому пациенту - время потраченное на проведение исследования + время потраченное доктором на интерпритацию полученных результатов, описание исследования и постановка диагноза.</li>
                </ul>
                <p>Мы получили очень простую формулу:</p>
                <p style="margin:20px 0;color:#008fd3; font-size:20px; text-align:center">Качественная МРТ/КТ диагностика = Хорошее оборудование + Экспертность врача + Время</p>
                <p>Это и есть ответ на первый вопрос: <span style="text-decoration: underline;color:black">Что такое качественное исследование?</span></p>
                <p>Теперь нам следует ответить на второй вопрос:</p>
                <p style="text-decoration: underline;color:black">Где можно пройти качественную МРТ/КТ диагностику?</p>
                <p style="text-decoration: underline;color:black">Как найти медицинский центр, где сделают качественное исследование?</p>
                <p>В нашем городе более <span style="color:black;font-weight:bold">100</span> диагностических медицинских учреждений, где можно пройти МРТ и КТ диагностику, ниже представлен список (рейтинг) медицинских клиник макимально удовлетворяющих параметрам качества описанным выше!
                </p>

            </div>
			<div class="clear"></div>
			<?php
            /**
             * Obtain ten most popular clinics
             */
            $criteria = new CDbCriteria();
            $criteria -> order = 'rating DESC';
            $criteria -> limit = 10;
            $objects = clinics::model() -> findAll($criteria);
            $modelName = 'clinics';
            foreach($objects as $obj) {
                $this -> renderPartial('//home/_single_'.$modelName, array('model' => $obj));
            }
            ?>
            <?php if ($maxPage > 1) : ?>
                <div class="more_rezult">
                    <button id = "show_rez">Больше результатов</button>
                </div>
            <?php endif; ?>
            </div>

            <?php $this -> renderPartial('//layouts/right_column', true,false); ?>
        </div>
    </div>