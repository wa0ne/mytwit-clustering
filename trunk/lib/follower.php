<?php

class Follower{
	
	var $id;
	var $name;
	var $screen_name;
	var $followers_count;
	var $friends_count;
	var $statuses_count;
	var $location;
	var $profile_image_url;

}

class Follower_dao{

	function __construct(){	}

	//hapus data follower
	function deleteAll(){
		
		$sql = "TRUNCATE TABLE follower"; 
		$query=mysql_query($sql);
		
	}
	
	//insert data follower
	function add(Follower $follower){
		$sql="insert 
		into 
		follower
		values(
		'$follower->id',
		'$follower->name',
		'$follower->screen_name',
		'$follower->followers_count', 
		'$follower->friends_count', 
		'$follower->statuses_count',
		'$follower->location',
		'$follower->profile_image_url')
		";
		$query=mysql_query($sql);
		//echo $follower->id;
	}
	
	//mendapatkan seluruh data user berupa array 
	function getAll(){
		$sql="
		select *
		from
		follower
		order by id
		asc
		";
		
		$list_following = array();
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Follower();
				
				$following->id = $row['id'];
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
	
	//mendapatkan follower berdasarkan id
	function getById($id){
		$sql="
		select *
		from
		follower
		where id = '$id'
		";
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Follower();
				
				$following->id = $row['id'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				
				
			}
		}	
		return $following;
	}
	
}