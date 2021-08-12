<?php
session_start();

define("DESTROYER","🛥"); //takes up 2 places
define("CRUISER", "🚢"); //takes up 3 places
define("SUB", "🚤"); //takes up 3 places
define("BATTLESHIP", "🛳"); //takes up 4 places
define("CARRIER", "⛴"); //takes up 5 places
define("HIT","💥"); //this emoji will display when a boat is hit
define("MISS","🌊"); //this emoji will display when a boat is missed 

$board;
$ships;
$gridsize;
$turns;
$items = array("horizontal","vertical");
$orientation = $items[array_rand($items)];
//$orientation = "vertical";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (!empty($_POST["gridsize"]))
	{
		//Unpacking init
		$jsonData = json_decode($_POST["gridsize"]);
		$gridsize = $jsonData->gridsize;
		$turns = $jsonData->turns;
		//var_dump($gridsize);
	}
}
// if(!isset($_SESSION["game"]))
// {
	//start new game
	initGame($gridsize);
// }
// else {
// 	//continue Game
// 	$board = $_SESSION["game"]["board"];
// }

echo json_encode(array('game' => $_SESSION["game"]));

function initGame($s)
{
	$_SESSION["game"] = array("board" => null);
	global $board;
	global $turns;

	//create empty board
	$board = array_fill(0, $s, array_fill(0, $s, "#"));
	//place ships
	$board = custom_suffle($board);
	//save init game state 


	$_SESSION["game"]["board"] = $board;
	$_SESSION["game"]["turns"] = $turns;
}


function custom_suffle($board){
	global $orientation;
	$max_len = count($board)-1;
	$option_array = range($max_len,0,1);
	shuffle($option_array);
	if($orientation == "vertical"){
		$index = get_position($max_len,2);
		$board[$index[0]][$option_array[0]] = DESTROYER;
		$board[$index[1]][$option_array[0]] = DESTROYER;

		$index = get_position($max_len,3);
		$board[$index[0]][$option_array[1]] = CRUISER;
		$board[$index[1]][$option_array[1]] = CRUISER;
		$board[$index[2]][$option_array[1]] = CRUISER;

		$index = get_position($max_len,3);
		$board[$index[0]][$option_array[2]] = SUB;
		$board[$index[1]][$option_array[2]] = SUB;
		$board[$index[2]][$option_array[2]] = SUB;


		$index = get_position($max_len,4);
		$board[$index[0]][$option_array[3]] = BATTLESHIP;
		$board[$index[1]][$option_array[3]] = BATTLESHIP;
		$board[$index[2]][$option_array[3]] = BATTLESHIP;
		$board[$index[3]][$option_array[3]] = BATTLESHIP;

		$index = get_position($max_len,5);
		$board[$index[0]][$option_array[4]] = CARRIER;
		$board[$index[1]][$option_array[4]] = CARRIER;
		$board[$index[2]][$option_array[4]] = CARRIER;
		$board[$index[3]][$option_array[4]] = CARRIER;
		$board[$index[4]][$option_array[4]] = CARRIER;
	}else{

		$index = get_position($max_len,2);
		$board[$option_array[0]][$index[0]] = DESTROYER;
		$board[$option_array[0]][$index[1]] = DESTROYER;

		$index = get_position($max_len,3);
		$board[$option_array[1]][$index[0]] = CRUISER;
		$board[$option_array[1]][$index[1]] = CRUISER;
		$board[$option_array[1]][$index[2]] = CRUISER;

		$index = get_position($max_len,3);
		$board[$option_array[2]][$index[0]] = SUB;
		$board[$option_array[2]][$index[1]] = SUB;
		$board[$option_array[2]][$index[2]] = SUB;

		$index = get_position($max_len,4);
		$board[$option_array[3]][$index[0]] = BATTLESHIP;
		$board[$option_array[3]][$index[1]] = BATTLESHIP;
		$board[$option_array[3]][$index[2]] = BATTLESHIP;
		$board[$option_array[3]][$index[3]] = BATTLESHIP;

		$index = get_position($max_len,5);
		$board[$option_array[4]][$index[0]] = CARRIER;
		$board[$option_array[4]][$index[1]] = CARRIER;
		$board[$option_array[4]][$index[2]] = CARRIER;
		$board[$option_array[4]][$index[3]] = CARRIER;
		$board[$option_array[4]][$index[4]] = CARRIER;
	}
	return $board;
}

function get_position($max_len,$ship_size){
	$postion_array = array();
	$start = 0;
	$end = $max_len-$ship_size;
	$start = rand($start,$end);
	for($i=0;$i<$ship_size;$i++){
		$postion_array[] = $start;
		$start++;
	}
	return $postion_array;
	
}


?>