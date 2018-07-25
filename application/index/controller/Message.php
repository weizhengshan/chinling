<?php
namespace app\index\controller;

class Message extends Common
{
	//留言填写页
    public function index()
    {
        return $this->fetch();
    }
    //留言提交方法
    public function incubator()
    {
    	return $this->fetch();
    }    
}
