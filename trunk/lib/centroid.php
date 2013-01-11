<?php


//objek centroid
class Centroid{
	
	var $id3;
	var $centx;
	var $centy;
	
}


//operation dari objek centroid
class Centroid_dao{

	function __construct(){	}
	
	//menghapus data centroid di tabel centroid
	function deleteAll(){
		
		$sql = "TRUNCATE TABLE centroid"; 
		$query=mysql_query($sql);
		
	}
	
	
	//menambahkan data centroid ke tabel centroid
	function add(Centroid $centroid){
		//echo $centroid->centx;
		//echo $centroid->centy;
		$sql="insert 
		into 
		centroid
		values('',
		'$centroid->centx',
		'$centroid->centy')
		";
		$query=mysql_query($sql);
		//echo "oke";
		//echo $follower->id;
	}
	
	
	//mendapatkan data centroid berupa array objek
	function getAll(){
		$sql="
		select *
		from
		centroid
		order by id3
		asc
		";
		
		$list_cent = array();
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$centroid = new Centroid();
				
				$centroid->centx = $row['x'];
				$centroid->centy = $row['y'];
				
				
				$list_cent[] = $centroid;
			}
		}	
		return ($list_cent);
	}
	
	
	//mendapatkan array x dan y dari centroid
	function get(){
		$sql="
		select *
		from
		centroid
		order by id3
		asc
		";
		
		$centroid = array();
		
		$i=0;
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
				
				$centroid[$i] = array($row['x'], $row['y']);
				$i++;
			}
		}	
		return $centroid;
	}
	
	
	//mendapatkan centroid berdasarkan id
	function getId($id){
		$sql="
		select *
		from
		centroid
		where id3 = '$id'
		";
		
		
		
		$data = mysql_query($sql);
		if($data){
			while($row = mysql_fetch_assoc($data)){
			
				$centroid = new Centroid();
				
				$centroid->centx = $row['x'];
				$centroid->centy = $row['y'];
				
				
			}
		}	
		return $centroid;
	}

		
	
	
}