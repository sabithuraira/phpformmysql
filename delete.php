<?php
    $username = "root";
    $password = "";
    $server_name = "localhost";
    $database_name = "penerbangan"; 
    $connection = new mysqli($server_name, $username, $password, $database_name);
    
    $id_data = $_GET['id'];
    $sql_delete_data = "DELETE FROM bandara WHERE id=".$id_data;

    if($connection->query($sql_delete_data) === TRUE){
        header('Location: index.php');
    }
    else{
        echo "Data gagal dimasukkan:".$connection->error;
    }
?>