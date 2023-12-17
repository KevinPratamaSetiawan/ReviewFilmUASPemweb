<?php
include('connect-database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $synopsis = $_POST['synopsis'];
    $release_month = $_POST['month'];
    $release_year = $_POST['year'];
    $score = $_POST['score'];

    $genre = $_POST['genre'];

    $user_ip = $_POST['user_ip'];
    $user_agent = $_POST['user_agent'];

    $film_query = "INSERT INTO film (title, synopsis, release_month, release_year, score) 
                    VALUES ('$title','$synopsis','$release_month','$release_year','$score')";
    
    if(mysqli_query($conn, $film_query)){

        echo "Data berhasil ditambahkan.<br>";

        $get_id_query = "SELECT * FROM film WHERE title = '$title'";
        $get_id_result = $conn->query($get_id_query);
        $id_result=$get_id_result->fetch_assoc();

        $fk_id = $id_result['film_id'];

        foreach($genre as $add_genre){
            $genre_query = "INSERT INTO genre (fk_film_id, genre) VALUES ('$fk_id','$add_genre')";
            if(mysqli_query($conn, $genre_query)){
                echo "Data " . $add_genre . " berhasil ditambahkan.<br>";
            }else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }

        $user_query = "INSERT INTO user_data (fk2_film_id, user_ip, user_browser) VALUES ('$fk_id','$user_ip','$user_agent')";

        if(mysqli_query($conn, $user_query)){
            echo "Data " . $user_ip . $user_agent . " berhasil ditambahkan.<br>";
        }else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        header('location:index.php');
    }else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}   
?>