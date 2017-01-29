<?php

$arr = ['7', '6', '3', '5', '4', '2', '1', '9', '-10'];
//冒泡排序【稳定】
	/*function sortArray($arr) {

		$temp  = '';
		$count = count($arr);
		for ($i=0; $i < $count; $i++) {  
			$sum = $i + 1;
			echo "\r--------------------第{$sum}层循环------------------------\r";
			for ($m=$i + 1; $m < $count; $m++) { 

				if ($arr["$i"] > $arr["$m"]) {

					$temp = $arr["$i"];

					$arr["$i"] = $arr["$m"];

					$arr["$m"] = $temp;

				}
				echo "\r---------------第{$m}次排序-----------------\r";
				var_export($arr);
			}
			// var_export($arr);
				
		}
			return $arr;
	
	}*/

	//var_export(sortArray($arr));


//快速排序[不稳定]
  
    function quick_sort($arr)
    {
        //判断参数是否是一个数组
        if(!is_array($arr)) return false;
        //递归出口:数组长度为1，直接返回数组
        $length=count($arr);
        if($length<=1) return $arr;
        //数组元素有多个,则定义两个空数组
        $left=$right=array();
        //使用for循环进行遍历，把第一个元素当做比较的对象
        for($i=1;$i<$length;$i++)
        {
            //判断当前元素的大小
            if($arr[$i]<$arr[0]){
                $left[]=$arr[$i];
            }else{
                $right[]=$arr[$i];
            }
        }
        //递归调用
        $left=quick_sort($left);
        $right=quick_sort($right);
        //将所有的结果合并
        return array_merge($left,array($arr[0]),$right);


        }
        
        //var_export(quick_sort($arr));
       
//插入排序
	function insertSort($arr) {

		$length = count($arr);

		for ($i=1; $i < $length; $i++) { 
			$temp = $arr[$i];
			for ($j=$i-1; $j >= 0; $j--) { 
				if ($temp < $arr[$j]) {
					$arr[$j+1] = $j;
					$arr[$j] = $temp;
				} else {
					break;
				}
			}
		}
		return $arr;
	}

var_export(insertSort($arr));
abstract class a {
	public function a();
}
