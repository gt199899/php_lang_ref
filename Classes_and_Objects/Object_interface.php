<?php
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------
// | class and objects >> object interface
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2016-07-21 09:46:04
// +----------------------------------------------------------------------
// | Copyright: Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * case1：接口中的所有方法都必须是空的
 * case2：接口中的多有方法的可见性都必须是public
 * case3：类实现接口，必须实现接口中的所有方法
 * case4：类实现接口，必须使用和接口中所定义的方法完全一致的方式
 * case5：类可实现多个接口，但是接口中的方法名不能重复。多个接口中的方法定义一致，则可以实现
 * case6：接口可继承接口，并且可同时继承多个接口
 * case7：接口不能拥有属性
 * case8：接口可以拥有常量，但是常量不能被子类或子接口覆盖
 */

namespace case1;
// 接口方法不能包含方法实体，会产生一个Fatal error
interface interfaces{
    #public function hello(){}
}

namespace case2;
interface interfaces{
    public function hello1();
    // 定义非public方法会产生一个Fatal error
    # protected function hello2();
    # private function hello3();
}

namespace case3;
interface interfaces{
    public function hello();
    public function say();
}
// 类实现接口，没有实现接口中的所有方法，会产生一个Fatal error
# class classes implements interfaces{
#     public function hello(){
#         echo "hello world";
#     }
# }

namespace case4;
interface interfaces{
    public function hello1($param1);
    public function hello2($param1);
    public function hello3($param1, $param2='');
    public function hello4($param1, $param2='', $param3='');
    public function hello5(array $param1);
}
/*class classes implements interfaces{
    // 多定义必选参数，会产生一个Fatal error
    public function hello1($param1, $param2){}
    // 多定义可选参数，可运行
    public function hello2($param1, $param2=''){}
    // 少定义必选参数，会产生一个Fatal error
    public function hello3($param1){}
    // 少定义可选参数，会产生一个Fatal error
    public function hello4($param1, $param2=''){}
    // 定义参数类型不同，会产生一个Fatal error
    public function hello5(callback $fun){}
}*/

namespace case5;
interface interfaces1{
    public function hello($a);
}
interface interfaces2{
    public function hello($a, $b);
}
// 类实现方法，无法满足同时匹配interface1和interface2，会产生一个Fatal error
/*class classes1 implements interfaces1, interfaces2{
    public function hello($a, $b){}
}*/

interface interfaces3{
    public function hello();
}
interface interfaces4{
    public function hello();
}
// 类实现多个接口，接口中的方法定义一致，则可运行
class classes2 implements interfaces3, interfaces4{
    public function hello(){}
}

namespace case6;
interface interfaces1{
    public function hello1();
}
interface interfaces2{
    public function hello2();
}
interface interfaces3 extends interfaces1{
    public function hello3();
}
interface interfaces4 extends interfaces1, interfaces2{
    public function hello4();
}
class classes1 implements interfaces3{
    public function hello1(){}
    public function hello3(){}
}
class classes2 implements interfaces4{
    public function hello1(){}
    public function hello2(){}
    public function hello4(){}
}

namespace case7;
// 接口不能定义属性，会产生一个Fatal error
/*interface interfaces{
    public $param;
}*/

namespace case8;
interface interfaces{
    const hello = 'hello world';
}
// 可直接调用接口常量
# echo interfaces::hello;
class classes implements interfaces{
    const hello1 = 'hello world1';
}
// 可通过类调用接口常量
# echo classes::hello1;
# echo classes::hello;
// 类实现接口，覆盖接口常亮，会产生一个Fatal error，哪怕他定义的内容和接口常量定义的内容一样
/*class classes1 implements interfaces{
    const hello = 'hello world';
}*/
