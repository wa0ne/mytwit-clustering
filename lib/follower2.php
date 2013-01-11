<?php

class Follower2{
	
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

class Follower2_dao{

	function __construct(){	}
	
	//hapus data follower2
	function deleteAll(){
		
		$sql = "TRUNCATE TABLE follower2"; 
		$query=mysql_query($sql);
		
	}
	
	//insert data follower2
	function add(Follower2 $follower){
		$sql="insert 
		into 
		follower2
		values(
		'$follower->id',
		'$follower->id2',
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
		follower2
		";
		
		$list_following = array();
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Follower2();
				
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
	
	//mendapatkan follower2 berdasarkan id
	function getById($id){
		$sql="
		select *
		from
		follower2
		where id = '$id'
		";
		
		
		$list_following = array();
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Follower2();
				
				$following->id = $row['id'];
				$following->id2 = $row['id2'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				$list_following[]=$following;
				
			}
		}	
		return $list_following;
	}
	
}