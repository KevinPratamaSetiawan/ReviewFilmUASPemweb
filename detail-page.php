<?php 
include('connect-database.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $film_id = $_POST['film_id'];
    
    $detail_query = "SELECT * FROM film WHERE film_id = '$film_id'";
    $detail_result = $conn->query($detail_query);
    
    $data = $detail_result->fetch_assoc();
}

$_SESSION["initiated"] = "yes";
$_SESSION["visit_history_id"][$_SESSION["count_history"]] = $_POST['film_id'];
$_SESSION["visit_history_title"][$_SESSION["count_history"]] = $data['title'];
$_SESSION["visit_history_score"][$_SESSION["count_history"]] = $data['score'];
$_SESSION["count_history"] += 1;

$genre_query = "SELECT * FROM genre WHERE fk_film_id = '$film_id'";
$genre_result = $conn->query($genre_query);

$checked_genre = ['no','no','no','no','no','no','no','no'];
$genres = ['Action','Adventure','Animation','Comedy','Drama','Fantasy','Horror','Romance'];

while($genre_list=$genre_result->fetch_assoc()){
    for($i=0;$i<8;$i++){
        if($genre_list['genre'] == $genres[$i]){
            $checked_genre[$i] = 'yes';
        }
    }
}

$genre_result->data_Seek(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'];?></title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="detail-container">
        <div id="detail-page">
            <div>
                <div id="detail-title">
                    <h2><?php echo $data['title'];?></h2>
                    <button onclick="location.href='index.php';">X</button>
                </div>
                <div id="details-data-part">
                    <div id="detail-one-part">
                        <div id="detail-date-score">
                            <p><?php echo $data['release_month'] . " " . $data['release_year'];?></p>
                            <p><?php echo $data['score'];?>/100</p>
                        </div>
                        <div id="detail-synopsis">
                            <h4>Synopsis</h4>
                            <p><?php echo $data['synopsis'];?></p>
                        </div>
                    </div>
                    <div id="detail-two-part">
                        <h4>Genre</h4>
                            <ul>
                            <?php
                                while($genre_list=$genre_result->fetch_assoc()){
                                    if($genre_list['fk_film_id'] == $data['film_id']){
                            ?>
                                <li class="genre-list"><?php echo $genre_list['genre'];?></li>
                            <?php
                                    }
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <div id="details-button-part">
                <button onclick="OpenEdit()">Edit</button>
                <button onclick="OpenAffirmDel()">Delete</button>
            </div>
        </div>
    </div>
    
    <div id="del-affirm-container">
        <div id="del-affirm-form">
            <form action="del-film.php" method="post">
                <input name="film_id" type="hidden" value="<?php echo $data['film_id'];?>">
                <p>Are you sure ?</p>

                <div>
                    <button type="button" onclick="CloseAffirmDel()">Cancel</button>
                    <button type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-container">
        <div id="edit-form">
            <form action="edit-film.php" method="post">
                <div id="title-add-form">
                    <h3>Edit Film</h3>
                </div>
                <input name="film_id" type="hidden" value="<?php echo $data['film_id'];?>">
                <label for="title"><b>Title</b><b style="color:red;">*</b></label><br>
                <input type="text" name="title" class="add-form-text" value="<?php echo $data['title'];?>" required><br>

                <label for="synopsis"><b>Synopsis</b><b style="color:red;">*</b></label><br>
                <input type="text" name="synopsis" class="add-form-text" value="<?php echo $data['synopsis'];?>" required><br>

                <div id="genre-add-form">
                    <label><b>Genre</b><b style="color:red;">*</b></label><br>
                    <div id="genre-container">
                        <div id="genre-part-1">
                            <input type="checkbox" name="genre[]" value="Action" <?php if($checked_genre[0]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Action</label><br>
                            <input type="checkbox" name="genre[]" value="Adventure" <?php if($checked_genre[1]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Adventure</label><br>
                            <input type="checkbox" name="genre[]" value="Animation" <?php if($checked_genre[2]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Animation</label><br>
                            <input type="checkbox" name="genre[]" value="Comedy" <?php if($checked_genre[3]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Comedy</label><br>
                        </div>
                        <div id="genre-part-2">
                            <input type="checkbox" name="genre[]" value="Drama" <?php if($checked_genre[4]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Drama</label><br>
                            <input type="checkbox" name="genre[]" value="Fantasy" <?php if($checked_genre[5]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Fantasy</label><br>
                            <input type="checkbox" name="genre[]" value="Horror" <?php if($checked_genre[6]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Horror</label><br>
                            <input type="checkbox" name="genre[]" value="Romance" <?php if($checked_genre[7]=="yes"){ echo'checked="checked"';}?>>
                            <label for="genre">Romance</label><br>
                        </div>
                    </div>
                </div>

                <div id="date-add-form">
                    <div>
                        <label for="month"><b>Month</b><b style="color:red;">*</b></label><br>
                        <select name="month" id="month-add">
                            <option value="January" <?php if($data['release_month']=="January"){ echo'selected="selected"';}?>>January</option>
                            <option value="February" <?php if($data['release_month']=="February"){ echo'selected="selected"';}?>>February</option>
                            <option value="March" <?php if($data['release_month']=="March"){ echo'selected="selected"';}?>>March</option>
                            <option value="April" <?php if($data['release_month']=="April"){ echo'selected="selected"';}?>>April</option>
                            <option value="May" <?php if($data['release_month']=="May"){ echo'selected="selected"';}?>>May</option>
                            <option value="June" <?php if($data['release_month']=="June"){ echo'selected="selected"';}?>>June</option>
                            <option value="July" <?php if($data['release_month']=="July"){ echo'selected="selected"';}?>>July</option>
                            <option value="August" <?php if($data['release_month']=="August"){ echo'selected="selected"';}?>>August</option>
                            <option value="September" <?php if($data['release_month']=="September"){ echo'selected="selected"';}?>>September</option>
                            <option value="October" <?php if($data['release_month']=="October"){ echo'selected="selected"';}?>>October</option>
                            <option value="November" <?php if($data['release_month']=="November"){ echo'selected="selected"';}?>>November</option>
                            <option value="December" <?php if($data['release_month']=="December"){ echo'selected="selected"';}?>>December</option>
                        </select>
                    </div>

                    <div>
                        <label for="year"><b>Year</b><b style="color:red;">*</b></label><br>
                        <input name="year" type="number" min="1900" max="2099" value="<?php echo $data['release_year'];?>"/>
                    </div>
                </div>

                <label for="score"><b>Score</b><b style="color:red;">*</b></label><br>
                <input name="score" type="number" min="0" max="100" value="<?php echo $data['score'];?>" class="add-form-text"/><br>

                <div>
                    <button type="button" onclick="CloseEdit()">Cancel</button>
                    <button type="button" onclick="CheckGenre()">Change</button>
                </div>

                <div id="edit-affirm-container">
                    <div id="edit-affirm-form">
                        <h3>Are you sure ?</h3>
                        <p>Make sure all the data is correct</p>

                        <div>
                            <button type="button" onclick="CloseAffirmEdit()">Cancel</button>
                            <button type="submit">Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function OpenAffirmDel(){
            document.getElementById("del-affirm-container").style.display = "block";
            document.getElementById("del-affirm-container").style.visibility = "visible";
        }

        function CloseAffirmDel(){
            document.getElementById("del-affirm-container").style.display = "none";
            document.getElementById("del-affirm-container").style.visibility = "hidden";
        }

        function OpenEdit(){
            document.getElementById("edit-container").style.display = "block";
            document.getElementById("edit-container").style.visibility = "visible";
        }

        function CloseEdit(){
            document.getElementById("edit-container").style.display = "none";
            document.getElementById("edit-container").style.visibility = "hidden";
        }

        function OpenAffirmEdit(){
            document.getElementById("edit-affirm-container").style.display = "block";
            document.getElementById("edit-affirm-container").style.visibility = "visible";
        }

        function CloseAffirmEdit(){
            document.getElementById("edit-affirm-container").style.display = "none";
            document.getElementById("edit-affirm-container").style.visibility = "hidden";
        }

        function CheckGenre(){
            var checked = document.querySelectorAll('[name="genre[]"]:checked');

            if(checked.length > 0){
                OpenAffirmEdit()
            }else{
                alert("Atleast one genre must be choose");
            }
        }
    </script>

<!-- <?php
    $count_history = 0;
    while($_SESSION["visit_history_id"][$count_history] != ""){
        echo $count_history;
        echo $_SESSION["visit_history_id"][$count_history] . "<br>";
        echo $_SESSION["visit_history_title"][$count_history] . "<br>";
        echo $_SESSION["visit_history_score"][$count_history] . "<br>";
        $count_history++;
    }

?> -->
</body>
</html>