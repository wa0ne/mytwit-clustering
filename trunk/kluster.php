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
require_once('lib/kmeans.php');
require_once('lib/centroid.php');

$db = new db();

/* $following_dao = new Following_dao;
$following_dao->countCommonFollowing(); //menghitung masing-masing common_friends dari following dan menyimpannya ke tabel following
$following_dao->countCommonFollower();  //menghitung masing-masing common_follower dari following dan menyimpannya ke tabel following
$following_dao->countSimilarity(); 
 */
$user_dao = new User_dao();
$user = $user_dao->getAll(); //mendapatkan data user

$following_dao = new Following_dao();
$datanya = $following_dao->getId(); //mendapatkan data id following
//var_dump($datanya);

// $column1 = "common_followers_count";
// $column2 = "common_friends_count";
$column1 = "similarity_followers";
$column2 = "similarity_friends";
$data =loadData($column1, $column2); //mendapatkan data similarity dari tabel following
//var_dump($data);
//$data = array(array(0,0),array(0,2), array(2,0), array(2,2), array(5,0), array(5,2), array(7,0), array(7,2));
//$datanya = array("a","b","c","d","e","f","g","h");
$k=$_POST['k']; //mendapatkan jumlah cluster yang telah diinput
//$k=2;
$results = kmeans($data,$k);  //melakukan clustering menggunakan k-means dan menghasilkan centroid dan cluster

//$result berupa array, terdiri dari 2 array: array pertama data centroid dan array kedua data cluster
//$jitter = addJitter($data);

// var_dump($data);
// echo "<br />";
// echo "<br />";
//var_dump($results);
// echo "<br />";
// var_dump($jitter); 

//graph($data, $results, $jitter);


//echo count($data);
//echo count ($results);
$x = array();
$y = array();

//mendapatkan nilai array untuk similarity_followers sbg x dan similarity_following sbg y
for($i=0; $i<count($data); $i++){
	
	$x[]=$data[$i][0];
	$y[]=$data[$i][1];
	
}

$x2 = array();
$y2 = array();


$centroid_dao = new Centroid_dao();
$centroid_dao->deleteAll(); //menghapus data centroid lama

$i=0;
$cluster = array();//inisialisasi array cluster

        for($i=0; $i<$k; $i++){
			
			//if(!isset($results[0][$i][0])){$results[0][$i][0]="";}
			//if(!isset($results[0][$i][1])){$results[0][$i][1]="";}
			$x2[]=array($results[0][$i][0],$results[0][$i][1]);  //mendapatkan nilai dari msing-masing centroid
			//[0] menandakan array pertama dari $result yang berarti centroid. [$i] menandakan array ke-i dari centroid. [0] dan [1] menandakan nilai x dan y dari centroid
			//$y2[]=$results[0][$i][1];
			
			$centroid = new Centroid(); //buat objek centroid
			$centroid->centx = $results[0][$i][0]; 
			$centroid->centy = $results[0][$i][1];
			$centroid_dao->add($centroid); //simpan centroid ke tabel centroid.
			
			//echo $i;
			$clus = array();
			if(!isset($results[1][$i])){$results[1][$i]="";}
			$clus = $results[1][$i];  //data cluster berupa array
			//var_dump($clus);
			//echo "<br/>";
			//echo count($clus);
			$kls = array();
			
			for($j=0; $j<count($clus); $j++){
				
				if(!isset($clus[$j])){$clus[$j]="";}
				$kls[] = $clus[$j]; // objek cluster
				
				
			}
			$cluster[] = $kls;  //array objek cluster
			
			
		}
		//var_dump($cluster);
			
   

// var_dump($x);
// echo "<br />";
// var_dump($y);
// echo "<br />";
// var_dump($x2);
// echo "<br />";
// var_dump($y2);
// echo "<br />";
	 

//$graph = new mygraph();
//$graph->cluster($x, $y, $x2, $y2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MyTwit</title>
<style type="text/css">
<!--
body {
	background-image: url(images/bg.gif);
}
.style3 {
	color: #000000;
	font-size: 16px;
	font-weight: bold;
	font-family: Geneva, Arial, Helvetica, sans-serif;
}
-->
</style>


