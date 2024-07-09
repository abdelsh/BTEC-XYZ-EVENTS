<?php
include("config.php");

if(isset($_GET["eventID"])){
    $id = $_GET["eventID"];

    $sql = "DELETE FROM cart_tb WHERE eventID = '$id'";
    $result = mysqli_query($conn, $sql);

    $sql = "DELETE FROM ticketprice WHERE eventID = '$id'";
    $result = mysqli_query($conn, $sql);
    
    $sql = "DELETE FROM events_tb WHERE eventID = '$id'";
    $result = mysqli_query($conn, $sql);

    header("location: dashboard.php");
    exit();
}
?>