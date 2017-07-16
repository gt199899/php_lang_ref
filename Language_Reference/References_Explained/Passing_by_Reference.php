<?php
// +----------------------------------------------------------------------
// | Created by im-server.
// +----------------------------------------------------------------------
// | Language Reference >> References Explained >> Passing by Reference
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-07-16 18:00
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * 可以将一个变量通过引用传递给函数，这样该函数就可以修改其参数的值。
 * 引用传递最稳妥的方式是传递变量，否则不同版本下有不同的编译标准。
 * case1：引用传递仅仅能传递变量，New语句，从函数中返回的引用，其余表达式均不能使用引用传递；
 */

namespace case1;

function foo(&$var)
{
    $var++;
}
$a = 1;
foo($a);
var_dump($a);
/**
 * 输出：
 * int(2)
 */

function foo1(&$var)
{
    $var::$param++;
}

class cla
{
    static public $param = 0;
}

foo1(new cla());
var_dump(cla::$param);
/**
 * PHP手册里面说，可以使用new class()，但是PHP7.0中会产生一个Notice，不影响返回结果
 * 输出：
 * Notice: Only variables should be passed by reference in ...
 * int(1)
 */

function foo2(&$var)
{
    $var++;
    return $var;
}

function &test(){
    $a = 10;
    return $a;
}

var_dump(foo2(test()));
/**
 * 输出：
 * int(11)
 */

function foo3(&$var)
{
    $var++;
    return $var;
}

function test3(){
    $a = 10;
    return $a;
}

var_dump(foo3(test3()));
/**
 * 自 PHP 7.0 起导致 notice 信息
 * 输出：
 * PHP Notice:  Only variables should be passed by reference in
 * int(11)
 */

function foo4(&$var)
{
    $var++;
    return $var;
}

var_dump(foo4(1));
/**
 * 输出：
 * PHP Fatal error:  Only variables can be passed by reference in
 */

function foo5(&$var)
{
    $var++;
    return $var;
}

var_dump(foo5($a = 1));
/**
 * 输出：
 * PHP Notice:  Only variables should be passed by reference in
 * int(2)
 */