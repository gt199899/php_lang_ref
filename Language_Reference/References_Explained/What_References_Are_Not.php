<?php
// +----------------------------------------------------------------------
// | Created by im-server.
// +----------------------------------------------------------------------
// | Language Reference >> References Explained >> What References Are Not
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-07-16 17:30
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * 引用不是指针,所以不能实现case1中的情况；
 * case1
 * case2
 */

namespace case1;
function foo(&$var)
{
    $var = &$GLOBALS["baz"];
    return $var;
}

$baz = 0;
$bar = 1;
$foo = foo($bar);
var_dump($foo);
/**
 * 分析上面代码
 *  第一步：$bar通过引用传递到函数foo中的$var，所以$bar和$var指向同一个内容；
 *  第二步：函数foo中的$var又和$GLOBALS["baz"]指向同一个内容，此时$var的值变为0；
 * 原因为
 * 输出：
 * int(0)
 */

namespace case2;
function foo(&$var)
{
    $GLOBALS["baz"] = &$var;
    return $var;
}

$baz = 0;
$bar = 1;
$foo = foo($bar);
var_dump($baz);
/**
 * 将$GLOBALS["baz"]和$var都指向了$var的内容，所以输出为$bar的内容1；
 * 输出：
 * int(1)
 */

