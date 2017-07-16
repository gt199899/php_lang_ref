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
 * case5：yield可以在没有参数传入的情况下被调用来生成一个NULL值并配对一个自动的键名；
 * case6：使用引用来生成值；
 * case7：PHP7中，yield可以通过from关键字，从别的生成器，数组或者Traversable object中获取返回值；
 * case8：生成器中不能返回值，否则产生一个错误(PHP7中不会，和return空一样的效果)，但是return空是一个有效的语法并且会终止生成器继续执行；
 * case9：生成器返回的是Generator对象，可以使用Generator对象的方法来控制生成器；
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

namespace case4;
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

namespace case5;
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

namespace case6;
function &gen_reference()
{
    $value = 3;

    while ($value > 0) {
        yield $value;
    }
}

/*
 * 我们可以在循环中修改$number的值，而生成器是使用的引用值来生成，所以gen_reference()内部的$value值也会跟着变化。
 */
foreach (gen_reference() as &$number) {
    echo (--$number) . '... ';
}
/**
 * 输出：
 * 2... 1... 0...
 */

namespace case7;
function count_to_ten()
{
    yield 1;
    yield 2;
    yield from [3, 4];
    yield from new \ArrayIterator([5, 6]);
    yield from seven_eight();
    yield 9;
    yield 10;
}

function seven_eight()
{
    yield 7;
    yield from eight();
}

function eight()
{
    yield 8;
}

foreach (count_to_ten() as $num) {
    echo "$num ";
}
/**
 * 输出：
 * 1 2 3 4 5 6 7 8 9 10
 */

namespace case8;
function one_three()
{
    for ($i = 1; $i <= 3; $i++) {
        yield $i;
        if ($i == 2) return;
    }
}
foreach (one_three() as $value) {
    echo $value . " ";
}
/**
 * 输出：
 * 1 2
 */
function one_four()
{
    for ($i = 1; $i <= 4; $i++) {
        yield $i;
        return $i;
    }
}
$gen = one_four();
foreach ($gen as $value) {
    echo $value . " ";
}
echo $gen->getReturn();
/**
 * 手册上说生成器函数不能有返回值，否则会产生一个编译错误；
 * 但是PHP7这里返回值了之后，效果和返回空一样都是终止执行，并没有报错；
 * 使用getReturn()方法可以获取返回值；
 * 输出：
 * 1 1
 */

namespace case9;
function one_four()
{
    for ($i = 1; $i <= 4; $i++) {
        yield $i;
    }
}
$gen = one_four();
while (1) {
    $current = $gen->current();
    // 迭代器中没有值，返回空则终止循环
    if(!$current){
        break;
    }
    echo $current . " ";
    $gen->next();
}
/**
 * 输出：
 * 1 2 3 4
 */