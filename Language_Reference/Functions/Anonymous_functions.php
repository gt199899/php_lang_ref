<?php
// +----------------------------------------------------------------------
// | Language Reference >> Functions >> Anonymous functions
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-08-10 10:09
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * 匿名函数，或者称为闭包函数，允许临时创建一个没有指定名称的函数。最经常用作为回调函数参数的值。
 * case1：匿名函数示例；
 * case2：匿名函数变量赋值；
 * case3：从父作用域继承变量；（ PHP 7.1 起，不能传入此类变量： superglobals、 $this 或者和参数重名。）
 * case4：匿名函数可以直接使用全局变量；
 * case5：匿名函数的父作用域是定义它函数，不一定是调用他的函数；
 * case6：类中的匿名函数自动绑定$this；
 * case7：匿名函数可以设置为静态；
 * case8：Closure 用于代表匿名函数的类，所有的匿名函数都是一个Closure类；
 * case9：Closure->bindTo()，复制当前闭包对象，绑定指定的$this对象和类作用域；
 * case10：Closure->bind()，Closure->bindTo()的静态方法，用法一样；第一个参数为闭包函数，后面参数一样；
 */

namespace case1;

echo preg_replace_callback('/-([a-z])/', function ($match) {
    return strtoupper($match[1]);
}, 'hello-world');

/**
 * preg_replace_callback中$match = [0=>'-w', 1=>'w']
 * /-([a-z])/ 匹配到的是 -w 字符串，是要替换的目标值；
 * 子模式([a-z]) 匹配到的是 w 字符串
 * 闭包函数中返回的值 $match[1]，即为替换值。
 * 所以本例中将 -w 替换为 W 值。
 * 输出：
 * helloWorld
 */

echo preg_replace_callback('/-([a-z])([a-z]{4})/', function ($match) {
    var_dump($match);
    return strtoupper($match[2]);
}, 'hello-world');

/**
 * preg_replace_callback中$match = [0=>'-world', 1=>'w', 2=>'orld']
 * /-([a-z])/ 匹配到的是 -w 字符串，是要替换的目标值；
 * 子模式([a-z]) 匹配到的是 w 字符串
 * 子模式([a-z]{4}) 匹配到的是 orld 字符串
 * 闭包函数中返回的值 $match[2]，即为替换值。
 * 所以本例中将 -world 替换为 ORLD 值。
 * 输出：
 * helloORLD
 */

namespace case2;

$test = function ($param) {
    return strtoupper($param);
};

var_dump($test('abc'));

/**
 * 输出：
 * ABC
 */

namespace case3;

$a = "hello";
$b = function ($c) use ($a) {
    echo $a . ' ' . $c;
};
$b('php');

/**
 * 输出：
 * hello php
 */

namespace case4;

define('T1', 'test1');
class test{

    const T1 = 'test2';

    public function hello(){
        $d = "test3";
        $a = function() use ($d){
            var_dump(T1);
            var_dump(self::T1);
            var_dump($d);
        };
        $a();
    }

}

(new test())->hello();

/**
 * 输出：
 * string(5) "test1"
 * string(5) "test2"
 * string(5) "test3"
 */

namespace case5;

function returnClosure($a)
{
    $pre = 'pre';
    return function ($p) use ($a, $pre) {
        echo $pre . ' ' . $p . ' ' . $a . PHP_EOL;
    };
}

$a = returnClosure('php');
$a('hello');

function takeClosure($p){
    $pre = 'take-pre';
    $a = returnClosure($p);
    $a('take-hello');
}
takeClosure('php');

/**
 * returnClosure函数中的匿名函数继承的变量$a和$pre；
 * 分别是函数returnClosure的参数$a和函数returnClosure中的变量$pre；
 * $a可以直接继承调用地方的参数，但是$pre只能继承returnClosure中的变量$pre值；
 * 其实$a也是只能继承函数returnClosure中的变量$a，不过$a是函数的参数，可以通过调用的地方再传递而已；
 * 所以，匿名函数的变量继承的父作用域是定义匿名函数的函数(定义匿名函数的地方不一定是函数)；
 * 输出：
 * pre hello php
 * pre take-hello php
 */

namespace case6;

class Test
{
    public function testing()
    {
        return function() {
            var_dump($this);
        };
    }
}

$object = new Test;
$function = $object->testing();
$function();

/**
 * 类中的闭包函数使用$this，自动绑定生效；
 * 输出：
 * class Test#1 (0) {
 * }
 */

class Test2
{
    public $name = 'php';

    public function hello(){
        echo 'hello ' . $this->name;
    }

    public function testing()
    {
        return function() {
            $this->hello();
        };
    }
}

$object = new Test2;
$function = $object->testing();
$function();

