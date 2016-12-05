<?php
class CTController extends Controller
{
    public $defaultAction = 'CallStarted';
    /**
     * @var CallTrackerModule $module
     */
    public $module;
    public function actionIndex()
    {
        echo "this is the index action";
    }
    public function actionCheck() {
        //var_dump(phNumber::freestNumbers());
        /*$e = $this -> getModule() -> enter;
        echo $e -> getNumber() -> id;
        var_dump($e);*/

    }

    /**
     * @return CallTrackerModule
     */
    public function getModule() {
        return parent::getModule();
    }

    /**
     * Отвечает на ajax запросы о статусе.
     *
     */
    public function actionCallStatus() {
        //if (true){
        if (Yii::app() -> request -> isAjaxRequest) {
            $enter = $this->getModule()->enter;
            echo json_encode($enter -> attributes);
            //На всякий случай уточняем
            $enter -> active = 1;
            //Обновляем время последнего захода
            $enter -> save();
            //Подчищаем заходы. Имеет смысл делать именно здесь,
            // чтобы чистилось тем чаще, чем больше людей
            ob_start();
            CallTrackerModule::removeGarbage();
            //
            //Вывод будет мешать, поэтому выкидываем его нафиг
            ob_end_clean();
        } else {
            echo "This page is for ajax load only.";
            http_response_code(403);
        }
    }

    /**
     * Завершает долго неактивные заходы
     */
    public function actionRemoveGarbage() {
        CallTrackerModule::removeGarbage();
    }
    public function actionCallStarted () {
        //
        ob_start();
        $apiCall = aApiCallFactory::getFactory() -> build();
        $apiCall -> setData($_REQUEST);
        $enter = $apiCall -> lookForEnter();
        //Если заход нашелся, связываем вызов апи с найденным заходом
        if (is_a($enter, 'aEnter')) {
            $apiCall -> linkEnter($enter);
            $enter -> linkApiCall($apiCall);
        }
        $apiCall -> saveChanges();
        var_dump($_REQUEST);
        $out = ob_get_contents();
        ob_end_clean();
        $this -> getModule() -> log($out);
    }

    public function actionShowLog() {
        echo file_get_contents($this -> getModule() -> logFileName());
    }
    /*public function actionLeave() {

        if (Yii::app() -> request -> isAjaxRequest) {
            $enter = $this->getModule()->enter;
            $enter -> active = 0;
            //Обновляем время последнего захода
            $enter -> save();
        } else {
            echo "This page is for ajax load only.";
            http_response_code(403);
        }
    }*/
}