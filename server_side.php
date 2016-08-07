<?php
    $conn = mysqli_connect("mysql4.000webhost.com", "a8690970_chat", "154233", "a8690970_chat");
    if(isset($_GET["function"])){
        switch($_GET["function"]){
            case "new":
                if(isset($_GET["player1"]) && isset($_GET["player2"])){
                    $player1 = $_GET["player1"];
                    $player2 = $_GET["player2"];
                    mysqli_query($conn, "UPDATE player SET name = '$player1', goals = 0 WHERE id=1");
                    mysqli_query($conn, "UPDATE player SET name = '$player2', goals = 0 WHERE id=2");
                }
                break;
            case "update":
                if(isset($_GET["player"])){
                    $player = $_GET["player"];
                    mysqli_query($conn, "UPDATE player SET goals = goals+1 WHERE type='player$player'");
                }
                break;
            case "reset":
                mysqli_query($conn, "UPDATE player SET goals = 0 WHERE id = 1 or id = 2");
                break;  
            case "get":
                $result = mysqli_query($conn, "SELECT * FROM player");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo $row["name"].": " . $row["goals"] ."<br>";
                    }
                }
                break;
        }   
    }
?>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    function update(){
        $.get("index.php", {'function': 'get'}, function(data){
            document.getElementById("area").innerHTML = data;
        });
    }
</script>
<style>
    *{
        font-size:60px;
        font-family:"Comic Sans MS";
    }
</style>
<body onload="setInterval(update, 1000);">
<div id="area">
</div>
</body>
