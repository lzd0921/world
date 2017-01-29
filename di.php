<?php
header("Content-Type:text/html;charset=utf8");
class Di implements \ArrayAccess {
    private $_bindings = array();//服务列表
    private $_instances = array();//已经实例化的服务
    
    //获取服务
    public function get($name,$params=array()){
        //先从已经实例化的列表中查找
        if(isset($this->_instances[$name])){
            return $this->_instances[$name];
        }
        
        //检测有没有注册该服务
        if(!isset($this->_bindings[$name])){
            return null;
        }
        
        $concrete = $this->_bindings[$name]['class'];//对象具体注册内容
        
        $obj = null;
        //匿名函数方式
        if($concrete instanceof \Closure){
            $obj = call_user_func_array($concrete,$params);
        }
        //字符串方式
        elseif(is_string($concrete)){
            if(empty($params)){
                $obj = new $concrete;
            }else{
                //带参数的类实例化，使用反射
                $class = new \ReflectionClass($concrete);
                $obj = $class->newInstanceArgs($params);
            }
        }
        //如果是共享服务，则写入_instances列表，下次直接取回
        if($this->_bindings[$name]['shared'] == true && $obj){
            $this->_instances[$name] = $obj;
        }
        
        return $obj;
    }
    
    //检测是否已经绑定
    public function has($name){
        return isset($this->_bindings[$name]) or isset($this->_instances[$name]);
    }
    
    //卸载服务
    public function remove($name){
        unset($this->_bindings[$name],$this->_instances[$name]);
    }
    
    //设置服务
    public function set($name,$class){
        $this->_registerService($name, $class);
    }
    
    //设置共享服务
    public function setShared($name,$class){
        $this->_registerService($name, $class, true);
    }
    
    //注册服务
    private function _registerService($name,$class,$shared=false){
        $this->remove($name);
        if(!($class instanceof \Closure) && is_object($class)){
            $this->_instances[$name] = $class;
        }else{
            $this->_bindings[$name] = array("class"=>$class,"shared"=>$shared);
        }
    }
    
    //ArrayAccess接口,检测服务是否存在
    public function offsetExists($offset) {
        return $this->has($offset);
    }
    
    //ArrayAccess接口,以$di[$name]方式获取服务
    public function offsetGet($offset) {
        return $this->get($offset);
    }
    
    //ArrayAccess接口,以$di[$name]=$value方式注册服务，非共享
    public function offsetSet($offset, $value) {
        return $this->set($offset,$value);
    }
    
    //ArrayAccess接口,以unset($di[$name])方式卸载服务
    public function offsetUnset($offset) {
        return $this->remove($offset);
    }
}


class A{
    public $name;
    public $age;
    public function __construct($name=""){
        $this->name = $name;
    }
}

include "Di.class.php";
$di = new Di();
//匿名函数方式注册一个名为a1的服务
$di->setShared('a1',function($name=""){
    return new A($name);
});
//直接以类名方式注册
$di->set('a2','A');
//直接传入实例化的对象
$di->set('a3',new A("小唐"));

$a1 = $di->get('a1',array("小李"));
echo $a1->name."<br/>";//小李
$a1_1 = $di->get('a1',array("小王"));
echo $a1->name."<br/>";//小李
echo $a1_1->name."<br/>";//小李

$a2 = $di->get('a2',array("小张"));
echo $a2->name."<br/>";//小张
$a2_1 = $di->get('a2',array("小徐"));
echo $a2->name."<br/>";//小张
echo $a2_1->name."<br/>";//小徐

$a3 = $di['a3'];//可以直接通过数组方式获取服务对象
echo $a3->name."<br/>";//小唐



//文档地址：https://my.oschina.net/cxz001/blog/227482