<?php

class Following2{
	
	var $id;
	var $id2;
	var $name;
	var $screen_name;
	var $followers_count;
	var $friends_count;
	var $statuses_count;
	var $location;
	var $profile_image_url;

}

class Following2_dao{

	function __construct(){	}
	
	//delete data following2
	function deleteAll(){
		
		$sql = "TRUNCATE TABLE following2"; 
		$query=mysql_query($sql);
		
	}
	
	//insert data following
	function add(Following2 $following){
		$sql="insert 
		into 
		following2
		values(
		'$following->id',
		'$following->id2',
		'$following->name',
		'$following->screen_name',
		'$following->followers_count', 
		'$following->friends_count', 
		'$following->statuses_count',
		'$following->location',
		'$following->profile_image_url')
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
		
	//mendapatkan seluruh data user berupa array 
	function getAll(){
		$sql="
		select *
		from
		following2
		";
		
		$list_following = array();
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Following2();
				
				$following->id = $row['id'];
				$following->id2 = $row['id2'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				
				$list_following[] = $following;
			}
		}	
		return $list_following;
	}
	
	//get following2 berdasarkan id
	function getById($id){
		$sql="
		select *
		from
		following2
		where id = '$id'
		";
		
		
		$list_following = array();
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Following2();
				
				$following->id = $row['id'];
				$following->id2 = $row['id2'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				$list_following[] = $following; 
				
				
			}
		}	
		return $list_following;
	}
	
}