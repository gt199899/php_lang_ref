<?php
// +----------------------------------------------------------------------
// | Language Reference >> Predefined Interfaces and Classes >> Generator
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-11-13 17:48
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * Generator implements Iterator {
 *  --Methods--
 *      public mixed current ( void )
 *      public mixed getReturn ( void )
 *      public mixed key ( void )
 *      public void next ( void )
 *      public void rewind ( void )
 *      public mixed send ( mixed $value )
 *      public mixed throw ( Throwable $exception )
 *      public bool valid ( void )
 *      public void __wakeup ( void )
 */

/**
 * current 返回当前产生的值
 */
function t()
{
    for ($i = 1; $i <= 10; $i++) {
        yield $i;
    }
    return 100;
}

$gen = t();
//var_dump($gen->current());
var_dump($gen->getReturn());
// 输出 int(1)

/**
 * getReturn 返回生成器函数中return值
 * 确保使用getReturn的时候生成器函数返回return值而不是yield值，否则会报错；
 */
$gen = (function () {
    yield 1;
    yield 2;

    return 3;
})();

foreach ($gen as $val) {
    echo $val, PHP_EOL;
}

echo $gen->getReturn(), PHP_EOL;
// 输出：
// 1
// 2
// 3

/**
 * key 返回yield值的key
 * 如果没有key，返回0
 */
$gen = (function () {
    yield 1 => 2;
})();
var_dump($gen->key());
var_dump($gen->current());
// 输出：
// int(1)int(2)
$gen = (function () {
    yield 1;
})();
var_dump($gen->key());
var_dump($gen->current());
// 输出：
// int(0)int(1)

/**
 * next 生成器继续执行
 * 生成器已经执行到末尾，不会自动next到开始
 */
$gen = (function () {
    yield 1;
    yield 2;
    yield 3;
})();
var_dump($gen->current());
$gen->next();
var_dump($gen->current());
$gen->next();
var_dump($gen->current());
$gen->next();
var_dump($gen->current());
// 输出：
// int(1)int(2)int(3)NULL

/**
 * rewind 重置生成器
 * 如果生成器已经执行，则会抛出一个异常
 */

/**
 * send 向生成器传入一个值
 */
function printer()
{
    while (1) {
        $string = yield;
        echo $string . PHP_EOL;
    }
}

$printer = printer();
$printer->send('Hello world!');
$printer->send('How are you?');
// 输出：
// Hello world!
// How are you?
//

// +----------------------------------------------------------------------
/**
 * 以下是一个通过send和yield实现的双向通信的例子，从鸟哥哪里拿来的
 * 需要注意的是：
 *      官网说法：send方法，向生成器传入一个值，并且把这个值作为当前执行yield的结果，并且继续执行生成器；
 *      也就是说，send方法做了三件事情；
 *      send方法返回的值很有意思，他返回生成器继续执行的下一个yield返回的值，注意，不是本次yield表达式返回的值，一定要注意；
 */
function gen()
{
    $ret = (yield 'yield1');
    var_dump($ret);
    $ret = (yield 'yield2');
    var_dump($ret);
}

$gen = gen();
// 这里输出当前生成器的值，第一个yield的值：yield1
var_dump($gen->current());
// 这里向生成器发送ret1，并且继续执行生成器到下一个yield，执行生成器遇到gen里面第一个var_dump，则输出第一个yield表达式的值，即为send传入的值ret1；
// 这里的var_dump($gen->send)，则为send方法的返回值，send方法的返回值为下一个yield表达式返回的值，即为yield2；
// 所以这里输出：
//      string(4) "ret1"   (the first var_dump in gen)
//      string(6) "yield2" (the var_dump of the ->send() return value)
var_dump($gen->send('ret1'));
// 这里向生成器发送ret2，并且继续执行生成器，执行生成器遇到gen里面第二个var_dump，输出第二个yield表达式的值，即为send传入的值ret2；
// 由于生成器后面没有yield表达式，所以send方法返回为null
// 故输出：
//      string(4) "ret2"   (again from within gen)
//      NULL               (the return value of ->send())
var_dump($gen->send('ret2'));

// 输出：
// string(6) "yield1"
// string(4) "ret1"   (the first var_dump in gen)
// string(6) "yield2" (the var_dump of the ->send() return value)
// string(4) "ret2"   (again from within gen)
// NULL               (the return value of ->send())
// +----------------------------------------------------------------------

/**
 * throw 向生成器中抛入一个异常
 */
$gen = (function () {
    try {
        yield 1;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
})();
$gen->throw(new Exception('gen throw exception'));
// 输出：
// gen throw exception

/**
 * valid 检查迭代器是否被关闭
 * 当前生成器中执行到最后，则为关闭，否则为开启
 */
$gen = (function () {
    yield 1;
})();

var_dump($gen->valid());
$gen->next();
var_dump($gen->valid());
// 输出：
// bool(true)bool(false)

/**
 * __wakeup 抛出一个异常以表示生成器不能被序列化；
 */
$gen = (function () {
    yield 1;
})();
var_dump($gen->__wakeup());
// 抛出异常
// Fatal error: Uncaught Exception: Unserialization of 'Generator' is not allowed in ...