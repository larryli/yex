<?php
/**
 * YexIPBehavior class file.
 *
 * @author Larry Li <larryli@qq.com>
 * @link https://larryli.cn/
 * @copyright 2013 Larry Li
 * @license http://www.yiiframework.com/license/
 */

/**
 * YexIPBehavior 用于自动填写 IP 信息。
 *
 * YexIPBehavior 可以在 AR 对象创建和更新时自动填写当前操作的 IP 数据。
 * 简单的用法如下：
 * <pre>
 * public function behaviors(){
 *    return array(
 *        'YexIPBehavior' => array(
 *            'class' => 'yex.behaviors.YexIPBehavior',
 *            'createAttribute' => 'create_ip_attribute',
 *            'updateAttribute' => 'update_ip_attribute',
 *        )
 *    );
 * }
 * </pre>
 * YexIPBehavior 类似于 zii.behaviors.CTimestampBehavior。
 * {@link createAttribute} 和 {@link updateAttribute} 可选属性的默认值为 'create_ip' 和 'update_ip'。
 * {@link setUpdateOnCreate} 默认值为 true。
 * {@link ipExpression} 可以使用自己的表达式。
 * 另外，{@link setLastAddressString} 可以设置 IP 地址的最后一位的替换字符串，默认为 '*'，设置为 null 可以不替换。
 *
 * @author Larry Li <larryli@qq.com>
 * @package yex.behaviors
 */
class YexIPBehavior extends CActiveRecordBehavior
{
    /**
     * @var mixed 创建 IP 的默认属性名，设置为 null 表示创建时不记录 IP。默认值是 'create_ip'。
     */
    public $createAttribute = 'create_ip';

    /**
     * @var mixed 更新 IP 的默认属性名，设置为 null 表示更新时不记录 IP。默认值是 'update_ip'。
     */
    public $updateAttribute = 'update_ip';

    /**
     * @var bool 是否在创建时设置更新 IP。默认是 false。
     */
    public $setUpdateOnCreate = false;

    /**
     * @var mixed 可以使用指定的 PHP 表达式来设置要设置的数据内容。默认为 null。
     *
     * 比如使用 'Yii::app()->getRequest()->getUserHostAddress()'。
     */
    public $ipExpression;

    /**
     * @var mixed 设置 IP 地址最后一位的替换字符串，null 表示不替换。默认为 '*'。
     */
    public $setLastAddressString = '*';

    /**
     * 处理 {@link CModel::onBeforeSave} 事件。
     * 自动按照规则设置指定属性的值。
     *
     * @param CModelEvent $event 事件参数
     */
    public function beforeSave($event)
    {
        if ($this->getOwner()->getIsNewRecord() && ($this->createAttribute !== null)) {
            $this->getOwner()->{$this->createAttribute} = $this->getUserHostAddress();
        }
        if ((!$this->getOwner()->getIsNewRecord() || $this->setUpdateOnCreate) && ($this->updateAttribute !== null)) {
            $this->getOwner()->{$this->updateAttribute} = $this->getUserHostAddress();
        }
    }

    /**
     * 返回 IP 地址
     *
     * @return string IPv4 字符串
     */
    protected function getUserHostAddress()
    {
        if ($this->ipExpression !== null)
            return @eval('return ' . $this->ipExpression . ';');
        $ip = Yii::app()->getRequest()->getUserHostAddress();
        if ($this->setLastAddressString !== null) {
            $pos = strrpos($ip, '.');
            if ($pos !== false)
                $ip = substr($ip, 0, $pos + 1) . $this->setLastAddressString;
        }
        return $ip;
    }

}
