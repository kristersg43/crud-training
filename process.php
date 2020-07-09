<?php
session_start();
//You must change MySQL localhost Username and password to yours to connect
$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$location = '';

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];

    $mysqli->query("INSERT INTO data (name, location) VALUES('$name', '$location')") 
    or die($mysqli->error);
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    //Redirect
    header("location: index.php");
}

if (isset($_GET['delete'])) {
    //Adding (int) to protect database from injections
    $id = (int)$_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";

    //Redirect
    header("location: index.php");
}

if (isset($_GET['edit'])){
    //Adding (int) to protect database from injections
    $id = (int)$_GET['edit'];
    $update = true;
    $query = "SELECT * FROM data WHERE id=$id";
    $result = $mysqli->query($query) or die($mysqli->error());
    $row = $result->fetch_array();
    // echo '<pre>';
    // var_dump($query, $row, $result);
    // echo '</pre>';
    
    if (isset($row['name'])){
        
        $name = $row['name'];
        $location = $row['location'];
    }
}

if (isset($_POST['update'])){
    $id = $_POST['id']; //Hidden input field
    $name = $_POST['name'];
    $location = $_POST['location'];

    //Set name and location new value where id=$id of the record
    $mysqli->query("UPDATE data SET name='$name', location='$location' WHERE id=$id") or 
    die($mysqli->error);

    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header('location: index.php');
}