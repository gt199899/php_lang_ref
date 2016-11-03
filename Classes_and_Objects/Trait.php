<?php
// +----------------------------------------------------------------------
// | php lang ref
// +----------------------------------------------------------------------
// | classes and objects >> trait
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2016-07-19 09:10:52
// +----------------------------------------------------------------------
// | Copyright: Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * case1：php版本5.4.0以上trait才会起作用
 * case2：trait无法实例化
 * case3：trait的优先级，当前类的成员覆盖trait的成员，trait的成员覆盖类继承的类的成员
 * case4：通过逗号分隔，在use声明列出多个trait，可以都插入到一个类中
 * case5：冲突的解决，一个类声明了多个trait，而多个trait里面有同名方法则会产生冲突
 * case6：使用as来调整方法的访问控制
 * case7：使用trait来组成trait
 * case8：trait的抽象成员
 * case9：trait的静态成员
 * case10：trait定义属性
 */


namespace case1;
version_compare(phpversion(),'5.4.0') >= 0 or exit('php version < 5.4.0, trait does not work.');

namespace case2;
trait traits {
    public function fun(){
        echo "come on";
    }
}
// 手册讲trait与class相似，但是trait并不是class。实例化trait，会产生一个Fatal error
# $trait = new traits();

namespace case3;
// trait优先级
trait traits{
    public function hello(){
        echo 'trait say hello world';
    }
}
class base{
    public function hello(){
        echo 'base say hello world';
    }
}
class son extends base{
    use traits;
    public function hello(){
        echo 'son say hello world';
    }
}
// $class = new son();
// $class->hello();

namespace case4;
// 多个trait
trait trait1{
    public function hello1(){
        echo 'trait1 say hello';
    }
}
trait trait2{
    public function hello2(){
        echo 'trait2 say hello';
    }
}
trait trait3{
    public function hello3(){
        echo 'trait3 say hello';
    }
}
class classes{
    use trait1, trait2, trait3;
}
// $classes = new classes();
// $classes->hello1();
// $classes->hello2();
// $classes->hello3();

namespace case5;
trait trait1{
    public function hello(){
        echo 'trait1 say hello';
    }
}
trait trait2{
    public function hello(){
        echo 'trait2 say hello';
    }
}
trait trait3{
    public function hello(){
        echo 'trait3 say hello';
    }
}
// 如果多个trait中含有一个同名的方法，产生一个Fatal error
# class classes{
#     use trait1, trait2, trait3;
# }
// 使用 insteadof 操作符来明确指定使用冲突方法中的哪一个，trait中方法名有冲突的时候，必须使用insteadof消除冲突
class classes1{
    use trait1, trait2{
        trait1::hello insteadof trait2;
    }
}
// $classes = new classes1();
// $classes->hello();
class classes2{
    use trait1, trait2, trait3{
        trait2::hello insteadof trait1;
        trait3::hello insteadof trait2;
    }
}
// $classes = new classes2();
// $classes->hello();
// 使用insteadof指明使用哪一个trait的方法之后，可以使用as来定义别名使用trait方法
class classes3{
    use trait1, trait2, trait3{
        trait2::hello insteadof trait1;
        trait3::hello insteadof trait2;
        trait1::hello as hello1;
        trait2::hello as hello2;
        trait3::hello as hello3;
    }
}
// $classes = new classes3();
// $classes->hello1();
// $classes->hello2();
// $classes->hello();
// $classes->hello3();

namespace case6;
trait traits{
    public function hello(){
        echo 'say hello';
    }
}
class classes1{
    use traits {hello as protected;}
}
class classes2 extends classes1{
    public function sayhello(){
        $this->hello();
    }
}
$classes = new classes2();
// classes1中hello方法已经被as定义为protected,classes2实例调用hello方法产生一个Fatal error
# $classes->hello();

namespace case7;
trait trait1{
    public function hello(){
        echo "hello1";
    }
}
trait trait2{
    public function hello(){
        echo "hello2";
    }
}
// trait1和trait2组成traits
trait traits{
    use trait1,trait2{
        trait1::hello insteadof trait2;
        trait1::hello as hello1;
        trait2::hello as hello2;
        trait2::hello as hello3;
    }
}
class classes{
    use traits;
}
// $classes = new classes();
// $classes->hello();
// $classes->hello1();
// $classes->hello2();
// $classes->hello3();

namespace case8;
trait traits{
    abstract public function hello();
}
// trait的抽象方法必须被定义
class classes{
    use traits;
    public function hello(){
        echo "hello";
    }
}
// $classes = new classes();
// $classes->hello();

namespace case9;
// if a trait has static properties, each class using that trait has independent instances of those properties.
// 如果trait有静态成员，每一个类使用trait，就像类被实例化一样，trait中的静态成员变为这个类独有的
// The best way to understand what traits are and how to use them is to look at them for what they essentially are:  language assisted copy and paste.
// If you can copy and paste the code from one class to another (and we've all done this, even though we try not to because its code duplication) then you have a candidate for a trait.
// 如果你多个类中有公用的方法，而这些类不能extends同一个基类，那么最好使用trait
trait traits{
    static public $int = 0;
    static public function hello(){
        echo "hello this is a static method";
    }
    public function hello1(){
        static $int = 0;
        echo ++$int;
    }
}
class classes{
    use traits;
}
class classes1{
    use traits;
}
class classes2{
    use traits;
}
// classes::hello();
// classes1::$int++;
// classes2::$int++;
// classes2::$int++;
// echo classes1::$int;
// echo classes2::$int;
// $classes1 = new classes1();
// $classes2 = new classes2();
// $classes1->hello1();
// $classes1->hello1();
// $classes2->hello1();

namespace case10;
// 如果 trait 定义了一个属性，那类将不能定义同样名称的属性，否则会产生一个Fatal error。
// 如果该属性在类中的定义与在 trait 中的定义兼容（同样的可见性和初始值）则错误的级别是 E_STRICT，否则是一个Fatal error。
trait traits{
    public $name = 'trait';
}
class classes{
    use traits;
    public $name = 'trait';
}
