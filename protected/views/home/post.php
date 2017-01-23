<?php
/**
 *
 * @var HomeController $this
 */
?>
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.08.2016
 * Time: 12:17
 */
$success = true;
/*echo '123';
Yii::app() -> end();*/
$adminemail="shubinsa1@gmail.com";  // e-mail админа
//$adminemail="bondartsev.nikita@gmail.com";  // e-mail админа
$theme="Заказ с ClinicsLib";

$date=date("d.m.y"); // число.месяц.год

$time=date("H:i"); // часы:минуты:секунды

$name = trim($_REQUEST["name"]);
$phone = trim($_REQUEST["phone"]);


$params = array(
    'pid' => -4,
    'name' => $name,
    'phone' => $phone,
    'description' => 'Заявка с clinicsLib'св
);

//посылаем заявку к себе
if( $curl = curl_init() ) {
    try {
        curl_setopt($curl, CURLOPT_URL, 'http://p.mrimaster.ru/stat/FormAssign?' . http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out = curl_exec($curl);
        //echo $out;
        curl_close($curl);
    } catch (Exception $e) {

    }
}


//посылаем заявку на новую систему тоже
if( $curl = curl_init() ) {
    try {
        curl_setopt($curl, CURLOPT_URL, 'http://web-utils.ru/api/form?' . http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out = curl_exec($curl);
        //echo $out;
        curl_close($curl);
    } catch (Exception $e) {

    }
}


//Yii::app() -> end();
$headers = "From: clincisLib@mail.ru\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html\r\n";
$text = "Дата: <strong>{$date}</strong><br/>";
$text .= "Время: <strong>{$time}</strong><br/>";
$text .= "Имя: <strong>{$name}</strong><br/>";
$text .= "Телефон: <strong>{$phone}</strong><br/>";


require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
$mail = new PHPMailer(true);
$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = 'mrimaster.msk@gmail.com';
$mail->Password = include(Yii::getpathOfAlias('application.components') . '/mrimaster.pss.php');
$mail->Mailer = "smtp";

$mail->From = 'directors@mrimaster.ru';
$mail->FromName = 'clinicsLib.ru';
$mail->Sender = 'directors@mrimaster.ru';
$mail->CharSet = "UTF-8";
$mail->addAddress($adminemail);
$mail->addAddress('lg.operator.2@gmail.com');
$mail->addAddress('olga.seadorova@gmail.com');

$mail->Subject = $theme;
$mail->isHtml(true);
$mail->Body = $text;
if (!$mail->Send()) {
    $success = false;
    //echo "sent!";
}