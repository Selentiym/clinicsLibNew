<?php
/**
 * Fextures generator
 */
class FixtureCode extends CCodeModel
{
    public $modelPath   = 'application.models';
    public $fixturePath = 'application.tests.fixtures';
    public $rowsLimit   = null;
	public $rewrite     = false;

    protected $_models = array();

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('modelPath, fixturePath', 'filter', 'filter'=>'trim'),
            array('modelPath, fixturePath, rewrite', 'required'),
            array('rowsLimit', 'numerical','allowEmpty' => true),
			array('rewrite', 'boolean'),
        ));
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'modelPath'   => 'Models Path',
            'fixturePath' => 'Fixtures Path',
			'rewrite'     => 'Rewrite'
        ));
    }

    /**
     * @see CCodeModel::requiredTemplates()
     */
    public function requiredTemplates()
    {
        return array(
            'fixture.php'
        );
    }

    /**
     * @see CCodeModel::prepare()
     */
    public function prepare()
    {
        Yii::import($this->modelPath);
        $path = Yii::getPathOfAlias($this->modelPath);
        $this->scanDir($path);
        $templatePath = Yii::getPathOfAlias('application.gii.fixture.templates.default');
        $tableNames = array();
        foreach ($this->_models as $modelName) {
            $class = pathinfo($modelName, PATHINFO_FILENAME);

            //Thanks "@warden" for report
            $reflection = new ReflectionClass($class);
            if ($reflection->isAbstract() || !$reflection->isInstantiable()) {
                continue;
            }
            $constructor = $reflection->getConstructor();
            if ($constructor && $constructor->getNumberOfRequiredParameters() > 0) {
                continue;
            }
            //--------------------------

            $obj = new $class;
            if ($obj instanceof CActiveRecord) {
                //fix issues #6 reported by "oceatoon"
                $prefix = $obj->getDbConnection()->tablePrefix;
                $tableName = str_replace(array('{{','}}'), array($prefix,''),$obj->tableName());
                $writeTo = Yii::getPathOfAlias($this->fixturePath).DIRECTORY_SEPARATOR.$tableName.'.php';
                if (!in_array($tableName, $tableNames)
					&& ( $this->rewrite || (!$this->rewrite && !file_exists($writeTo))  )
				) {
                    $tableNames[] = $tableName;
                    if (!empty($this->rowsLimit)) {
                        $criteria = new CDbCriteria();
                        $criteria->limit = intval($this->rowsLimit);

                        $models = call_user_func(array($class, 'model'))->findAll($criteria);
                    } else
                        $models = call_user_func(array($class, 'model'))->findAll();

                    $this->files[] = new CCodeFile(
                            $writeTo,
                            $this->render($templatePath . DIRECTORY_SEPARATOR . 'fixture.php', array('models' => $models))
                        );
                }
            }
        }
    }
    /**
     * Scan directory and sub directory
     * @param string $path
     */
    protected function scanDir($path) {
        foreach (scandir($path) as $file) {
            if ('.' !== $file && '..' !== $file) {
                $filename = $path . DIRECTORY_SEPARATOR . $file;
                if (is_file($filename) && 'php' === pathinfo($file,PATHINFO_EXTENSION))
                    $this->_models[] = $file;
                else if (is_dir($filename)) {
                    Yii::import($this->modelPath . '.' . $file . '.*');
                    $this->scanDir($filename);
                }
            }
        }
    }
}
