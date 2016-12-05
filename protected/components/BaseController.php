<?php

class BaseController extends Controller
{
    public $layout='//layouts/main';
    public $defaultAction = 'index';
    public $pageTitle;

    protected $districts, $metros, $triggers;

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index', 'search','articles'),
                'users'=>array('*'),
            )
        );
    }
	// ???? //
    public function init()
    { 
        parent::init();
        $this->objects = $this -> Model() -> findAll(array('order' => 'rating DESC'));
		/*$this->clinics = clinics::model()->findAll(array('with' => 'services', 'order' => 'rating DESC'));
        $this->metros = Metro::model()->findAll();
        $this->districts = Districts::model()->findAll();
        $this->triggers = TriggerValues::model()->with('trigger')->findAll();*/
        
        return;
    }
		public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	// переделать! обобщить на случай не клиник. //
	/**
	 * @var array array of objects
	 */
	protected $objects;
	public function actionIndex()
	{
		$objects = $this->objects;
		//обнуляем форму поиска, тк это не actionSearch.
		if (isset($_GET['SearchForm']))
			unset($_GET['SearchForm']);
		Yii::app() -> session -> remove('search');
		// массив объектов с дополнительными свойствами, которые нужны для отображения.
		$objects_display = array();
		//В цикле устанавливаются те самые дополнительные свойства. Для клиник это $object -> districts = array(...); - массив названий районов клиники и другие.
		foreach ($objects as $object) {

			//$metros = ''; $districts = ''; 
			$triggers = '';

			//$metros_array = array_map('trim', explode(';', $clinic->metro_station));
			//$districts_array = array_map('trim', explode(';', $clinic->district));
			/* triggers - готовим триггеры для отображения*/
			$triggers_array = array_map('trim', explode(';', $object->triggers));
			
			$criteria = new CDbCriteria();
			//какого хрена здесь t.id ?! только оно работает - остальное шлет нахрен
			//ответ: потому что t - дефолтный псевдоним таблицы в CDbCriteria. $criteria -> alias = 't';
			$criteria->addInCondition("t.id", $triggers_array);
			//отношение trigger должно соответствовать связи в таблиц object и object_triggers.
			$criteria->with = array('trigger');
			$criteria->limit = 5;
			$criteria->together = true;

			$triggers_array = TriggerValues::model()->findAll($criteria);
			$object->triggers_display = $triggers_array;
			//Устанавливаем остальные, необходимые для отображения свойства, которые отличаются у разных объектов.
			$this -> setAdditionalProperties($object);
			
			$objects_display[] = $object;

		}
		//создаем объект для отображения моделей в виде списка
		$dataProvider =  new CArrayDataProvider($objects_display,
			array(  'keyField' =>'id',
					'pagination' => array(
					'pageSize' => 10,
				)));
		//отображаем все объекты
		$this->render('//home/index_all', array(
			'clinics' => $dataProvider,
			'filterForm' => null
			
		));
	}
}
