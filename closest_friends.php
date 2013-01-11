<?php

session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config/config.php');
require_once('config/db.php');
require_once('lib/following.php');
require_once('lib/follower.php');
require_once('lib/following.php');
require_once('lib/follower2.php');
require_once('lib/following2.php');
require_once('lib/kmeans.php');
require_once('lib/centroid.php');

$db = new db();

$following_dao = new following_dao();
$following = $following_dao->getAll();

$following_dao = new Following_dao();
$data = $following_dao->getAll();

$clos_id = array();
$clos_val = array();
foreach($data as $datum){
	$x = $datum->similarity_followers + $datum->similarity_friends;  //nilai total similarity 
	$y = $datum->id;  //id following
	$clos_id[] = $y;
	$clos_val[] = $x;
}
$clos = array_combine($clos_id,$clos_val); //combine id dan nilai similarity
//var_dump($clos);

$id = max_key($clos); //medapatkan id dgn niliai similarity terbesar
//echo $id;

$following=$following_dao->getById($id); //dapatkan data user

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
	<div style="width:100px; float:left; margin-left:10px; border:1px solid #FFFFFF;"><img src="<?php echo $following->profile_image_url; ?>" width="100" height="100" /></div>
	<div style="width:475px; float:left; margin-left:10px;">
	 
	 <table width="400" border="0">
        <tr>
          <td colspan="3"><strong>Teman Terdekat Anda </strong></td>
          </tr>
        <tr>
          <td width="200">User Id </td>
          <td width="10">:</td>
          <td width="179"><?php echo $following->id; ?></td>
        </tr>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td><?php echo "<a href=\"https://twitter.com/$following->screen_name\" target=\"_BLANK\">".$following->screen_name."</a>"; ?></td>
        </tr>
        <tr>
          <td>Nama lengkap </td>
          <td>:</td>
          <td><?php echo $following->name; ?></td>
        </tr>
        <tr>
          <td>Jumlah following</td>
          <td>:</td>
          <td><?php echo $following->friends_count; ?></td>
        </tr>
        <tr>
          <td>Jumlah follower</td>
          <td>:</td>
          <td><?php echo $following->followers_count; ?></td>
        </tr>
        <tr>
          <td>Jumlah status </td>
          <td>:</td>
          <td><?php echo $following->statuses_count; ?></td>
        </tr>
        <tr>
          <td>Lokasi</td>
          <td>:</td>
          <td><?php echo $following->location; ?></td>
        </tr>
      </table>
	 
	 
	 <p>&nbsp;</p>
	 <table border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td >
		   <div align="left">Common Followings:</div></td>
         <td >&nbsp;</td>
         <td >
		   
		     <?php
		 $following_dao->ViewCommonFollowing($following->id);
		 ?>		 </td>
       </tr>
       <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
       </tr>
       <tr>
         <td >Common Followers:</td>
         <td >&nbsp;</td>
         <td >
		 <?php
		$following_dao->ViewCommonFollower($following->id);
		 ?>		 </td>
       </tr>
     </table>
	
	</div>
	
	<div style="width:170px; float:right; margin-right:10px;">
		
	<div>
	</div>
	
	
	</td>
  </tr>
</table>
</body>
</html>
