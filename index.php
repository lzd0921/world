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

//var_export(insertSort($arr));

//一群猴子排成一圈，按1，2，…，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，
//再数到第m只，在把它踢出去…，如此不停 的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
//要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。

function monkeyKing($num, $offset) {

    $monkey = range(1, $num);//生猴子

    $baseNum = 1;

    while (count($monkey) > 1) {    //循环到最后留下的就是大王
        foreach ($monkey as $key => $value) {
            if($baseNum == $offset) {
                unset($monkey[$key]);
                $baseNum = 1;
            } else {
                $baseNum ++;
            }
        }
    }
    var_export(array_values($monkey));
}
monkeyKing(10,9);

//写一个函数得到header头信息

function getHeader() {
    $headers = [];
    if (!function_exists('getallheaders')) {
        $headers = getallheaders();
    } elseif (!function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
    } else {
        foreach ($_SERVER as $key => $value) {
            if(strstr($key, 'HTTP_')) {
                $newKey = ucwords(strtolower(str_replace('_', '-', substr($key, 5))));
                $headers[$newKey] = $value;
            }
        }

    }
    var_export($headers);
}

//getHeader();

//写一个函数，尽可能高效的从一个标准url中取出扩展名:'http://www.sina.com.cn/abc/de/fg.php?id=1'
$url = 'http://www.sina.com.cn/lzd/0921/index.php?id=1';
function getUrl($url) {
    $urlInfo = parse_url($url);
    //var_export($urlInfo);
    //echo substr($url, strrpos($url, '.'), 4);
    //echo strrchr($url, '.');
    var_export( pathinfo($urlInfo['path'])['extension']);
}
//getUrl($url);

//写一个函数，可以遍历文件夹下的所有文件和文件夹
$dir= "D:\\web\\php7";
function getDirFileInfo($dir) {
    $handle = opendir($dir);
    while (false !== ($file = readdir($handle))) { //列出当前目录的所有文件并去掉 . 和 ..
        if ($file == "." || $file == "..") {
           continue;
        }
        $newDir = $dir . DIRECTORY_SEPARATOR . $file;   //得到路径下面的文件夹
        if(is_dir($newDir)) {
            echo "<br>目录：".$newDir . '<br>';
            getDirFileInfo($newDir);
        } else {
            echo "文件：".$dir. DIRECTORY_SEPARATOR .$file .'<br>';
        }
    }
    closedir($handle);
}
getDirFileInfo($dir);

//引用运算符测试
function swap(&$x, &$y) {   //形参前的"&"符号不是指针运算符，而是引用
    $temp = $x;
    $x = $y;
    $y = $temp;
    echo $x.'<->'.$y;
}
$x = 1; $y = 2;
swap($x,$y);
echo $x,$y;

//写一个函数来解决多线程同时读写同一个文件的问题
function fileLimit($file) {
    $handle = fopen($file, 'w+');
    if (flock($handle, LOCK_EX)) {          //LOCK_EX 取得独占锁定(写入的程序) [ 进行排它型锁定]
        ftruncate($handle, 0);               //  将文件截断到给定的长度
        fwrite($handle, "Write something here\n");
        fflush($handle);                     // 强制将所有缓冲的输出写入 handle 文件句柄所指向的资源[在释放锁定之前刷新输出]
        flock($handle, LOCK_UN);            // 释放锁定
    } else {
        echo "Couldn't get the lock!";
    }
    fclose($handle);
}
fileLimit("D://web/file.txt");

//求俩个文件的相对路径
function getPath($path1, $path2) {
    $_A = explode('/', ltrim($path1, '/')); //去除左边‘/’并且切割字符串
    $_B = explode('/', ltrim($path2, '/'));
    $count = 0; //获取相同路径部分的个数
    $baseMin = min(count($_A), count($_B)); //以最短的路径做为基准

    for ($i = 0; $i < $baseMin; $i++) {
        if ($_A[$i] == $_B[$i]) {
            unset($_A[$i]);
            $count++;
        } else {
            break;
        }
    }
    $path = str_repeat('../', count($_B) - $count - 1) . implode('/', $_A); //总数 - 相同路径数 - 文件数 = ‘所需../’数
    return $path;
}

getPath('/a/b/d/12/34/c.php', '/a/b/u/6/7/e.php');