/**
 * 闭包函数中可以使用$this中的所有属性和方法；
 * 输出：
 * hello php
 */

namespace case7;

$func = static function($a) {
    static $t;
    $t += $a;
    return $t;
};

var_dump($func(1));
var_dump($func(2));
var_dump($func(3));

/**
 * 输出：
 * int(1)
 * int(3)
 * int(6)
 */

namespace case8;

$func = function(){
    echo 'hello php';
};

var_dump($func);

/**
 * 输出：
 * class Closure#1 (0) {
 * }
 */

#$func = new \Closure();

#var_dump($func);

/**
 * 类Closure不允许被实例化，仅仅只能通过创建一个闭包函数来创建；
 * Closure类的构造函数是private，不允许调用；
 * 输出：
 * PHP Fatal error:  Uncaught Error: Instantiation of 'Closure' is not allowed ...
 */

namespace case9;

class A {
    function __construct($val) {
        $this->val = $val;
    }
    function getClosure() {
        //returns closure bound to this object and scope
        return function() { return $this->val; };
    }
}

$ob1 = new A(1);
$ob2 = new A(2);

$cl = $ob1->getClosure();
echo $cl(), "\n";
$cl = $cl->bindTo($ob2);
echo $cl(), "\n";

/**
 * 输出：
 * 1
 * 2
 */

class B {
    function __construct($val) {
        $this->val = $val;
    }
    function getClosure() {
        //returns closure bound to this object and scope
        return function() { return $this->val; };
    }
}

class C{
    public $val = 100;
}

$ob1 = new B(1);
$ob2 = new C();

$cl = $ob1->getClosure();
echo $cl(), "\n";
$cl = $cl->bindTo($ob2);
echo $cl(), "\n";

/**
 * C类没有获取闭包函数，将B类中获得的闭包函数重新绑定到$ob2，可以使用C类中的属性$val。
 * 但是C类中必须要有闭包函数中要用到的$this的属性和方法，否则会报错。
 * 输出：
 * 1
 * 100
 */

class B1 {
    function __construct($val) {
        $this->val = $val;
    }
    function getClosure() {
        //returns closure bound to this object and scope
        return function() { return $this->val; };
    }
}

class C1{
    private $val = 100;
}


$ob1 = new B1(1);
$ob2 = new C1();

$cl = $ob1->getClosure();
echo $cl(), "\n";
// 不使用bindTo的第二个参数newscope，会报错，因为C1的属性是私有属性，不能被闭包函数调用；
// bindTo函数的第二个参数newscope的官网解释：关联到匿名函数的类作用域，或者 'static' 保持当前状态。如果是一个对象，则使用这个对象的类型为心得类作用域。 这会决定绑定的对象的 保护、私有成员 方法的可见性。“类作用域”代表一个类型、决定在这个匿名函数中能够调用哪些 私有 和 保护 的方法。 也就是说，此时 $this 可以调用的方法，与 newscope 类的成员函数是相同的。
#$cl = $cl->bindTo($ob2);
// $cl = $cl->bindTo($ob2, 'C1'); 等同于下一行的用法
$cl = $cl->bindTo($ob2, $ob2);
echo $cl(), "\n";

/**
 * bindTo函数的第二个参数newscope的作用是，让闭包函数可以访问不能访问的private和protect方法和属性。
 * newscope 可以写类名或者类的实例对象，然后闭包函数的访问权限就和类中的方法一样，可以直接访问类的private和protected方法
 * 输出：
 * 1
 * 100
 */

class SA
{
    static private $val = 1;
    static function val(){
        return self::$val;
    }
}

$fun = static function(){
    return self::val();
};

$a = new SA();

$fun1 = $fun->bindTo(null, 'A');
echo $fun1() . PHP_EOL;
$fun2 = $fun->bindTo(null, $a);
echo $fun2() . PHP_EOL;
// 未设定作用域，报错，不能调用private属性$val
#$fun3 = $fun->bindTo(null);
#echo $fun3() . PHP_EOL;

/**
 * 静态闭包不能有绑定的对象（ newthis 参数的值应该设为 NULL）不过仍然可以用 bubdTo 方法来改变它们的类作用域。
 * 输出：
 * 1
 * 1
 */

namespace case10;

class A {
    private static $sfoo = 1;
    private $ifoo = 2;
}
$cl1 = static function() {
    return A::$sfoo;
};
$cl2 = function() {
    return $this->ifoo;
};

$bcl1 = \Closure::bind($cl1, null, 'A');
$bcl2 = \Closure::bind($cl2, new A(), 'A');
echo $bcl1(), "\n";
echo $bcl2(), "\n";

/**
 * 输出：
 * 1
 * 2
 */
