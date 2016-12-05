<?php

function echob($str){
    echo "<br/>".$str."<br/>";
}

function resetId($model = NULL) {
    if ($model) { 
        $id = $model->primaryKey;
        $tablename = $model->tableSchema->name;
        $sql = "ALTER TABLE $tablename AUTO_INCREMENT = $id";
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->query(); 
        
        if (!$result)
            throw new CHttpException(404, СHtml::encode('Не удалось обновить ID в таблице $tablename.')); 
    }        
    return;
}
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
function str2url($str) {
    // переводим в транслит
    $str = rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}

function prepareTextToJS($str) {
    $search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезает javaScript
        "'<[\/\!]*?[^<>]*?>'si",           // Вырезает HTML-теги
        "'([\r\n])[\s]+'",                 // Вырезает пробельные символы
        "'&(quot|#34);'i",                 // Заменяет HTML-сущности
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d+);'e");                    // интерпретировать как php-код

    $replace = array ("",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)");

    $text = preg_replace($search, $replace, $str);
    return $text;
}

function giveMetroNamesArrayByCoords($shir,$dolg, $deltax='0.05', $deltay='0.05'){
    $str = urlencode($deltax.' '.$deltay);
    $url = "https://geocode-maps.yandex.ru/1.x/?kind=metro&geocode=N{$shir}%20E{$dolg}";//.'&'."rspn=0&spn={$str}";
    $obj = new SimpleXMLElement(file_get_contents($url));
    return giveMetrosNamesArrayByXML($obj);
}
function giveMetroNamesArrayByAddress($addr, $deltax='0.05', $deltay='0.05'){
    $addr = urlencode($addr);
    $url = "https://geocode-maps.yandex.ru/1.x/?kind=metro&geocode=Санкт-Петербург,{$addr}";
    $obj = new SimpleXMLElement(file_get_contents($url));
    return giveMetrosNamesArrayByXML($obj);
}
function giveMetrosNamesArrayByXML($obj){
    //var_dump($obj);
    $obj = $obj -> GeoObjectCollection -> featureMember ;
    $rez = array();
    $count = 0;
    foreach ($obj as $metroObj) {
        $temp = trim( preg_replace('/метро/','',($metroObj -> GeoObject -> name)));
        if ($temp != $metroObj -> GeoObject -> name) {
            $rez[] = $temp;
            $count ++;
        }
        if ($count == 3) {
            break;
        }
    }
    //var_dump($rez);
    return array_filter($rez);
    //var_dump(get_object_vars($obj));
}
function uploadImage($target_url,$whereToStore){
    if ($target_url) {
        //$target_url = "https://site.ru/file.gz";
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
        $ch = curl_init($target_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        $output = curl_exec($ch);
        $fh = fopen($whereToStore, 'w');
        fwrite($fh, $output);
        fclose($fh);
        return true;
    }
    return false;
}