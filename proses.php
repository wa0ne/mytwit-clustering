<?php

session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config/config.php');
require_once('config/db.php');
require_once('lib/user.php');
require_once('lib/follower.php');
require_once('lib/following.php');
require_once('lib/follower2.php');
require_once('lib/following2.php');


if(!isset($_POST['nama'])){
	header("Location:index.php");
}
if(isset($_POST['nama'])){
	
	$db = new db();

	//echo "oke";

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET); //koneksi ke twitter API

    /* If method is set change API call made. Test is called by default. */
	//$content = $connection->get('account/rate_limit_status');
	//echo "Current API hits remaining: {$content->remaining_hits}.";
	
	$name=$_POST['nama'];
	$trends_url = "http://api.twitter.com/1/users/show.json?screen_name=$name";   //mendapatkan data user yang telah diinput 
	//$trends_url2= "http://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$name";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $trends_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$curlout = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($curlout, true);	
	//var_dump($response);
	//echo count($responser);
	if(count($response)<=2){
		echo "<script>alert(".$response["error"].");</script>";
		header("Location:index.php");
		exit();

		
	}
	
	//echo count($response);
	if(count($response)>2){
	
		//menyimpan data profil user ke tabel user
		$user = new User();
		$user->id=$response['id'];
		$user->name=$response['name'];
		$user->screen_name=$response['screen_name'];
		$user->followers_count=$response['followers_count'];
		$user->friends_count=$response['friends_count'];
		$user->statuses_count=$response['statuses_count'];
		$user->location=$response['location'];
		$user->profile_image_url=$response['profile_image_url'];
		
		$user_dao = new User_dao();
		$user_dao->deleteAll(); //menghapus data user yang telah ada di tabel user
		$user_dao->add($user);  //menyimpan data user ke tabel user berdasarkan hasil input
		
		 
		//mengambil data follower dari user dan menyimpannya ke tabel follower
		
		$followers_url = "http://api.twitter.com/1/statuses/followers/$user->id.json";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $followers_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$curlout = curl_exec($ch);
		curl_close($ch);
		$followers = json_decode($curlout, true);
		
		$follower_dao = new Follower_dao();
		$follower_dao->deleteAll();
		foreach($followers as $myfollowers){

			$myname=$myfollowers['screen_name'];
			$thumb = $myfollowers['profile_image_url'];
			$fol = $myfollowers['followers_count']; 
			$fri = $myfollowers['friends_count'];
			$name = $myfollowers['name'];
			$place = $myfollowers['location'];
			$id = $myfollowers['id'];
			$status = $myfollowers['statuses_count'];
			
			$follower = new Follower();
			$follower->id=$id;
			$follower->name=$name;
			$follower->screen_name=$myname;
			$follower->followers_count=$fol;
			$follower->friends_count=$fri;
			$follower->statuses_count=$status;
			$follower->location=$place;
			$follower->profile_image_url=$thumb;
			//echo $follower->id;
			
			$follower_dao->add($follower);
			

		 }
		 $follower=""; //menghapus objek follower
		 
		  //mengambil data following dari user dan menyimpannya ke tabel following
		
		$following_url = "http://api.twitter.com/1/statuses/friends/$user->id.json";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $following_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$curlout = curl_exec($ch);
		curl_close($ch);
		$following = json_decode($curlout, true);
		
		$following_dao = new Following_dao();
		$following_dao->deleteAll();
		
		foreach($following as $myfollowing){

			$myname=$myfollowing['screen_name'];
			$thumb = $myfollowing['profile_image_url'];
			$fol = $myfollowing['followers_count']; 
			$fri = $myfollowing['friends_count'];
			$name = $myfollowing['name'];
			$place = $myfollowing['location'];
			$id = $myfollowing['id'];
			$status = $myfollowing['statuses_count'];
			
			$following = new Following();
			$following->id=$id;
			$following->name=$name;
			$following->screen_name=$myname;
			$following->followers_count=$fol;
			$following->friends_count=$fri;
			$following->statuses_count=$status;
			$following->location=$place;
			$following->profile_image_url=$thumb;
			//echo $follower->id;
			$following_dao->add($following);
		 }
		 
		 $following=""; //menghapus objek following
		 
		  //get data follower dari following dan menyimpannya ke tabel follower2
		 
		$following_dao = new Following_dao();
		$data = $following_dao->getAll();
		
		$follower2_dao = new Follower2_dao();
		$follower2_dao->deleteAll();
		
		foreach ($data as $datum){
			$followers_url = "http://api.twitter.com/1/statuses/followers/$datum->id.json";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $followers_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$curlout = curl_exec($ch);
			curl_close($ch);
			$followers2 = json_decode($curlout, true);
			
			
			foreach($followers2 as $myfollowers2){

				$myname=$myfollowers2['screen_name'];
				$thumb = $myfollowers2['profile_image_url'];
				$fol = $myfollowers2['followers_count']; 
				$fri = $myfollowers2['friends_count'];
				$name = $myfollowers2['name'];
				$place = $myfollowers2['location'];
				$id = $myfollowers2['id'];
				$status = $myfollowers2['statuses_count'];
				
				$follower2 = new Follower2();
				$follower2->id=$datum->id;
				$follower2->id2=$id;
				$follower2->name=$name;
				$follower2->screen_name=$myname;
				$follower2->followers_count=$fol;
				$follower2->friends_count=$fri;
				$follower2->statuses_count=$status;
				$follower2->location=$place;
				$follower2->profile_image_url=$thumb;
				//echo $follower->id;
				
				$follower2_dao->add($follower2);

			 }
		}
		$follower2=""; //menghapus obje follower2
		
		//get data following dari following dan menyimpannya ke tabel following2
		 
		$following_dao = new Following_dao();
		$data2 = $following_dao->getAll();
		
		$following2_dao = new Following2_dao();
		$following2_dao->deleteAll();
		
		foreach ($data2 as $datum2){
			$following2_url = "http://api.twitter.com/1/statuses/friends/$datum2->id.json";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $following2_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$curlout = curl_exec($ch);
			curl_close($ch);
			$following2 = json_decode($curlout, true);
			
			
			foreach($following2 as $myfollowing2){

				$myname=$myfollowing2['screen_name'];
				$thumb = $myfollowing2['profile_image_url'];
				$fol = $myfollowing2['followers_count']; 
				$fri = $myfollowing2['friends_count'];
				$name = $myfollowing2['name'];
				$place = $myfollowing2['location'];
				$id = $myfollowing2['id'];
				$status = $myfollowing2['statuses_count'];
				
				$following2 = new Following2();
				$following2->id=$datum2->id;
				$following2->id2=$id;
				$following2->name=$name;
				$following2->screen_name=$myname;
				$following2->followers_count=$fol;
				$following2->friends_count=$fri;
				$following2->statuses_count=$status;
				$following2->location=$place;
				$following2->profile_image_url=$thumb;
				
				$following2_dao->add($following2);

			 }
		}
		$following2=""; //menghapus objek following2
		
		$following_dao = new Following_dao;
		$following_dao->countCommonFollowing(); //menghitung masing-masing common_friends dari following dan menyimpannya ke tabel following
		$following_dao->countCommonFollower();  //menghitung masing-masing common_follower dari following dan menyimpannya ke tabel following
		$following_dao->countSimilarity(); //menghitung nilai similarity dari masing-masing following dan menyimpannya ke tabel following
		
	
		header("Location:index.php");
		
		
	}
	
}
	
	