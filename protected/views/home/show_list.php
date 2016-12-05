<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/map_select.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/map_select.css'); ?>
<?php $base = Yii::app() -> baseUrl; ?>



<div id="content" class="main_page">
    <div id="main-text">
        <div class="line" style="margin-bottom:0;"></div>
        <p>Здесь Вы можете подобрать клинику по параметрам:</p>
        <ul class="blue-label">
            <li><b>Цена</b> (также узнать о самых горячих Акциях и Скидках города в разделе <a href="<?=$base?>/discount" target="_blank">“Самые горячие предложения по СПб”</a>)</li>
            <li><b>Расположение</b> (район, метро)</li>
            <li><b>Оборудование</b> (открытый, закрытый МРТ томограф, 0.2-0.4 Тл, 1,5 Тл, 3 Тл, 16, 64 и 128 срезовый КТ томограф)</li>
            <li><b>Специализация клиники</b> на определенном виде исследования (головной мозг, позвоночник, суставы, исследования детям, редкие исследования и т.д.)</li>
        </ul>
        <p>Для подбора клиник по параметрам достаточно кликнуть на соответствующий тег <img src="<?=$base?>/img/empty-tag.jpg" alt=""> в левом меню сайта.</p>
    </div>
    <?php
    Yii::app()->getClientScript()->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
    $toAdd = '';
    $clinics_to_map = clinics::model() -> findAll();
    //$clinics_to_map = clinics::model() -> findAllByAttributes(['partner' => 1]);
    foreach ($clinics_to_map as $clinic) {
        if ($clinic -> map_coordinates) {
            $temp = [
                "hintContent" => $clinic -> name.', '.$clinic->address
            ];
            $toAdd .= "{$clinic -> verbiage} = new ymaps.Placemark( [{$clinic -> map_coordinates}] , ".json_encode($temp).");";
            $toAdd .= $clinic -> verbiage."id=".$clinic -> id.";";
            $toAdd .= "window.allClinicsMap.geoObjects.add({$clinic -> verbiage});";
        }
    }
    Yii::app()->getClientScript()->registerScript("map_init","
    ymaps.ready(function () {
    window.allClinicsMap = new ymaps.Map('main-map', {
    center: [59.939095, 30.315868],
    zoom: 10
    }, {
    searchControlProvider: 'yandex#search'
    });
    ".$toAdd."

    YMaps.Events.observe(map,map.Events.Click, function (placemark) {
                alert('cl');
                console.log(placemark);
            });

    });
    ",CClientScript::POS_READY);
    ?>
    <div id="main-map">

    </div>
    <!--<div id="main-map">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=fHrbBwPUg74-JUPpCs4bVzOeggNwiwgJ&amp;width=100%&amp;height=100%&amp;lang=ru_RU&amp;sourceType=constructor&amp;"></script>
    </div>-->
    <div class="clear"></div>
    <div class="line"></div>


    <div class="filter">
        <form method="post" action="<?=$base?>/<?=$modelName?>/<?=$_GET['triggerType']?>/<?=$_GET['rubbish']?>">
            <input type="hidden" name="<?=$modelName?>SearchForm[submitted]" value="1"/>
            <div class="select-outer">
                <?php
                    $distrs = Districts::model() -> findAll();
                    echo CHtml::dropDownList($modelName.'SearchForm[district]',$fromPage['district'],array_merge([0=>"Выберите район"],CHtml::listData($distrs,'id','name')),[
                        'id' => 'region',
                        'size' => 1
                    ]);
                ?>
                <a class="select-button"></a>
            </div>
                <div class="metro-select">
                    <span>Станция метро</span>

                    <div class="b-metro-map region-653240">
                        <span class="metro-clear">Очистить</span>
                        <span class="metro-close">Применить</span>
                        <span class="metro-close closeX">X</span>
                        <?php
                        $metro_obj = Metro::model()->findAll();
                        $val = $_POST["clinicsSearchForm"]["metro"] ? $_POST["clinicsSearchForm"]["metro"] : $_POST["doctorsSearchForm"]["metro"];
                        if (!is_array($val)) {
                            $val = array();
                        }
                        foreach($metro_obj as $metro) {
                            $checked = in_array($metro -> id, $val) ? ' checked = "checked" ' : '';
                            $related = $metro -> data_related ? ' data-related="'.$metro -> data_related.'" ' : '';
                            echo "<i class='st'><input type='checkbox' name='clinicsSearchForm[metro][]' {$checked} {$related} id='rf_metro_{$metro -> map_id}' value='{$metro -> id}'>{$metro -> name}<i class='mark'></i><i class='name'></i></i>";
                        }
                        ?>
                    </div>

                </div>
            <div class="select-outer">
                <select id="price" name="<?=$modelName?>SearchForm[price]" size="1">
                    <option value="">
                        Фильтр по цене
                    </option>
                    <option value="priceUp" <?php if ($fromPage["price"] == 'priceUp') {echo "selected=selected";} ?>>
                        Сначала дешевле
                    </option>
                    <option value="priceDown" <?php if ($fromPage["price"] == 'priceDown') {echo "selected=selected";} ?>>
                        Сначала дороже
                    </option>
                </select>
                <a class="select-button"></a>
            </div>
			
			<div class="search-reset-buttons">
				<input class="search-button" type="submit" value="Искать"/>
				<a class="reset-button" href="<?=$base?>/?clear=1">Сбросить</a>
			</div>
			
            <div class="view-block">
                <label for="list" class="for-radio">
                    <input type="radio" name="view" value="list" id="list" checked="checked"/>
                    <span class="view-list">Показать<br>списком</span>
                </label>
                <label for="map" class="for-radio">
                    <input type="radio" name="view" value="map" id="map" />
                    <span class="view-map">Показать<br>на карте</span>
                </label>
            </div>
            <!--
                Можно менять value, перемещать внутри тега form как угодно. Можно даже заменить
                другим элементом, лишь бы по нажатии на него вызывалось событие submit формы.
            -->

            <div class="clear"></div>
        </form>
    </div>
    <div id="catalog-jump" class="clear"></div>

    <?php
        if (!empty($objects)) {
            foreach ($objects as $obj) {
                $this->renderPartial("//$modelName/_list_shortcut", ['model' => $obj]);
            }
        } else {
            echo "<div style='margin:0 auto'>";
            echo "<p>По Вашим критериям ничего не найдено.</p>";
            echo '
            <div class="search-reset-buttons">
				<a class="reset-button" href="'.$base.'/?clear=1">Сбросить</a>
			</div>
			';
            echo "</div>";
        }
    ?>

    <div class="pagination">
        <?php if ($page > 1) {
            echo '<a class="prev" href="?page=' . ($page - 1) . '"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';
        } ?>
        <?php
            for ($i=1; $i <=$maxPage;$i++) {
                if ($i != $page) {
                    echo "<a href='?page=$i'>$i</a>";
                } else {
                    echo "<span>$i</span>";
                }
            }
        ?>
        <?php if ($page < $maxPage) {
            echo '<a class="next" href="?page='.($page+1).'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
        } ?>
    </div>
</div>
<div class="filter-mob">
    <form method="post" action="<?=$base?>/<?=$modelName?>/<?=$_GET['triggerType']?>/<?=$_GET['rubbish']?>">
        <input type="hidden" name="<?=$modelName?>SearchForm[submitted]" value="1"/>
        <div class="select-outer">
            <?php
            $distrs = Districts::model() -> findAll();
            echo CHtml::dropDownList($modelName.'SearchForm[district]',$fromPage['district'],array_merge([0=>"Район"],CHtml::listData($distrs,'id','name')),[
                'id' => 'region_mob',
                'size' => 1
            ]);
            ?>
            <a class="select-button"></a>
        </div>
        <div class="select-outer">
            <select id="subway_mob" size="1" name="<?=$modelName?>SearchForm[metro]" >
                <option value="">Метро</option>
                <?php
                $metro_obj = Metro::model()->findAll();
                if (empty($fromPage['metro'])) {
                    $fromPage['metro'] = [];
                }
                foreach ($metro_obj as $m) {
                    /**
                     * @type Metro $m
                     */
                    $selected = in_array($m->id, $fromPage['metro']) ? 'selected="selected"' : '';
                    echo "<option value='$m->id' $selected>$m->name</option>";
                }
                ?>
            </select>
            <a class="select-button"></a>
        </div>
        <div class="select-outer">
            <select id="price_mob" name="<?=$modelName?>SearchForm[price]" size="1">
                <option value="">
                    Фильтр по цене
                </option>
                <option value="priceUp" <?php if ($fromPage["price"] == 'priceUp') {echo "selected=selected";} ?>>
                    Сначала дешевле
                </option>
                <option value="priceDown" <?php if ($fromPage["price"] == 'priceDown') {echo "selected=selected";} ?>>
                    Сначала дороже
                </option>
            </select>
            <a class="select-button"></a>
        </div>
    </form>
</div>
