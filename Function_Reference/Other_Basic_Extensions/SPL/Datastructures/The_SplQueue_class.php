<?php
// +----------------------------------------------------------------------
// | Function Reference >> Other Basic Extensions >> SPL >> Datastructures
// +----------------------------------------------------------------------
// | SPL >> 数据结构 >> spl队列
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2017-09-21 16:26
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------

/**
 * SplQueue extends SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
 *  --Methods--
 *      __construct ( void )
 *      mixed dequeue ( void )
 *      void enqueue ( mixed $value )
 *      void setIteratorMode ( int $mode )
 *  --Inherited methods--
 *      public void SplDoublyLinkedList::add ( mixed $index , mixed $newval )
 *      public mixed SplDoublyLinkedList::bottom ( void )
 *      public int SplDoublyLinkedList::count ( void )
 *      public mixed SplDoublyLinkedList::current ( void )
 *      public int SplDoublyLinkedList::getIteratorMode ( void )
 *      public bool SplDoublyLinkedList::isEmpty ( void )
 *      public mixed SplDoublyLinkedList::key ( void )
 *      public void SplDoublyLinkedList::next ( void )
 *      public bool SplDoublyLinkedList::offsetExists ( mixed $index )
 *      public mixed SplDoublyLinkedList::offsetGet ( mixed $index )
 *      public void SplDoublyLinkedList::offsetSet ( mixed $index , mixed $newval )
 *      public void SplDoublyLinkedList::offsetUnset ( mixed $index )
 *      public mixed SplDoublyLinkedList::pop ( void )
 *      public void SplDoublyLinkedList::prev ( void )
 *      public void SplDoublyLinkedList::push ( mixed $value )
 *      public void SplDoublyLinkedList::rewind ( void )
 *      public string SplDoublyLinkedList::serialize ( void )
 *      public void SplDoublyLinkedList::setIteratorMode ( int $mode )
 *      public mixed SplDoublyLinkedList::shift ( void )
 *      public mixed SplDoublyLinkedList::top ( void )
 *      public void SplDoublyLinkedList::unserialize ( string $serialized )
 *      public void SplDoublyLinkedList::unshift ( mixed $value )
 *      public bool SplDoublyLinkedList::valid ( void )
 *  }
 * SplQueue 拥有三个方法，继承自双向链表
 *  dequeue 出队列
 *  enqueue 入队列
 *  setIteratorMode 设置模式，默认：SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_KEEP
 *      SplDoublyLinkedList::IT_MODE_FIFO (Stack style) 先进先出
 *      SplDoublyLinkedList::IT_MODE_LIFO (Queue style) 后进先出
 *      SplDoublyLinkedList::IT_MODE_KEEP (Elements are traversed by the iterator) 遍历保留
 *      SplDoublyLinkedList::IT_MODE_DELETE (Elements are deleted by the iterator) 遍历删除
 *  setIteratorMode 设置模式不能设置为后进先出；
 *
 * 注意：仅仅遍历操作 IT_MODE_KEEP 才生效，非遍历操作（比如pop，dequeue等）是直接从队列中取出一个元素，IT_MODE_KEEP 不生效。
 */

namespace case1;

$obj = new \SplQueue();
for ($i = 1; $i <= 10; $i++) {
    $obj->enqueue($i);
}
echo "队列初始长度 : " . $obj->count() . PHP_EOL;
$obj->rewind();
foreach($obj as $v){
    echo "队列遍历 : " . $v . PHP_EOL;
}
echo "队列遍历后长度 : " . $obj->count();

/**
 * 输出：
 * 队列初始长度 : 10
 * 队列遍历 : 1
 * 队列遍历 : 2
 * 队列遍历 : 3
 * 队列遍历 : 4
 * 队列遍历 : 5
 * 队列遍历 : 6
 * 队列遍历 : 7
 * 队列遍历 : 8
 * 队列遍历 : 9
 * 队列遍历 : 10
 * 队列遍历后长度 : 10
 */

namespace case2;

$obj = new \SplQueue();
$obj->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_DELETE);
for ($i = 1; $i <= 10; $i++) {
    $obj->enqueue($i);
}
echo "队列初始长度 : " . $obj->count() . PHP_EOL;
$obj->rewind();
foreach($obj as $v){
    echo "队列遍历 : " . $v . PHP_EOL;
}
echo "队列遍历后长度 : " . $obj->count();

/**
 * 输出：
 * 队列初始长度 : 10
 * 队列遍历 : 1
 * 队列遍历 : 2
 * 队列遍历 : 3
 * 队列遍历 : 4
 * 队列遍历 : 5
 * 队列遍历 : 6
 * 队列遍历 : 7
 * 队列遍历 : 8
 * 队列遍历 : 9
 * 队列遍历 : 10
 * 队列遍历后长度 : 0
 */