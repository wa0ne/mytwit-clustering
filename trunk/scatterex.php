<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_scatter.php');
require_once ('lib/following.php');
require_once('config/db.php');
require_once('lib/user.php');
require_once('lib/centroid.php');


class mygraph{

function cluster($k){
	
	$db = new db();

	$user_dao = new User_dao();
	$user = $user_dao->getAll();  //get data user

	

	//create graph
	$graph = new Graph(700,600); 
	//set graph
	$graph->SetScale("linlin");
	$graph->img->SetMargin(70,50,50,50);		
	//$graph->SetShadow();
	$graph->title->Set("Friends Twitter Clustering");
	$graph->title->SetFont(FF_ARIAL,FS_NORMAL,14);
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->title->SetMargin(10);
	$userx = $user->name;
	$graph->subtitle->Set("User: ".$userx." (".$k." Kluster)");
	$graph->subtitle->SetFont(FF_FONT1,FS_BOLD);
	//$graph->yaxis->scale->SetAutoMax(1);  //untuk seting max nilai y
	//$graph->xaxis->scale->SetAutoMax(1);  //untuk seting max nilai x
	
	//
	
	
	$following_dao = new Following_dao();
	/* 
	$data = $following_dao->get();
	$x = array();
	$y = array();
	for($i=0; $i<count($data); $i++){
		$x[]=$data[$i][0];
		$y[]=$data[$i][1];	
	}
	
	//format scatterplots data
	$scatterplots = new ScatterPlot($y, $x); // (Data)
	$scatterplots->mark->SetType(MARK_FILLEDCIRCLE);
	$scatterplots->mark->SetFillColor("blue");
	$scatterplots->mark->SetWidth(4);
	 */
	$warna = array("blue","orange","green","purple","maroon","pink","cyan","violet","lime","fuchsia","maroon","olive","navy","purple",
	"chocolate","coral","lightblue","orchid","skyblue","yellow","","","","","","","","","","","","","","","","","","","");  //warna untuk cluster
	
	
	//data cluster
	for($i=0; $i<$k; $i++){
		
		$x = array();
		$y = array();
		
		$data = $following_dao->getByCluster($i+1);
		//var_dump($data);

		for($j=0; $j<count($data); $j++){
		
			$x[]=$data[$j][0];
			$y[]=$data[$j][1];
		
		}
		//var_dump($x);
		$scatterplots[$i] = new ScatterPlot($y,$x);
		$scatterplots[$i]->mark->SetType(MARK_FILLEDCIRCLE);
		if($warna[$i]==""){$warna[$i]="gold";}
		$scatterplots[$i]->mark->SetFillColor($warna[$i]);
		$scatterplots[$i]->mark->SetWidth(3);
		$graph->Add($scatterplots[$i]);  
		
	}
   
   
   
   	// data centroid
	$centroid_dao = new Centroid_dao();
	$data2 = $centroid_dao->get();
	$x2 = array();
	$y2 = array();
	for($i=0; $i<count($data2); $i++){
			$x2[]=$data2[$i][0];
			$y2[]=$data2[$i][1];
		}
   

	$centroids = new ScatterPlot($y2, $x2); // (Centroids)
	$centroids->mark->SetType(MARK_CROSS);
	$centroids->mark->SetFillColor("red");
	$centroids->mark->SetColor("red");
	$centroids->mark->SetWeight(10);
	$centroids->mark->SetWidth(50);
	$centroids->value->SetColor("black");

	
	
	// Add plots to graph.
	$graph->Add($centroids);
	//$graph->Add($scatterplots);
	$graph->xaxis->title->Set('Followers Similarity');
	$graph->yaxis->title->Set('Followings Similarity');
	$graph->yaxis->title->SetMargin(10);

	// Display graph
	$graph->Stroke();
	
	
	}
}
$go = new mygraph();
$k = $_POST['k'];
//$k=2;
$go->cluster($k);
//$go->cluster($x2, $y2, $k);
//var_dump($_POST['datax']);
//echo $k;
?>
