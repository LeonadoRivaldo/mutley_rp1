<?php
require_once("../../model/post.model.php");
$posts = new Post();
$result = $posts->getAll();
date_default_timezone_set('UTC');
$today =  date("Y-m-d H:i:s");

foreach ($result as $post) {
	$diff = abs(strtotime($today) - strtotime($post['dataCriacao']));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	#echo "<br>";
	#echo "Post:" . $post['id'];
	#echo "<br>";
	#printf("%d years, %d months, %d days\n", $years, $months, $days);
	$log  ="Post: ".$post['id'].' - '.date("Y-m-d H:i:s").PHP_EOL.
        "Attempt: ".($days >= 7?'Success':'Failed').PHP_EOL.
        "-------------------------".PHP_EOL;
	//Save string to log, use FILE_APPEND to append.
	file_put_contents('./logs/log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
	if( $days >= 7 ){
		#echo "True";
		$posts->deletePost($post['id']);
	}
}