</head>

<body>
<table width="800" height="533" border="0" align="center" cellpadding="10">
  <tr>
     	<td height="87" background="images/wash-black-30.png">
		
		<div style="width:800px;float:left;">
		<img src="images/favicon.ico" width="25" height="25" />&nbsp;<span class="style3">MyTwit : Clustering Your Twitter Account </span>
		<div>
		
	<div></div>	</td>
	
  </tr>
  <tr>
    <td height="440" valign="top" background="images/wash-white-30.png">
	<div>
	<div style="width:100px; float:left; margin-left:10px; border:1px solid #FFFFFF;"><img src="<?php echo $user->profile_image_url; ?>" width="100" height="100" /></div>
	<div style="width:475px; float:left; margin-left:10px;">
	  <a href="index.php" style="text-decoration: none;">Back>></a>
	  <br/>
	  <br/>
	  
	  <?php echo "<strong>Clustering ".$user->friends_count." orang teman-teman <a href=\"https://twitter.com/$user->screen_name\" target=\"_BLANK\">".$user->name."</a> dengan ".$k." kluster.</strong>";
	  ?>
	  
	  
	  <br/>
	  <center><strong></strong></center><br/>
	  <table border=0 >
	 <?php
	 $i=0;
	 $warna = array("blue","orange","green","purple","maroon","pink","cyan","violet","lime","fuchsia","maroon","olive","navy","purple",
	"chocolate","coral","lightblue","orchid","skyblue","yellow","","","","","","","","","","","","","","","","","","","");
	
	 for($i=0; $i<count($cluster); $i++){
		echo "<tr>";	
			$ke = $i+1;
			echo "<td width=\"80\" valign=\"top\" bgcolor=\"$warna[$i]\">";
			//echo "Kluster ".$ke;
			echo "</td>";
			//echo "<td width=\"10\" valign=\"top\">";
			//echo ":";
			//echo "</td>";
			echo "<td width=\"500\" valign=\"top\">";
			$no=1;
			$j=0;
			for($j=0; $j<count($cluster[$i]); $j++){
				if(!isset($cluster[$i][$j])){$cluster[$i][$j]="";}
				//echo $i;
				//echo $j;
				$id = $datanya[$cluster[$i][$j]]; //mendapatkan id dari following berdasarkan clusternya
				$following = $following_dao->getById($id); //mendapatkan data following berdasarkan id
				//echo $no.". ".$following->screen_name." (common_follower=".$following->common_followers_count.", common_following=".$following->common_friends_count.")";
				//echo $ke;
				echo "<a href=\"https://twitter.com/$following->screen_name\" target=\"_BLANK\"><img src=\"$following->profile_image_url\" alt=\"$following->name\" title=\"$following->name\"></a>";  //menampilkan pic masing2 following brdasarkan clusternya
				$following_dao->addCluster($following->id,$ke); //menambahkan data cluster ke tabel following
					//echo "<br/>";
				$no++;
			}	
			echo "<br/>";
			echo "<br/>";
			echo "</td>";	
		echo "</tr>";
		}
	 
	 ?>
	  </table>
	  
	</div>
	
	<div style="width:170px; float:right; margin-right:10px;">
	<form action="scatterex.php" target="_BLANK" method="POST">		
	<input type="hidden" name="k" value="<?php echo $k ; ?>" />
	<input type="submit" value="Lihat Grafik Clustering" style="height: 25px; width: 150px; text-align:left">
	</form>
	
	<form action="sse.php" target="_BLANK">
	<input type="submit" value="Lihat SSE" style="text-align:left; height: 25px; width: 150px ">
	</form>
	
	<form action="closest_friends.php" target="_BLANK">
	<input type="submit" value="Lihat Closest Friend" style="text-align:left; height: 25px; width: 150px ">
	</form>
				
	
	<div>
	</div>
	
	
	</td>
  </tr>
</table>
</body>
</html>
