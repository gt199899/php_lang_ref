<?php
// +----------------------------------------------------------------------
// | Created by im-server.
// +----------------------------------------------------------------------
// | Language Reference >> References Explained >> Returning References
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-07-16 18:25
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * 引用返回将函数返回对应的变量和函数被赋值的变量指向同一个内容；
 * 官网的定义：引用返回用在当想用函数找到引用应该被绑定在哪一个变量上面时；
 * case1：官网示例
 */

namespace case1;

class foo
{
    public $value = 42;

    public function &getValue()
    {
        return $this->value;
    }
}

$obj = new foo;
$myValue = &$obj->getValue(); // $myValue is a reference to $obj->value, which is 42.
$obj->value = 2;
echo $myValue;                // prints the new value of $obj->value, i.e. 2.
/**
 * 输出：
 * 2
 */