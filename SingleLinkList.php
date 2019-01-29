<?php
//LeetCode原定义节点类
class ListNode 
{
    public $val = 0;
    public $next = null;
    function __construct($val){
        $this->val = $val;
    }
}

//单链表测试用例
class SingleLinkList{
    public $head;
    /**
     * 初始化头结点
     */
    public function __construct(){
        $this->head = new ListNode(null);
    }
    /**
     * 统计链表长度
     */
    public function count(){
        $count = 0;
        $node = $this->head;
        while (!is_null($node->next)) {
            $count++;
            $node = $node->next;
        }
        return $count;
    }
    /**
     * 单链表节点从1开始算起
     * [单链表节点插入]
     * @param  [type] $val [插入的值，可以是一个数组]
     * @param  [type] $num 插入在第几个节点后[默认尾节点]
     */
    public function insert($val,$num = null){
        $val = (array)$val;
        $node = $this->head;
        if($num === null){
            //尾节点插入
            while ($node->next != null) {
                $node = $node->next;
            }
            foreach ($val as $v) {
                $newNode = new ListNode($v);
                $node->next = $newNode;
                $node = $node->next;
            }
        }else{
            if($num > $this->count() || $num <= 0){
                echo '插入失败';
                return false;
            }
            for($i = 0;$i<$num-1;++$i){
                $node = $node->next;
            }
            //下一个节点
            $nextNode = $node->next;
            foreach ($val as $v) {
                $newNode = new ListNode($v);
                $node->next = $newNode;
                $node = $node->next;
            }
            $node->next = $nextNode;
        }
        return true;
    }
    /**
     * 单链表节点从1开始算起
     * [单链表节点更新]
     * @param  [type] $val [更新的值，可以是一个数组]
     * @param  [type] $num [更新第几个节点，可以是一个数组]
     */
    public function update($val,$num){
        $val = (array)$val;
        $num = (array)$num;
        $lenv = count($val);
        $lenn = count($num);
        if($lenv != $lenn){
            echo '<br>两个参数长度必须一致！<br>';
            return false;
        }
        //构建键值对
        $kv = [];
        for($i = 0;$i<$lenv;++$i){
            if(!is_numeric($num[$i])) return false;
            $kv[$num[$i]] = $val[$i];
        }
        //遍历链表找节点
        $success = 0; //交换成功次数
        $count = 0;   //计数
        $node = $this->head;
        while ($node->next !== null) {
            $count++;
            $node = $node->next;
            if(isset($kv[$count])){
                $node->val = $kv[$count];
                unset($kv[$count]);
                $success++;
                if($success == $lenv) return true;
            }
        }
        foreach ($kv as $key => $value) {
            echo $key,'号节点',$value,'插入失败<br>';
        }
        return $count;
    }
    /**
     * 单链表节点从1开始算起
     * [单链表节点删除]
     * @param  [type] $num 删除第几个节点，默认最后一个节点
     */
    public function delete($num){
        if($num > $this->count() || $num <= 0) return false;
        $node = $this->head;
        //找到删除节点的上一个节点
        for($i = 0;$i<$num-1;++$i){
            $node = $node->next;
        }
        $node->next = $node->next->next;
        return true;
    }
    /**
     * 单链表展示
     */
    public function show(){
        echo 'head -> ';
        $node = $this->head;
        while ($node->next !== null) {
            $node = $node->next;
            echo $node->val,' -> ';
        }
        echo 'end';
    }
    /**
     * 单链表节点从1开始算起
     * [展示指定位置的节点]
     */
    public function showSingle($num){
        if($num > $this->count() || $num <= 0) return false;
        $node = $this->head;
        for($i=0;$i<$num;++$i){
            $node = $node->next;
        }
        return $node->val;
    }
}
$p = new SingleLinkList();
/*********  测试Insert  *************/
echo '********　　　测试Insert　　　********<br>';
$p->insert('d');                    //测试尾部插入单值
$p->insert(['g','i','j','k','l']);  //测试尾部插入数组
$p->insert('h',3);                  //测试指定位置插入单值
$p->insert('c',1);                  //测试头节点插入单值
$p->insert(['e','f'],3);            //测试指定位置插入数组
$p->insert(['a','b'],1);            //测试头节点插入数组
//head -> a -> b -> c -> d -> e -> f -> g -> h -> i -> j -> k -> l -> end
$p->show();
/*********  测试Count  *************/
echo '<hr>********　　　测试Count　　　********<br>';
echo '总长度:',$p->count();
/*********  测试Update  *************/
echo '<hr>********　　　测试Update　　　********<br>';
$p->update('3',3);                  //测试更新单值
$p->update(['1','2'],[1,2]);        //测试更新数组
$p->update('13',13);                //测试更新溢出单值
$p->update(['4','13'],[4,13]);      //测试更新溢出链表长度数组
$p->show();
/*********  测试Delete  *************/
echo '<hr>********　　　测试Delete　　　********<br>';
$p->delete(12);
$p->delete(1);
$p->show();
/*********  测试showSingle  *************/
echo '<hr>********　　　测试showSingle　　　********<br>';
echo $p->showSingle(1);
echo $p->showSingle(5);
