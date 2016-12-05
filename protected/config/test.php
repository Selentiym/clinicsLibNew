<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.2016
 * Time: 16:14
 */
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'fixture'=>array(
                'class'=>'system.test.CDbFixtureManager',
            ),
            /* раскомментируйте, если вам нужно подключение к тестовой БД
            'db'=>array(
            'connectionString'=>'DSN для БД',
            ),
            */
        ),
    )
);