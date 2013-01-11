<?php

class User{
	
	var $id;
	var $name;
	var $screen_name;
	var $followers_count;
	var $friends_count;
	var $statuses_count;
	var $location;
	var $profile_image_url;

}

class User_dao{

	function __construct(){	}

	function deleteAll(){
		
		$sql = "TRUNCATE TABLE user"; 
		$query=mysql_query($sql);
		
	}
	
	function add(User $user){
		$sql="insert 
		into 
		user
		values(
		'$user->id',
		'$user->name',
		'$user->screen_name',
		'$user->followers_count', 
		'$user->friends_count', 
		'$user->statuses_count',
		'$user->location',
		'$user->profile_image_url')
		";
		$query=mysql_query($sql);
		//echo $user->id;
	}
	
	function getAll(){
		$sql="
		select *
		from
		user
		";
		
		//$user = false;
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$user = new User();
				
				$user->id = $row['id'];
				$user->name = $row['name'];
				$user->screen_name = $row['screen_name'];
				$user->followers_count = $row['followers_count']; 
				$user->friends_count = $row['friends_count']; 
				$user->statuses_count = $row['statuses_count'];
				$user->location = $row['location'];
				$user->profile_image_url = $row['profile_image_url'];
				
			}
		}	
		return $user;
	}
	
}