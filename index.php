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


$db = new db(); //oneksi database

$user_dao = new User_dao();
$user = $user_dao->getAll(); //mendapatkan objek user yang telah ada ditabel user
//var_dump($user);

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
.style5 {font-size: 12px}
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
	  <table width="317" border="0">
        <tr>
          <td colspan="3"><strong>Profil Anda </strong></td>
          </tr>
        <tr>
          <td width="114">User Id </td>
          <td width="10">:</td>
          <td width="179"><?php echo $user->id; ?></td>
        </tr>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td><?php echo $user->screen_name; ?></td>
        </tr>
        <tr>
          <td>Nama lengkap </td>
          <td>:</td>
          <td><?php echo $user->name; ?></td>
        </tr>
        <tr>
          <td>Jumlah following</td>
          <td>:</td>
          <td><?php echo $user->friends_count; ?></td>
        </tr>
        <tr>
          <td>Jumlah follower</td>
          <td>:</td>
          <td><?php echo $user->followers_count; ?></td>
        </tr>
        <tr>
          <td>Jumlah status </td>
          <td>:</td>
          <td><?php echo $user->statuses_count; ?></td>
        </tr>
        <tr>
          <td>Lokasi</td>
          <td>:</td>
          <td><?php echo $user->location; ?></td>
        </tr>
      </table>
	  <br/>
	  <br/>
	  <strong>Cari user Baru	  </strong>
	  <form name="form1" method="post" action="proses.php">
		
		Masukan username  : 
		<input type="text" name="nama">
		
		<input type="submit" value="submit" onclick="return validasi2();">
		<br/>
		<span class="style5">(Misalkan @fromjayakarta, maka input pada form: fromjayakarta.)		</span>
	  </form>
	</div>
	
	<div style="width:175px; float:left; margin-left:10px;">
		
		<strong>Clustering Your Friends</strong>
		<br/>
		<br/>
	  <form name="formK" method="post" action="kluster.php">
		
		Masukan Jumlah cluster (k) : <input type="text" name="k">
				
		<input type="submit" value="submit" onclick="return validasi();">
				
	  </form>
	<div>
	</div>
	
	
	</td>
  </tr>
</table>
</body>
</html>

<script>
function validasi(){
	var x = document.formK.k.value;
	if(x<1){
		alert('Jumlah kluster minimal 1.');
		return false;
	}
	if(x>5){
		alert('Jumlah kluster maksimal 5.');
		return false;
	}
	
}

function validasi2(){
	var y = document.form1.nama.value;
	
	if(y==""){
		alert('User harus diisi.');
		return false;
	}
	
	
}
</script>
