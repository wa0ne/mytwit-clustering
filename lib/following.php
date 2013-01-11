<?php
require_once 'following2.php';
require_once 'follower2.php';
require_once 'follower.php';
require_once 'user.php';
require_once 'user.php';


class Following{
	
	var $id;
	var $name;
	var $screen_name;
	var $followers_count;
	var $friends_count;
	var $statuses_count;
	var $location;
	var $profile_image_url;
	var $common_followers_count;
	var $common_friends_count;
	var $similarity_followers;
	var $similarity_friends;
	var $cluster;

}

class Following_dao{

	function __construct(){	}
	
	//hapus data following
	function deleteAll(){
		
		$sql = "TRUNCATE TABLE Following"; 
		$query=mysql_query($sql);
		
	}
	
	
	//insert data following
	function add(Following $following){
		$sql="insert 
		into 
		following
		values(
		'$following->id',
		'$following->name',
		'$following->screen_name',
		'$following->followers_count', 
		'$following->friends_count', 
		'$following->statuses_count',
		'$following->location',
		'$following->profile_image_url',
		'',
		'',
		'',
		'',
		'')
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
		
	//mendapatkan seluruh data user berupa array 
	function getAll(){
		$sql="
		select *
		from
		following
		";
		
		$list_following = array();
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Following();
				
				$following->id = $row['id'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				$following->common_followers_count = $row['common_followers_count'];
				$following->common_friends_count = $row['common_friends_count'];
				$following->similarity_followers = $row['similarity_followers'];
				$following->similarity_friends = $row['similarity_friends'];
				$following->cluster = $row['cluster'];
				
				$list_following[] = $following;
			}
		}	
		return $list_following;
	}
	
	
	//menambahkan jumlah common_friends ke tabel following
	function CountCommonFollowing(){
		
		$following2_dao = new Following2_dao();
		$following2 = $following2_dao->getAll();
		
		$following_dao = new Following_dao();
		$following_dao->resetCommonFollowing();
		
		foreach($following2 as $fol2){
			$count =0;
			$id2 = $fol2->id2;
			
			$following = $following_dao->getAll();
			
			foreach($following as $fol){
				$id=$fol->id;	
				if($id2 == $id){
					$follow = $following_dao->getById($fol2->id);
					$count = $follow->common_friends_count + 1;
					//echo $count;
					$following_dao->addCommonFollowing($fol2->id,$count);
				}
			}
			//echo "<br/>";
			//echo $count;
		}
	}
	
	
	//menambahkan jumlah common_follower ke tabel following
	function countCommonFollower(){
		
		$follower2_dao = new Follower2_dao();
		$follower2 = $follower2_dao->getAll();
		
		$following_dao = new Following_dao();
		$following_dao->resetCommonFollower();
		
		$follower_dao = new Follower_dao();
		
		foreach($follower2 as $fol2){
			$count =0;
			$id2 = $fol2->id2;
			
			$follower = $follower_dao->getAll();
			
			foreach($follower as $fol){
				$id=$fol->id;	
				if($id2 == $id){
					$follow = $following_dao->getById($fol2->id);
					//var_dump($follow);
					$count = $follow->common_followers_count + 1;
					//echo $count;
					$following_dao->addCommonFollower($fol2->id,$count);
				}
			}
			//echo "<br/>";
			//echo $count;
			
		}
	}
	
	
	//mendapatkan following berdasarkan id
	function getById($id){
		$sql="
		select *
		from
		following
		where id = '$id'
		";
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Following();
				
				$following->id = $row['id'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				$following->common_followers_count = $row['common_followers_count'];
				$following->common_friends_count = $row['common_friends_count'];
				$following->similarity_followers = $row['similarity_followers'];
				$following->similarity_friends = $row['similarity_friends'];
				$following->cluster = $row['cluster'];	
			}
		}	
		return $following;
	}
	
	//mendapatkan following berdasarkan cluster
	function getByCluster($cls){
		$sql="
		select *
		from
		following
		where cluster = '$cls'
		";
		
		$i=0;
		
		$datam = array();
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$datam[$i] = array($row['similarity_followers'], $row['similarity_friends']);
				//$datam[$i] = array($row['common_followers_count'], $row['common_friends_count']);
				// $datam[0] = $row['common_followers_count'];
				// $datam[1] = $row['common_friends_count'];
				$i++;
			}
		}	
		return $datam;
	}
	
	
	//mendapatka array similarity
	function get(){
		$sql="
		select *
		from
		following
		";
		
		$i=0;
		
		$datam = array();
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$datam[$i] = array($row['similarity_followers'], $row['similarity_friends']);
				// $datam[0] = $row['common_followers_count'];
				// $datam[1] = $row['common_friends_count'];
				$i++;
			}
		}	
		return $datam;
	}
	
	//insert jumlah common_following berdasarkan id
	function addCommonFollowing($id,$count){
		$sql="update 
		following
		SET
		common_friends_count = '$count'
		WHERE
		id = '$id'
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	//insert jumlah common_follower berdasarkan id
	function addCommonFollower($id,$count){
		$sql="update 
		following
		SET
		common_followers_count = '$count'
		WHERE
		id = '$id'
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	//mereset nilai common_following jadi nol
	function resetCommonFollowing(){
		$sql="update 
		following
		SET
		common_friends_count = 0
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	//reset nilai common_follower jadi nol
	function resetCommonFollower(){
		$sql="update 
		following
		SET
		common_followers_count = 0
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	
	//menghitung dan insert niali similarity
	function countSimilarity(){
	
		$user_dao = new User_dao();
		$user = $user_dao->getAll();
		//var_dump($user);
		$followers_user = $user->followers_count - 1;
		$friends_user = $user->friends_count - 1;
		
		//echo $followers_user;
	
		$following_dao = new Following_dao();
		$following = $following_dao->getAll();
		
		foreach($following as $fol){
			$similarity_follower = $fol->common_followers_count / $followers_user ;
			//echo $similarity_follower;
			$following_dao->addSimilarityFollower($fol->id,$similarity_follower);
			
			$similarity_friends = $fol->common_friends_count / $friends_user;
			//echo $similarity_friends;
			$following_dao->addSimilarityFollowing($fol->id,$similarity_friends);
			
		}
	}
	
	//insert nilai similarity following berdasarkan id
	function addSimilarityFollowing($id,$val){
		$sql="update 
		following
		SET
		similarity_friends = '$val'
		WHERE
		id = '$id'
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	//insert nilai similarity follower berdasarkan id
	function addSimilarityFollower($id,$val){
		$sql="update 
		following
		SET
		similarity_followers = '$val'
		WHERE
		id = '$id'
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	//mendapatkan array id following
	function getId(){
		$sql="
		select *
		from
		following
		";
		
		$following = array();
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
				
				$following[] = $row['id'];
				//$following[0] = $row['screen_name'];
		
			}
		}	
		return $following;
	}
	
	
	//insert nilai cluster
	function addCluster($id,$val){
		$sql="update 
		following
		SET
		cluster = '$val'
		WHERE
		id = '$id'
		";
		$query=mysql_query($sql);
		//echo $Following->id;
	}
	
	
	function similarity(){
		$sql="
		select *
		from
		following
		";
		
		$list_following = array();
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$following = new Following();
				
				$following->id = $row['id'];
				$following->name = $row['name'];
				$following->screen_name = $row['screen_name'];
				$following->followers_count = $row['followers_count'];
				$following->friends_count = $row['friends_count'];
				$following->statuses_count = $row['statuses_count'];
				$following->location = $row['location'];
				$following->profile_image_url = $row['profile_image_url'];
				$following->common_followers_count = $row['common_followers_count'];
				$following->common_friends_count = $row['common_friends_count'];
				$following->similarity_followers = $row['similarity_followers'];
				$following->similarity_friends = $row['similarity_friends'];
				$following->cluster = $row['cluster'];
				
				$list_following[] = $following;
			}
		}	
		return $list_following;
	}
	
	
	//menampilkan common_friends ke tabel following
	function ViewCommonFollowing($id){
		
		$following2_dao = new Following2_dao();
		$following2 = $following2_dao->getById($id);
		
		$following_dao = new Following_dao();
		
		
		foreach($following2 as $fol2){
			$count =0;
			$id2 = $fol2->id2;
			
			$following = $following_dao->getAll();
			
			foreach($following as $fol){
				$id=$fol->id;	
				if($id2 == $id){
					$following = $following_dao->getById($fol2->id2);
					echo "<a href=\"https://twitter.com/$following->screen_name\" target=\"_BLANK\"><img src=\"$following->profile_image_url\" alt=\"$following->name\" title=\"$following->name\"></a>"; 
					
				}
			}
			//echo "<br/>";
			//echo $count;
		}
	}
	
	//View common_follower ke tabel following
	function ViewCommonFollower($id){
		
		$follower2_dao = new Follower2_dao();
		$follower2 = $follower2_dao->getById($id);
		
		$following_dao = new Following_dao();
	
		
		$follower_dao = new Follower_dao();
		
		foreach($follower2 as $fol2){
			$count =0;
			$id2 = $fol2->id2;
			
			$follower = $follower_dao->getAll();
			
			foreach($follower as $fol){
				$id=$fol->id;	
				if($id2 == $id){
					$following = $follower_dao->getById($fol2->id2);
					echo "<a href=\"https://twitter.com/$following->screen_name\" target=\"_BLANK\"><img src=\"$following->profile_image_url\" alt=\"$following->name\" title=\"$following->name\"></a>";
				}
			}
			//echo "<br/>";
			//echo $count;
			
		}
	}
	
}