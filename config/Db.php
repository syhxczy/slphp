<?php
// 连接数据库类
class Db
{
	private $options = array(
		'from' => '',
		'where' => '',
		'order' => '',
		'limit' => '' 
		);
	
	function __construct()
	{
		$this->conn = mysqli_connect('localhost', 'root', 'qazwsx', 'test');
		if (mysqli_connect_error($this->conn)) {
			echo mysqli_connect_error();
		} else {
			return $this;
		}
		
	}

	function from($key)
	{
		$this->options[from] = empty($key) ? null : 'FROM '.$key ;
		return $this;
	}

	function where($key)
	{
		$this->options[where] = empty($key) ? null : 'WHERE '.$key ;
		return $this;
	}

	function order($key)
	{
		$this->options[order] = empty($key) ? null : 'ORDDER BY '.$key ;
		return $this;
	}

	function limit($key)
	{
		$this->options[limit] = empty($key) ? null : 'LIMIT '.$key ;
		return $this;
	}

	function select()
	{
		$sql = "SELECT * ".$this->options[from];
		$n = mysqli_query($this->conn, $sql);
		if ($n) {
			$this->query =$n;
			while ($row = mysqli_fetch_array($n,MYSQLI_ASSOC)) {
				$arr[] = $row;
			}
			return $arr;
		} else {
			mysqli_free_result($n);
			return false;
		}	
	}

	function update($table,$arr)
	{
		if (!is_array($arr)) die('不是数组');
		foreach ($arr as $key => $value) {
			$arr1[] = $key.'='.$value;
		}
		$val = implode(',',$arr1);
		$sql = "UPDATE $table SET ($val) ".$this->options[where];
		$res = mysqli_query($this->conn,$sql);
		return $res;
	}

	function del($table)
	{
		$sql = "DELETE FROM $table ".$this->options[where];
		$res = mysqli_query($this->conn,$sql);
		return $res;
	}

    function insert($table,$arr)
    {
    	if (!is_array($arr)) die('不是数组');
    	foreach ($arr as $key => $value) {
    		$arr1[] = $key;
    		$arr2[] = $value; 
    	}
    	$val1 = implode(',',$arr1);
    	$val2 = implode(',',$arr2);
    	$sql = "INSERT INTO $table ($val1) VALUES ($val2)";
    	$res = mysqli_query($this->conn,$sql);
		return $res;
    }


}