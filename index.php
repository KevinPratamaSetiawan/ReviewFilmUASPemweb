<?php
include('connect-database.php');

session_start();
if($_SESSION["initiated"] == "yes"){

}else{
    $_SESSION["count_history"] = 0;
    $_SESSION["visit_history_id"] = [];
    $_SESSION["visit_history_title"] = [];
    $_SESSION["visit_history_score"] = [];
    $_SESSION["initiated"] = "yes";
}

function get_user_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
    }

$user_ip = get_user_ip();

$user_agent = $_SERVER['HTTP_USER_AGENT'];

$main_query = "SELECT * FROM film ORDER BY title ASC ";
$main_result = $conn->query($main_query);

$genre_query = "SELECT * FROM genre ORDER BY fk_film_id ASC";
$genre_result = $conn->query($genre_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Film Review</title>

    <link rel="stylesheet" href="style.css">
</head>
<body onload="CheckCookie()">
    <div id="search-bar">
        <form action="" id="src-form">
        <input id="search-bar-itself" type="text" placeholder="Search...">
        <button type="submit" class="search_btn">Search</button>
        </form>
    </div>

    <div id="display-film-history">
        <div id="display-film">
            <div id="button-part">
                <div id="filter-part">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <select name="genre-src" id="genre-src">
                            <option value="" selected disabled>Any</option>
                            <option value="Action">Action</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Animation">Animation</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Drama">Drama</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Horror">Horror</option>
                            <option value="Romance">Romance</option>
                        </select>
                        <select name="month-src" id="month-src">
                            <option value="" selected disabled>Any</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                        <select name="year-src" id="year-src">
                            <option value="" selected disabled>Any</option>
                            <option value="< 1950">< 1950</option>
                            <option value="1951 - 1960">1951 - 1960</option>
                            <option value="1961 - 1970">1961 - 1970</option>
                            <option value="1971 - 1980">1971 - 1980</option>
                            <option value="1981 - 1990">1981 - 1990</option>
                            <option value="1991 - 2000">1991 - 2000</option>
                            <option value="2001 - 2010">2001 - 2010</option>
                            <option value="2011 - 2020">2011 - 2020</option>
                            <option value="2021 - Now">2021 - Now</option>
                        </select>

                        <button type="submit" class="search_btn">Search</button>
                    </form>
                </div>
                <button type="submit" id="add-open-btn" onclick="OpenAdd()">Add</button>
            </div>

            <div id="film-part">
                <table>
                <?php
                while($rows=$main_result->fetch_assoc()){
                ?>

                <tr>
                    <td class="film">
                        <div>
                            <div class="title-score-part">
                                <p><?php echo $rows['title'];?></p>
                                <p><?php echo $rows['score'];?>/100</p>
                            </div>
                            <div class="synopsis-part">
                                <p><?php echo $rows['synopsis'];?></p>
                            </div>
                            <div class="genre-date-part">

                                <div class="genre-container">
                                    <?php
                                    while($genre_list=$genre_result->fetch_assoc()){
                                        if($genre_list['fk_film_id'] == $rows['film_id']){
                                    ?>
            
                                    <p class="each-genre"><?php echo $genre_list['genre'];?></p>

                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <div class="release-part">
                                    <p><?php echo $rows['release_month'];?> 
                                    <?php echo $rows['release_year'];?></p>
                                </div>
                            </div>
                        </div>
                        <div id="detail-btn-container">
                        <form action="detail-page.php" method="post">
                            <input name="film_id" type="hidden" value="<?php echo $rows['film_id'];?>">
                            <button type="submit">Details</button>
                        </form>
                        </div>
                    </td>
                </tr>

                <?php
                    $genre_result->data_Seek(0);
                }
                ?>
                </table>
            </div>
        </div>

        <div id="display-history">
            <h3 id="username-placeholder"></h3>
            <h4>Visit History</h4>
            <div id="history-list">
                <table>
                <?php
                    $count_history = 0;
                    while($_SESSION["visit_history_id"][$count_history] != ""){
                ?>

                    <tr>
                        <form action="detail-page.php" method="post">
                            <input type="hidden" name="film_id" value="<?php echo $_SESSION["visit_history_id"][$count_history]; ?>">
                            <td><button class="history-btn" type="submit"><?php echo $count_history+1;?>.</button></td>
                            <td><button class="history-btn" type="submit"><?php echo $_SESSION["visit_history_title"][$count_history];?></button></td>
                            <td><button class="history-btn" type="submit"><?php echo $_SESSION["visit_history_score"][$count_history];?>/100</button></td>
                        </form>
                    </tr>

                <?php
                        $count_history++;
                    }
                ?>
                </table>
            </div>
        </div>
    </div>

    <div id="add-container">
        <div id="add-form">
            <form action="add-film.php" method="post">
                <div id="title-add-form">
                    <h3>New Film</h3>
                    <button type="button" id="add-close-btn" onclick="CloseAdd()">X</button>
                </div>

                <label for="title"><b>Title</b><b style="color:red;">*</b></label><br>
                <input type="text" name="title" class="add-form-text" required><br>

                <label for="synopsis"><b>Synopsis</b><b style="color:red;">*</b></label><br>
                <input type="text" name="synopsis" class="add-form-text" required><br>

                <div id="genre-add-form">
                    <label><b>Genre</b><b style="color:red;">*</b></label><br>
                    <div id="genre-container">
                        <div id="genre-part-1">
                            <input type="checkbox" name="genre[]" value="Action">
                            <label for="genre">Action</label><br>
                            <input type="checkbox" name="genre[]" value="Adventure">
                            <label for="genre">Adventure</label><br>
                            <input type="checkbox" name="genre[]" value="Animation">
                            <label for="genre">Animation</label><br>
                            <input type="checkbox" name="genre[]" value="Comedy">
                            <label for="genre">Comedy</label><br>
                        </div>
                        <div id="genre-part-2">
                            <input type="checkbox" name="genre[]" value="Drama">
                            <label for="genre">Drama</label><br>
                            <input type="checkbox" name="genre[]" value="Fantasy">
                            <label for="genre">Fantasy</label><br>
                            <input type="checkbox" name="genre[]" value="Horror">
                            <label for="genre">Horror</label><br>
                            <input type="checkbox" name="genre[]" value="Romance">
                            <label for="genre">Romance</label><br>
                        </div>
                    </div>
                </div>

                <div id="date-add-form">
                    <div>
                        <label for="month"><b>Month</b><b style="color:red;">*</b></label><br>
                        <select name="month" id="month-add">
                            <option value="" selected disabled>Any</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>

                    <div>
                        <label for="year"><b>Year</b><b style="color:red;">*</b></label><br>
                        <input name="year" type="number" min="1900" max="2099" value=""/>
                    </div>
                </div>

                <label for="score"><b>Score</b><b style="color:red;">*</b></label><br>
                <input name="score" type="number" min="0" max="100" value="" class="add-form-text"/><br>

                <input type="hidden" name="user_ip" value="<?php echo $user_ip;?>">
                <input type="hidden" name="user_agent" value="<?php echo $user_agent;?>">

                <button onclick="CheckGenre()" type="button">Submit</button>

                <div id="affirm-add-container">
                    <div id="affirm-add">
                        <div>
                            <h3>Are you sure ?</h3>
                            <p>Make sure all the data is right</p>
                        </div>

                        <div>
                        <button onclick="CloseAffirmAdd()" type="button">Cancel</button>
                        <input id="add-submit-btn" type="submit" value="Submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function OpenAdd(){
            document.getElementById("add-container").style.display = "block";
            document.getElementById("add-container").style.visibility = "visible";
        }

        function CloseAdd(){
            document.getElementById("add-container").style.display = "none";
            document.getElementById("add-container").style.visibility = "hidden";
        }

        function OpenAffirmAdd(){
            document.getElementById("affirm-add-container").style.display = "block";
            document.getElementById("affirm-add-container").style.visibility = "visible";
        }

        function CloseAffirmAdd(){
            document.getElementById("affirm-add-container").style.display = "none";
            document.getElementById("affirm-add-container").style.visibility = "hidden";
        }

        function CheckGenre(){
            var checked = document.querySelectorAll('[name="genre[]"]:checked');

            if(checked.length > 0){
                OpenAffirmAdd();
            }else{
                alert("Atleast one genre must be choose");
            }
        }

        function MakeCookie(cookie_name, cookie_value, expires_days){
            const date = new Date();
            date.setTime(date.getTime()+(expires_days*24*60));
            let expires = "expires="+date.toUTCString();
            document.cookie = cookie_name + "=" + cookie_value + ";" + expires + ";path=/";
        }

        function GetCookie(cookie_name){
            let name = cookie_name + "=";
            let ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        
        function CheckCookie() {
            let user = GetCookie("username");

            if(user != "") {
                document.getElementById("username-placeholder").innerHTML = "Hello, " + user;
            }else{
                user = prompt("Please enter your name:", "");
                if (user != "" && user != null) {
                MakeCookie("username", user, 1);
                }
            }
        }
    </script>


</body>
</html>