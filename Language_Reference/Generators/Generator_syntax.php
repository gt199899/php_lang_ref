<?php
// +----------------------------------------------------------------------
// | Created by activity.
// +----------------------------------------------------------------------
// | Language >> Reference Generators
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-07-14 16:46
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------


/**
 * 生成器的主要目的就是实现对象迭代，并且比定义类实现Iterator接口的方式降低了开销和复杂性；
 * 生成器函数与普通的函数不同，普通的函数仅仅返回一次结果，而生成器函数可以根据需要yield多次(可以看做返回多次)；
 * Generator对象是一个实现Iterator接口的类，但是这个类不能实例化，由生成器函数返回；
 * case1：生成器函数返回的是一个Generator对象；
 * case2：yield会返回一个值给循环调用此生成器的代码；
 * case3：生成器函数被调用一次，就返回一个按顺序取到的yield的值，并且暂停执行，直到下次被调用；
 * case4：可以指定键名来生成值；
 * case5：yield可以在没有参数传入的情况下被调用来生成一个NULL值并配对一个自动的键名。
 *
 */

namespace case1;
function xrange($start, $limit, $step = 1)
{
    for ($i = $start; $i <= $limit; $i += $step) {
        yield $i;
    }
}

$object = xrange(1, 1000);
var_dump($object);
var_dump($object instanceof Iterator);
/**
 * 输出：
 * class Generator#1 (0) {
 * }
 * bool(true)
 */

namespace case2;
function gen_one_to_three()
{
    for ($i = 1; $i <= 3; $i++) {
        //注意变量$i的值在不同的yield之间是保持传递的。
        yield $i;
    }
}

foreach (gen_one_to_three() as $value) {
    echo "$value\n";
}
/**
 * 输出：
 * 1
 * 2
 * 3
 */

namespace case3;
function mul_yield()
{
    $ii = 1;
    for ($i = 1; $i <= 15; $i += 3) {
        yield "生成器内循环次数" . $ii;
        yield $i;
        yield $i + 1;
        yield $i + 2;
        $ii++;
    }
}

$i = 0;
$times = 1;
foreach (mul_yield() as $value) {
    if ($i >= $times) break;
    echo($value . "\n");
    $i++;
}
/**
 * 这里每当mul_yield生成器函数被调用一次，返回的是yield返回的值，并且暂停；
 * 注意并不是mul_yield被调用一次，将函数体执行一遍，仅仅是按顺序把yield返回到值输出；
 *
 * $times = 1 输出：
 * 生成器内循环次数1
 *
 * $times = 2 输出：
 * 生成器内循环次数1
 * 1
 *
 * $times = 15 输出：
 * 生成器内循环次数1
 * 1
 * 2
 * 3
 * 生成器内循环次数2
 * 4
 * 5
 * 6
 * 生成器内循环次数3
 * 7
 * 8
 * 9
 * 生成器内循环次数4
 * 10
 * 11
 */

namespace case3;
$input = <<<'EOF'
1;PHP;Likes dollar signs
2;Python;Likes whitespace
3;Ruby;Likes blocks
EOF;

function input_parser($input)
{
    foreach (explode("\n", $input) as $line) {
        $fields = explode(';', $line);
        $id = array_shift($fields);

        yield $id => $fields;
    }
}

foreach (input_parser($input) as $id => $fields) {
    echo "$id:\n";
    echo "    $fields[0]\n";
    echo "    $fields[1]\n";
}
// 输出：
//1:
//    PHP
//    Likes dollar signs
//2:
//    Python
//    Likes whitespace
//3:
//    Ruby
//    Likes blocks

namespace case4;
function gen_three_nulls()
{
    foreach (range(1, 3) as $i) {
        yield;
    }
}

var_dump(iterator_to_array(gen_three_nulls()));
// 输出：
//array(3) {
//        [0] =>
//  NULL
//  [1] =>
//  NULL
//  [2] =>
//  NULL
//}

