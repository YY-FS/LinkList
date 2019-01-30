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
     * 根据LeetCode的要求，head指针非空，必须对head赋值
     */
    public function __construct($val = null){
        if (is_null($val)){
            echo '必须设置头节点初始化值！';
            return false;
        }
        $val = (array)$val;
        $this->head = new ListNode($val[0]);
        unset($val[0]);
        if(count($val) > 0)
            $this->insert($val);
    }
    /**
     * 统计链表长度
     */
    public function count(){
        $count = 0;
        $curNode = $this->head;
        while (!is_null($curNode)) {
            $count++;
            $curNode = $curNode->next;
        }
        return $count;
    }
    /**
     * [单链表节点插入]
     * @param  [type] $val [插入的值，可以是一个数组]
     */
    public function insert($val){
        $val = (array)$val;
        $curNode = $this->head;
        //尾节点插入,下一节点为空，即已到尾节点
        while ($curNode->next != null) {
            $curNode = $curNode->next;
        }
        foreach ($val as $v) {
            $newNode = new ListNode($v);
            $curNode->next = $newNode;
            $curNode = $curNode->next;
        }
        return true;
    }
    /**
     * 单链表节点从1开始算起
     * [单链表节点指定位置插入]
     * @param  [type] $val [插入的值，可以是一个数组]
     * @param  [type] $num 插入在第几个节点
     */
    public function insertPos($val,$num = 0){
        if($num > $this->count() || $num <= 0){
            echo '插入失败';
            return false;
        }
        $val = (array)$val;
        //为了处理头节点的特殊性，设置一个虚拟的头节点
        $dummyHead = new ListNode(null);
        $dummyHead->next = $this->head;
        $curNode = $dummyHead;
        for($i = 0;$i<$num-1;++$i){
            $curNode = $curNode->next;
        }
        //下一个节点
        $nextNode = $curNode->next;
        foreach ($val as $v) {
            $newNode = new ListNode($v);
            $curNode->next = $newNode;
            $curNode = $curNode->next;
        }
        $curNode->next = $nextNode;
        //重定义类中head属性
        $this->head = $dummyHead->next;
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
        $curNode = $this->head;
        while ($curNode !== null) {
            $count++;
            if(isset($kv[$count])){
                $curNode->val = $kv[$count];
                unset($kv[$count]);
                $success++;
                if($success == $lenv) return true;
            }
            $curNode = $curNode->next;
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
    public function delete($num = 0){
        if($num > $this->count() || $num <= 0) return false;
        //为了处理头节点的特殊性，设置一个虚拟的头节点
        $dummyHead = new ListNode(null);
        $dummyHead->next = $this->head;
        $curNode = $dummyHead;
        //找到删除节点的上一个节点
        for($i = 0;$i<$num-1;++$i){
            $curNode = $curNode->next;
        }
        $curNode->next = $curNode->next->next;
        $this->head = $dummyHead->next;
        return true;
    }
    /**
     * 单链表展示
     */
    public function show(){
        echo 'head -> ';
        $curNode = $this->head;
        while (!is_null($curNode)) {
            echo $curNode->val,' -> ';
            $curNode = $curNode->next;
        }
        echo 'end';
    }
    /**
     * 单链表节点从1开始算起
     * [展示指定位置的节点]
     */
    public function showSingle($num = 0){
        if($num > $this->count() || $num <= 0) return false;
        $curNode = $this->head;
        for($i=0;$i<$num-1;++$i){
            $curNode = $curNode->next;
        }
        return $curNode->val;
    }
}

$p = new SingleLinkList(['a','b']);

/*********  测试Insert  *************/
echo '********　　　测试Insert　　　********<br>';
$p->insert('c');                      //测试尾部插入单值
$p->insert(['d','e','f','g','h']);    //测试尾部插入数组
$p->insertPos('g',3);                 //测试指定位置插入单值
$p->insertPos('h',1);                 //测试头节点插入单值
$p->insertPos(['i','j'],3);           //测试指定位置插入数组
$p->insertPos(['k','l'],1);           //测试头节点插入数组
$p->show();
/*********  测试Count  *************/
echo '<hr>********　　　测试Count　　　********<br>';
echo '总长度:',$p->count();
/*********  测试Update  *************/
echo '<hr>********　　　测试Update　　　********<br>';
$p->update('3',3);                          //测试更新单值
$p->update(['1','2'],[1,2]);                //测试更新数组
$p->update('15',15);                        //测试更新溢出单值
$p->update(['4','15','16'],[4,15,16]);      //测试更新溢出链表长度数组
$p->show();
/*********  测试Delete  *************/
echo '<hr>********　　　测试Delete　　　********<br>';
$p->delete(14);
$p->delete(1);
$p->show();
/*********  测试showSingle  *************/
echo '<hr>********　　　测试showSingle　　　********<br>';
echo $p->showSingle(1);
echo $p->showSingle(5);
