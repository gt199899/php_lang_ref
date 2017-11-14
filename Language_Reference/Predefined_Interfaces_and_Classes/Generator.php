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
 *
 */

/**
 * current 返回当前产生的值
 */
function t(){
    for($i=1;$i<=10;$i++){
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
$gen = (function() {
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
$gen = (function() {
    yield 1 => 2;
})();
var_dump($gen->key());
var_dump($gen->current());
// 输出：
// int(1)int(2)
$gen = (function() {
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
$gen = (function(){
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