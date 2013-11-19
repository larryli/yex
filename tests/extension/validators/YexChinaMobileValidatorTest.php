<?php

class YexChinaMobileValidatorTest extends YexTestCase
{
    public function testRule()
    {
        $model = new YexChinaMobileValidatorTestModel('default');
        $model->validate();
        $this->assertEmpty($model->getErrors());
        $model->default = '3812345678';
        $model->validate();
        $this->assertArrayHasKey('default', $model->getErrors());
        $model->default = '23812345678';
        $model->validate();
        $this->assertArrayHasKey('default', $model->getErrors());
        $model->default = '138123456789';
        $model->validate();
        $this->assertArrayHasKey('default', $model->getErrors());
        $model->default = '13812345678';
        $model->validate();
        $this->assertEmpty($model->getErrors());

        $model = new YexChinaMobileValidatorTestModel('notEmpty');
        $model->validate();
        $this->assertArrayHasKey('notEmpty', $model->getErrors());
        $model->notEmpty = '3812345678';
        $model->validate();
        $this->assertArrayHasKey('notEmpty', $model->getErrors());
        $model->notEmpty = '23812345678';
        $model->validate();
        $this->assertArrayHasKey('notEmpty', $model->getErrors());
        $model->notEmpty = '138123456789';
        $model->validate();
        $this->assertArrayHasKey('notEmpty', $model->getErrors());
        $model->notEmpty = '13812345678';
        $model->validate();
        $this->assertEmpty($model->getErrors());
    }

}

class YexChinaMobileValidatorTestModel extends CFormModel
{
    public $default;
    public $notEmpty;

    public function rules()
    {
        return array(
            array('default', 'yex.validators.YexChinaMobileValidator', 'on' => 'default'),
            array('notEmpty', 'yex.validators.YexChinaMobileValidator', 'allowEmpty' => false, 'on' => 'notEmpty'),
        );
    }

}
