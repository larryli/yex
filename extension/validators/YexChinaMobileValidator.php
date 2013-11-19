<?php
/**
 * YexChinaMobileValidator class file.
 *
 * @author Larry Li <larryli@qq.com>
 * @link https://larryli.cn/
 * @copyright 2013 Larry Li
 * @license http://www.yiiframework.com/license/
 */

/**
 * YexChinaMobileValidator 用于严重中国大陆手机号码规则。
 *
 * YexChinaMobileValidator 可以在 AR 对象验证数据。
 * 简单的用法如下：
 * <pre>
 * public function rules()
 * {
 *     return array(
 *         array('mobile', 'yex.validators.YexChinaMobileValidator'),
 *    );
 * }
 * </pre>
 * {@link allowEmpty} 默认值为 true，即允许被测试的内容为空。
 * {@link pattern} 可以使用自己的正则表达式用于手机号码验证。
 * 另外，{@link message} 用于自定义出错信息。
 *
 * @author Larry Li <larryli@qq.com>
 * @package yex.validators
 */
class YexChinaMobileValidator extends CValidator
{
    public $allowEmpty = true;
    public $pattern = '/^1[3|4|5|8][0-9]\d{8}$/';
    public $message = '手机号码必须是11位数字';

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value))
            return;
        if (!preg_match($this->pattern, $value)) {
            $this->addError($object, $attribute, $this->message);
        }
    }

}
