<?php
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------
// | classes and objects >> class abstraction
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2016-07-20 15:52:46
// +----------------------------------------------------------------------
// | Copyright: Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * case1：抽象类不能被实例化
 * case2：抽象类可以不包含抽象方法，但是如果类中有一个抽象方法，那么这个类必须声明为抽象类
 * case3：继承一个抽象类的时候，必须定义抽象类中的所有抽象方法，可见性相同或更为宽松
 * case4：抽象方法被子类定义时，方法的调用方式必须匹配，即类型(可选必选)和所需参数数量必须一致
 * case5：抽象方法被子类定义时，抽象方法的所有参数必须定义，子类可以多定义可选参数
 */

namespace case1;
abstract class abstractClass{
    abstract public function hello();
}
// 实例化抽象类会产生一个Fatal error
# $o = new abstractClass();

namespace case2;
abstract class abstractClass1{
    public function hello(){}
}
// 含有抽象方法的类没有声明为抽象类，会产生一个Fatal error
# class abstractClass2{
#     abstract function hello();
# }

namespace case3;
abstract class abstractClass{
    abstract public function hello();
    abstract public function say();
    abstract protected function world();
}
// 没有完全声明父类中的抽象方法会产生一个Fatal error
# class classes1 extends abstractClass{
#     public function hello(){}
# }
// 下面将protected world定义为private world会产生一个Fatal error
# class classes2 extends abstractClass{
#     public function hello(){}
#     public function say(){}
#     private function world(){}
# }

namespace case4;
abstract class abstractClass{
    abstract public function hello($name);
}
class classes extends abstractClass{
    // 子类没有定义抽象方法的参数，会产生一个Fatal error
    # public function hello(){}
    // 子类定义抽象方法的参数与抽象方法不一致，会产生一个Fatal error
    # public function hello($name, $e){}
    // 子类多定义一个可选参数，声明与抽象方法没有冲突
    public function hello($name, $e=''){}
}

namespace case5;
abstract class abstractClass{
    abstract public function hello($name, $e='', $f='');
}
class classes extends abstractClass{
    // 子类没有定义抽象方法的可选参数$f，会产生一个Fatal error
    # public function hello($name, $e=''){}
    // 子类定义抽象方法的参数类型不一样，会产生一个Fatal error
    # public function hello($name, $e='', $f){}
    public function hello($name, $e='', $f='', $g=''){}
}



