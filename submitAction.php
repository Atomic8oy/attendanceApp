<?php
$db = new SQLite3("database.db");

$data = array();

for ($x = 1; $x <= $_POST['count']; $x++) {
    $id = $_POST["$x-id"];
    $delay = isset($_POST["$x-delay"]);
    $i = isset($_POST["$x-i"]);
    $ii = isset($_POST["$x-ii"]);
    $iii = isset($_POST["$x-iii"]);
    $iv = isset($_POST["$x-iv"]);
    $all = isset($_POST["$x-all"]);
    $data[] = array(
        "id"=>$id,
        "delay"=>$delay,
        "i"=>$i,
        "ii"=>$ii,
        "iii"=>$iii,
        "iv"=>$iv,
        "all"=>$all
    );
}

$success = 1;

foreach ($data as $row) {
    echo json_encode($row);
    $id = (int) $row['id'];
    $delay = (bool) $row['delay'];
    $i = (bool) $row['i'];
    $ii = (bool) $row['ii'];
    $iii = (bool) $row['iii'];
    $iv =(bool)  $row['iv'];
    $all = (bool) $row['all'];

    if ($delay || $i || $ii || $iii || $iv || $all) {
        echo " [SAVED]";
        $date = strtotime(date("Y m d"));

        $result = $db->query("INSERT INTO records (student, date, delayed, i, ii, iii, iv , all_day) 
        VALUES ('$id' , '$date', '$delay', '$i', '$ii', '$iii', '$iv', '$all')");
        
        $success *= $result != false;
    }
    echo "<br>";
}

if ($success) {
    header("Location: index.php?msg=success");
} else {
    header("Location: index.php?msg=fail");
}
exit;