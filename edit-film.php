<?php
include('connect-database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $film_id = $_POST['film_id'];
    $title = $_POST['title'];
    $synopsis = $_POST['synopsis'];
    $release_month = $_POST['month'];
    $release_year = $_POST['year'];
    $score = $_POST['score'];

    $genre = $_POST['genre'];

    $edit_query = "UPDATE film SET title = '$title', synopsis = '$synopsis', release_month = '$release_month', release_year = '$release_year', score = '$score' WHERE film_id = '$film_id'";

    $delete_genre_query = "DELETE FROM genre WHERE fk_film_id = '$film_id'";

    if(mysqli_query($conn, $edit_query) && mysqli_query($conn, $delete_genre_query)){

        echo "Data berhasil ditambahkan.<br>";

        foreach($genre as $add_genre){
            $genre_query = "INSERT INTO genre (fk_film_id, genre) VALUES ('$film_id','$add_genre')";
            if(mysqli_query($conn, $genre_query)){
                echo "Data " . $add_genre . " berhasil ditambahkan.<br>";
            }else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
        // header('location:detail-page.php');
    }else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>
<body>
    <form id="back-to-detail-page" action="detail-page.php" method="post">
        <input name="film_id" type="hidden" value="<?php echo $film_id;?>">
    </form>

    <script type="text/javascript">
        document.getElementById("back-to-detail-page").submit();
    </script>
</body>
</html>