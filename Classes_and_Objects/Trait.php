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

namespace defineProperty;

error_reporting(E_ALL);
// PHP版本5.4.0之上trait才起作用
version_compare(phpversion(),'5.4.0') >= 0 or exit('php version < 5.4.0, trait does not work.');


// trait 定义属性
trait traits {
    public $param1 = 'public param';
    protected $param2 = 'protected param';
    private $param3 = 'private param';
    public function showParam(){
        print_r(get_object_vars ($this));
    }
}
class classes {
    use traits;
}

// trait无法实例化，手册讲trait与class相似，但是trait并不是class。
// Fatal error: Cannot instantiate trait traits
# $t = new traits();

$o = new classes();
// trait的访问控制和class相同，但是class并不能继承trait，而是使用use关键字来调用trait，trait里仅public成员可见
// class调用trait里非public成员会报错
# echo $o->param1;
// Fatal error: Cannot access protected property classes::$param2
# echo $o->param2;
// Fatal error: Cannot access private property classes::$param3
# echo $o->param3;
// class访问trait里面的非public成员可使用如下方式
# $o->showParam();

/**
 * trait支持类的访问控制，但是对外仅public可见
 */

// +----------------------------------------------------------------------
// trait与calss属性冲突
namespace definePropertyConflict;
trait traits{
    # public $same = true;
    # public $diff = true;
    # public $same1 = true;
}
class classes{
    use traits;
    # public $same = true;
    # public $diff = false;
    # protected $same1 = true;
}

/**
 * trait和class属性名称相同，值相同，可见性相同。会产生一个Strict Standards
 * trait和class属性名称相同，值不同，可见性相同。会产生一个Fatal error
 * trait和class属性名称相同，值相同，可见性不同。会产生一个Fatal error
 */

// +----------------------------------------------------------------------
// trait优先级
namespace priority;
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
class classes extends base{
    use traits;
    public function hello(){
        echo 'current say hello world';
    }
}
$o = new classes();
# $o->hello();
/**
 * 当前类的方法会覆盖trait的方法
 * trait的方法会覆盖基类中的方法
 */

// +----------------------------------------------------------------------
// 多个trait
namespace multipleTrait;
trait trait1{
    public function hello(){
        echo 'trait1 say hello world';
    }
}
trait trait2{
    public function hello(){
        echo 'trait2 say hello world';
    }
}
trait trait3{
    public function hello(){
        echo 'trait3 say hello world';
    }
}
class classes{
    # use trait1, trait2;
}

$o = new classes();
#$o->hello();
// 多个trait中有同名的方法会产生一个Fatal error

class classes1{
    use trait1, trait2{
        trait1::hello insteadof trait2;
    }
}
$o = new classes1();
# $o->hello();
// 多个trait使用insteadof来指定使用冲突方法里面的哪一个

class classes2{
    use trait1, trait2, trait3{
        trait2::hello insteadof trait1;
        trait3::hello insteadof trait2;
        trait1::hello as hello1;
        trait2::hello as hello2;
        trait3::hello as hello3;
    }
}
$o = new classes2();
# $o->hello();
# $o->hello1();
# $o->hello2();
# $o->hello3();
// 可以使用as关键字给trait方法增加一个别名，使用别名调用

/**
 * 一个类可以use多个trait
 * 多个trait中不能存在同名方法，否则会产生一个Fatal error
 * 解决同名方法的原则：一个类中一个方法名仅能有对应一个方法
 * insteadof 可以确定要使用的trait中的哪一个方法
 * as 可以给未被指定的方法指定一个别名调用(已经使用insteadof指定使用方法也可以设定别名)
 */

// +----------------------------------------------------------------------
// 使用trait组成trait
namespace traitByTrait;
trait trait1{
    public function hello1(){
        echo 'trait1 say hello world';
    }
}
trait trait2{
    public function hello2(){
        echo 'trait2 say hello world';
    }
}
trait traits{
    use trait1,trait2;
}
class classes{
    use traits;
}
$o = new classes();
# $o->hello1();
# $o->hello2();
/**
 * 多个trait组成的trait被类使用之后，类可以直接使用多个trait中的方法
 * 同样一个类中的一个方法名仅能对应一个方法，否则产生一个Fatal error
 */

// +----------------------------------------------------------------------
// trait的抽象成员
namespace traitAbstract;
trait traits{
    abstract public function hello();

}
class classes{
    use traits;
    public function hello(){
        echo 'hello world';
    }
}
$o = new classes();
# echo $o->hello();
/**
 * trait可以像类一样设置抽象方法，使用这个trait的类必须重写这个方法
 * 否则产生一个Fatal error
 */

// +----------------------------------------------------------------------
// trait的静态成员
namespace traitStatic;
trait traits{
    static public $param = 1;
    static public function hello(){
        echo self::$param;
    }
}
class classes{
    use traits;
    public function add(){
        self::$param++;
    }
}
$o = new classes();
# echo $o::$param;
$o->add();
# echo $o::$param;
$c = new classes();
# echo $c::$param;
$c->add();
# echo $c::$param;
$o->add();
# echo $c::$param;
# classes::hello();
/**
 * trait的静态属性和静态方法和类的静态成员一样有效
 */