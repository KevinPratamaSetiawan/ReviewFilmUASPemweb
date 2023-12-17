<?php
include('connect-database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $film_id = $_POST['film_id'];

    $delete_query = "DELETE FROM film WHERE film_id = '$film_id'";

    if(mysqli_query($conn, $delete_query)){
        header('location:index.php');
    }else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>