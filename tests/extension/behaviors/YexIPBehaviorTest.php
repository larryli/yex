<?php

class YexIPBehaviorTest extends YexTestCase
{
    private $_connection;

    protected function setUp()
    {
        // pdo and pdo_sqlite extensions are obligatory
        if (!extension_loaded('pdo') || !extension_loaded('pdo_sqlite'))
            $this->markTestSkipped('PDO and SQLite extensions are required.');

        // open connection and create testing tables
        $this->_connection = new CDbConnection('sqlite::memory:');
        $this->_connection->active = true;
        $this->_connection->pdoInstance->exec(file_get_contents(dirname(__FILE__) . '/YexIPBehaviorTest.sql'));
        CActiveRecord::$db = $this->_connection;
    }

    protected function tearDown()
    {
        // close connection
        $this->_connection->active = false;
    }

    public function testCreateAttribute()
    {
        // behavior changes created_at after inserting
        $model1 = new YexIPBehaviorTestActiveRecord;
        $model1->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => 'created_at',
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => 'yex',
        ));
        $model1->title = 'testing-row-1';
        $this->assertEquals('', $model1->created_at);
        $model1->save();
        $this->assertEquals('127.0.0.yex', $model1->created_at, '', 2);

        // behavior changes created_at after inserting
        $model2 = new YexIPBehaviorTestActiveRecord;
        $model2->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => 'created_at',
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => 'yex',
        ));
        $model2->title = 'testing-row-2';
        $model2->created_at = 'yex';
        $this->assertEquals('yex', $model2->created_at);
        $model2->save();
        $this->assertEquals('127.0.0.yex', $model2->created_at, '', 2);

        // behavior does not changes created_at after inserting
        $model3 = new YexIPBehaviorTestActiveRecord;
        $model3->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => 'yex',
        ));
        $model3->title = 'testing-row-3';
        $model3->created_at = 'yex.yex';
        $this->assertEquals('yex.yex', $model3->created_at);
        $model3->save();
        $this->assertEquals('yex.yex', $model3->created_at);

        // behavior changes created_at after inserting
        $model4 = new YexIPBehaviorTestActiveRecord;
        $model4->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => 'created_at',
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => null,
        ));
        $model4->title = 'testing-row-4';
        $this->assertEquals('', $model4->created_at);
        $model4->save();
        $this->assertEquals('127.0.0.1', $model4->created_at, '', 2);

        // behavior changes created_at after inserting
        $model5 = new YexIPBehaviorTestActiveRecord;
        $model5->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => 'created_at',
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => null,
        ));
        $model5->title = 'testing-row-5';
        $model5->created_at = 'yex.yex.yex';
        $this->assertEquals('yex.yex.yex', $model5->created_at);
        $model5->save();
        $this->assertEquals('127.0.0.1', $model5->created_at, '', 2);

        // behavior does not changes created_at after inserting
        $model6 = new YexIPBehaviorTestActiveRecord;
        $model6->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => null,
        ));
        $model6->title = 'testing-row-6';
        $model6->created_at = 'yex.yex.yex.yex';
        $this->assertEquals('yex.yex.yex.yex', $model6->created_at);
        $model6->save();
        $this->assertEquals('yex.yex.yex.yex', $model6->created_at);
    }

    public function testUpdateAttribute()
    {
        // behavior changes updated_at after updating
        $model1 = YexIPBehaviorTestActiveRecord::model()->findByPk(1);
        $model1->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => false,
            'setLastAddressString' => 'yex',
        ));
        $this->assertEquals('192.168.1.1', $model1->updated_at);
        $model1->save();
        $this->assertEquals('127.0.0.yex', $model1->updated_at, '', 2);

        // behavior changes updated_at after updating
        $model2 = YexIPBehaviorTestActiveRecord::model()->findByPk(2);
        $model2->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => true,
            'setLastAddressString' => 'yex',
        ));
        $this->assertEquals('192.168.1.2', $model2->updated_at);
        $model2->save();
        $this->assertEquals('127.0.0.yex', $model2->updated_at, '', 2);

        // behavior does not changes updated_at after updating
        $model3 = YexIPBehaviorTestActiveRecord::model()->findByPk(3);
        $model3->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => 'yex',
        ));
        $this->assertEquals('192.168.1.3', $model3->updated_at);
        $model3->save();
        $this->assertEquals('192.168.1.3', $model3->updated_at);

        // behavior changes updated_at after updating
        $model4 = YexIPBehaviorTestActiveRecord::model()->findByPk(4);
        $model4->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => false,
            'setLastAddressString' => null,
        ));
        $this->assertEquals('192.168.1.4', $model4->updated_at);
        $model4->save();
        $this->assertEquals('127.0.0.1', $model4->updated_at, '', 2);

        // behavior changes updated_at after updating
        $model5 = YexIPBehaviorTestActiveRecord::model()->findByPk(5);
        $model5->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => true,
            'setLastAddressString' => null,
        ));
        $this->assertEquals('192.168.1.5', $model5->updated_at);
        $model5->save();
        $this->assertEquals('127.0.0.1', $model5->updated_at, '', 2);

        // behavior does not changes updated_at after updating
        $model6 = YexIPBehaviorTestActiveRecord::model()->findByPk(6);
        $model6->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => null,
            'setUpdateOnCreate' => false,
            'setLastAddressString' => null,
        ));
        $this->assertEquals('192.168.1.6', $model6->updated_at);
        $model6->save();
        $this->assertEquals('192.168.1.6', $model6->updated_at);

        // behavior does not changes updated_at after inserting
        $model7 = new YexIPBehaviorTestActiveRecord;
        $model7->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => false,
            'setLastAddressString' => 'yex',
        ));
        $model7->title = 'testing-row-7';
        $model7->updated_at = 'yex.yex';
        $this->assertEquals('yex.yex', $model7->updated_at);
        $model7->save();
        $this->assertEquals('yex.yex', $model7->updated_at);

        // behavior changes updated_at after inserting
        $model8 = new YexIPBehaviorTestActiveRecord;
        $model8->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => true,
            'setLastAddressString' => 'yex',
        ));
        $model8->title = 'testing-row-8';
        $model8->updated_at = 'yex.yex.yex';
        $this->assertEquals('yex.yex.yex', $model8->updated_at);
        $model8->save();
        $this->assertEquals('127.0.0.yex', $model8->updated_at, '', 2);

        // behavior changes updated_at after inserting
        $model9 = new YexIPBehaviorTestActiveRecord;
        $model9->attachBehavior('ipBehavior', array(
            'class' => 'yex.behaviors.YexIPBehavior',
            'createAttribute' => null,
            'updateAttribute' => 'updated_at',
            'setUpdateOnCreate' => true,
            'setLastAddressString' => null,
        ));
        $model9->title = 'testing-row-9';
        $model9->updated_at = 'yex.yex.yex.yex';
        $this->assertEquals('yex.yex.yex.yex', $model9->updated_at);
        $model9->save();
        $this->assertEquals('127.0.0.1', $model9->updated_at, '', 2);
    }
}

/**
 * @property integer $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 */
class YexIPBehaviorTestActiveRecord extends CActiveRecord
{
    /**
     * @return YexIPBehaviorTestActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'table';
    }
}
