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
$turns;
if(!isset($_SESSION["game"]))
{
    exit();
}
else {
    //continue game
    $board = $_SESSION["game"] ["board"];
    $turns = $_SESSION["game"]["turns"];
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    if (!empty($_POST["data"]))
    {
        //unpacking attack
        $jsonData = json_decode($_POST["data"]);
        $encodedCoords = $jsonData->id;

        $_coords = explode("-",$encodedCoords);
        //echo $_coords;

        $result["id"] = $encodedCoords;
        $result["x"] = intval($_coords[0]);
        $result["y"] = intval($_coords[1]);

        // Check attempts
        if($turns>0){
            if($board[$result["x"]][$result["y"]] == "#" )
            {
                $result["status"] = "Miss";
                $result["message"] = "you found the ocean!";
                $board[$result["x"]][$result["y"]] = MISS;
                $turns--;
            }
            // Either new hit or already missed or already hit
            else if(($board[$result["x"]][$result["y"]] == MISS))
            {   
                $result["status"] = "Miss";
                $result["message"] = "stop wasting ammo!";
                $turns--;
            }
            else if(($board[$result["x"]][$result["y"]] == HIT))
            {
                $result["status"] = "Miss";
                $result["message"] = "stop wasting ammo!";
                $turns--;
            }
            else
            {
                $result["status"] = "Hit";
                $result["message"] = "you hit a ship!";
                $board[$result["x"]][$result["y"]] = HIT;
            }

            //update the session
            $_SESSION["game"]["board"] = $board;
            $_SESSION["game"]["turns"] = $turns;
        }else{
            $result["status"] = "end";
            $result["message"] = "You Don't have any turn left";
        }
        

        //return result
        
        echo json_encode($result);
    }
}


    ?>