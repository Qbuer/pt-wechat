<?php
/**
 * 一个简单的数据库查询类
 * @author  : qbuer
 * 
 *
*/
 class conn{
 	public $conn;
 	public function conn(){
 		global $mysql;
 		$server=$mysql['server'];
 		$user = $mysql['user'];
 		$password = $mysql['password'];
 		$db = $mysql['db'];
 		$con=mysqli_connect($server,$user,$password,$db) or die('can not connect');
 		$this->conn=$con;
 		$this->query('SET NAMES UTF8');
 		$this->query('USE '.$db);
 		return $con;
 	}
 	public function disconn(){
	 	return mysqli_close($this->conn);	
 	}
 	public function mres($key){
 		return mysqli_real_escape_string($this->conn,$key);//卧槽,不能对整个sql 语句转义啊!卧槽!
 	}
 	public function query($sql){
 		$pos=stripos($sql,'select');
 		if( is_numeric($pos) ){//是select 语句 
 			$rs=mysqli_query($this->conn,$sql);
 			if(mysqli_errno($this->conn)){
 				die('you have an error '.mysqli_error($this->conn));
 			}
 			if($rs===false) return mysqli_affected_rows($this->conn);//什么时候返回是false呢...哦子查询是select
 			$columns=array();
			while ($property = @mysqli_fetch_field($rs)){
  				$columns[]=$property->name;
  			}
 			$arr=array();
 			while($result=@mysqli_fetch_row($rs)){
 				$arr[]=array_combine($columns,$result);
 			}
 			return $arr;
 		}
 		else{
 			mysqli_query($this->conn,$sql);
 			if(mysqli_errno($this->conn)){
 				die('you have an error '.mysqli_error($this->conn));
 			}
 			return mysqli_affected_rows($this->conn);
 		}
 	}
 	public function getlastid(){
 		return  mysqli_insert_id($this->conn);
 	}
 	public function disconnect(){
 		mysqli_close($this->conn);
 		return true;
 	}

 }
