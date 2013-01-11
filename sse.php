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
require_once('lib/centroid.php');

$db = new db();

$user_dao = new User_dao();
$user = $user_dao->getAll();

$Centroid_Dao = new Centroid_dao();
$centroid = $Centroid_Dao->getAll();

$Following_Dao = new Following_Dao();
$similarity = $Following_Dao->get();
//$cluster = $Following_dao->get



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
.style4 {color: #FFFFFF}
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
	
	<div style="width:100px; float:left; margin-left:10px;"></div>
	
	<div style="width:475px; float:left; margin-left:10px;">
	  <p><strong>Sum of Squared Errors (<em>SSE</em>)  </strong></p>
	  <table width="478" border="1" cellpadding="3" cellspacing="0">
        <tr>
          <td width="91" bgcolor="#66CCFF"><div align="center"><strong>Kluster</strong></div></td>
          <td width="197" bgcolor="#66CCFF"><div align="center"><strong>Centroid</strong></div></td>
          <td width="165" bgcolor="#66CCFF"><div align="center"><strong>SSE</strong></div></td>
        </tr>
		<?php
		$warna = array("blue","orange","green","purple","maroon","pink","cyan","violet","lime","fuchsia","maroon","olive","navy","purple",
	"chocolate","coral","lightblue","orchid","skyblue","yellow","","","","","","","","","","","","","","","","","","","");
		$i=0;
		$cls=1;
		$x=0;
		$y=0;
		$tot_sse = array();
		foreach($centroid as $centro){ ?>
        <tr>
          <td bgcolor="<?php echo $warna[$i] ; ?>"><div align="center" class="style4"><?php echo $cls; ?></div></td>
          <td><div align="center"><?php echo "x = ".$centro->centx.", y = ".$centro->centy; ?></div></td>
		  <?php 
		  $cluster = $Following_Dao->getByCluster($cls);
		  $sse = array();
		  foreach($cluster as $clus){
		  	$x = pow(abs($centro->centx - $clus[0]),2);
			//echo $x;
			//echo " ";
			$y = pow(abs($centro->centy - $clus[1]),2);
			//echo $y;
			//echo "<br />";
			
			$sse [] = $x + $y;
		  }
		 
		  $tot_sse[] = array_sum($sse);
		  ?>
          <td><div align="center"><?php echo round(array_sum($sse),3); ?></div></td>
        </tr>
		<?php $cls++; $i++; } ?>
        <tr>
          <td colspan="2""><div align="center">Jumlah</div></td>
          <td><div align="center"><?php echo round(array_sum($tot_sse),3); ?></div></td>
        </tr>
      </table>
	  <p>&nbsp;	</p>
	</div>
	
	<div style="width:175px; float:left; margin-left:10px;"><div>
	
	</div>
	</td>
  </tr>
</table>
</body>
</html>
