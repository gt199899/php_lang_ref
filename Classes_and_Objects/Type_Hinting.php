<?php
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------
// | classes and objects >> Type Hinting
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2016-12-31 17:18:05
// +----------------------------------------------------------------------
// | Copyright: Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * case1: 函数的参数可以是对象，接口，数组或者callable
 *
 */

namespace case1;
class demo{
    public $pro = 'this is class demo';
}
class demoo{
    public $pro = 'this is class demoo';
}
function th_class(demo $class){
    echo $class->pro;
}
// $demo = new demo();
// th_class($demo);
// 类型约束为对象时，参数必须是指定的对象，否则会产生一个Fatal error
# $demoo = new demoo();
# th_class($demoo);
interface demoInterface{
    public function hello1();
}
function th_interface(demoInterface $interface){
    $interface->hello1();
}
th_interface(new demoInterface());