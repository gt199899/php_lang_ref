<?php
// +----------------------------------------------------------------------
// | Created by im-server.
// +----------------------------------------------------------------------
// | Language Reference >> References Explained >> What References Do
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-07-16 16:52
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * PHP 的引用允许用两个变量来指向同一个内容。
 * 需要注意的是如果$a引用了$b,并不是$a指向了$b,或者相反，而是$a和$b同时指向了一个内容。
 * case1：如果对一个未定义的变量进行引用赋值、引用参数传递或引用返回，则会自动创建该变量；
 * case2：如果在一个函数内部给一个声明为 global 的变量赋于一个引用，该引用只在函数内部可见。可以通过使用 $GLOBALS 数组避免这一点；
 * case3：foreach中的另一种引用赋值；
 * case4：引用传递变量；
 */

namespace case1;
$x = &$xx;
var_dump($x);
var_dump($xx);

function foo(&$var)
{
}

foo($a); // $a is "created" and assigned to null
var_dump($a);

$b = array();
foo($b['b']);
var_dump(array_key_exists('b', $b)); // bool(true)

$c = new \StdClass;
foo($c->d);
var_dump(property_exists($c, 'd')); // bool(true)

function &fee()
{
    static $a;
    return $a;
}

$fee = fee();
var_dump($fee);
$fee = 10;
$fee = fee();
var_dump($fee);

$fee = &fee();
var_dump($fee);
$fee = 10;
$fee = &fee();
var_dump($fee);

/**
 * 输出：
 * NULL
 * NULL
 * NULL
 * bool(true)
 * bool(true)
 * NULL
 * NULL
 * NULL
 * int(10)
 */

namespace case2;
$var1 = "Example variable";
$var2 = "";

function global_references($use_globals)
{
    global $var1, $var2;
    if (!$use_globals) {
        $var2 =& $var1; // visible only inside the function
    } else {
        $GLOBALS["var2"] =& $var1; // visible also in global context
    }
}

global_references(false);
echo "var2 is set to '$var2'\n"; // var2 is set to ''
global_references(true);
echo "var2 is set to '$var2'\n"; // var2 is set to 'Example variable'
/**
 * global $var; 是$var = &$GLOBALS['var'];的简写。
 * 从而 $var2 =& $var1; 仅仅只改变了本地变量的引用。
 * 输出：
 * var2 is set to ''
 * var2 is set to 'Example variable'
 */

namespace case3;
$ref = 0;
$row =& $ref;
foreach (array(1, 2, 3) as $row) {
    // do something
}
echo $row . " ";
echo $ref . " ";
$row = 1;
echo $row . " ";
echo $ref . " ";
/**
 * 输出：
 * 3 3 1 1
 */

namespace case4;
function foo(&$var)
{
    $var++;
}

$a = 5;
foo($a);
echo $a;
/**
 * 输出：
 * 6
 */