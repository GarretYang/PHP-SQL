<html>
	<head>
        <title>NBA Query</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
	</head>
	<body>
        <?php
            $host = "localhost";
            $user = "nbalegends";
            $password = "inf385";
            $database = "nbalegends";

            //creates a link to the MySQL database through the mysqli_connect command
            //mysqli_connect command needs the four inputs of the host, username, password, and database name
            $link = mysqli_connect($host, $user, $password, $database);
        ?>

        <section class="hero is-fullheight is-bold is-dark">
          
            <!-- Hero content: will be in the middle -->
            <div class="hero-body">
              <div class="container has-text-centered">
                <h1 class="title">
                    NBA Legends
                </h1>
                <div class="field">
                    <div class="tabs is-centered is-toggle">
                        <ul>
                          <li class="tablink is-active" id="Team" onclick="openTab(event, 'Team')"><a>Team</a></li>
                          <li class="tablink" id="Player" onclick="openTab(event, 'Player')"><a>Player</a></li>
                          <li class="tablink" id="Position" onclick="openTab(event, 'Position')"><a>Position</a></li>
                          <li class="tablink" id="Filter" onclick="openTab(event, 'Filter')"><a>Filter</a></li>
                        </ul>
                    </div>

                    <form method="GET" action="">
                        <div class="tabcontent" id="Team">
                            <input class="input is-info" type="text" placeholder="Enter a team name" name="TeamInput" style="width: 30%;">
                            <input class="button is-light" type="submit" name="TeamSubmit"/>
                        </div>
                    </form>

                    <form method="GET" action="">
                        <div class="tabcontent" id="Player" style="display: none;">
                            <input class="input is-info" type="text" placeholder="Enter a player name" name="PlayerInput" style="width: 30%;">
                            <input class="button is-light" type="submit" name="PlayerSubmit"/>
                        </div>
                    </from>


                    <form method="GET" action="">
                        <div class="tabcontent" id="Position" style="display: none;">
                            <div class="select">
                                <select name="selections">
                                    <option>-</option>
                                    <option>C</option>
                                    <option>SG</option>
                                    <option>SF</option>
                                    <option>PF</option>
                                </select>
                            </div>
                            <input class="button is-light" type="submit" value="Search" name="PositionSubmit"/>
                        </div>
                    </from>

                    <form method="GET" action="">
                        <div class="tabcontent" id="Filter" style="display: none;">
                            <div>
                                <text style="padding-right: 1%;">PPG range</text>
                                <input class="input is-info" type="text" placeholder="Min" style="width: 10%;" name="ppgmin">
                                <input class="input is-info" type="text" placeholder="Max" style="width: 10%;" name="ppgmax">
                            </div>
                            <br/>
                            <div>
                                <text style="padding-right: 1%;">RPG range</text>
                                <input class="input is-info" type="text" placeholder="Min" style="width: 10%;" name="rpgmin">
                                <input class="input is-info" type="text" placeholder="Max" style="width: 10%;" name="rpgmax">
                            </div>
                            <br/>
                            <div>
                                <text style="padding-right: 1%;">APG range</text>
                                <input class="input is-info" type="text" placeholder="Min" style="width: 10%;" name="apgmin">
                                <input class="input is-info" type="text" placeholder="Max" style="width: 10%;" name="apgmax">
                            </div>
                            <br/>
                            <input class="button is-light" type="submit" value="Search" name="FilterSubmit"/>
                        </div>
                    </from>
                </div>
                <div class="columns is-variable is-1-mobile is-0-tablet is-3-desktop is-multiline">
                    <?php

                        if (isset($_GET['TeamInput']) && isset($_GET['TeamSubmit'])) {
                            $teamName = $_GET['TeamInput'];

                            $teamName = preg_replace("/[^ 0-9a-zA-Z]+/", "", $teamName);
                            
                            $searchq = "SELECT * FROM Team WHERE team_abbreviation LIKE '%$teamName%' OR team_name LIKE '%$teamName%' GROUP BY
                            team_id";

                            $listresult = mysqli_query($link, $searchq);

                            while ($row = mysqli_fetch_array($listresult)) {

                                echo '<div class="column is-one-quarter">';
                                echo '<div class="card">';
                                echo '<header class="card-header">';
                                echo '<p class="card-header-title">';
                                echo "$row[team_abbreviation]";
                                echo '</p>';           
                                echo '</header>';
                                echo '<div class="card-content">';
                                echo '<div class="content">';
                                echo "$row[team_name]";
                                echo "<br/>";
                                echo "<a href='moreinfo.php?team_name=$row[team_name]' >";
                                echo "More";
                                echo "</a>";
                                echo "<br/>";
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            mysqli_close($link);
                        }
                    ?>

                    <?php

                        if (isset($_GET['PlayerInput']) && isset($_GET['PlayerSubmit'])) {
                            $playerName = $_GET['PlayerInput'];

                            $playerName = preg_replace("/ [^0-9a-zA-Z]+/", "", $playerName);
                            
                            $searchq = "SELECT * FROM Player WHERE player_name LIKE '%$playerName%' OR nickname LIKE '%$playerName%'";

                            $listresult = mysqli_query($link, $searchq);

                            while ($row = mysqli_fetch_array($listresult)) {

                                echo '<div class="column is-one-quarter">';
                                echo '<div class="card">';
                                echo '<header class="card-header">';
                                echo '<p class="card-header-title">';
                                echo "$row[player_name] ($row[nickname])";
                                echo '</p>';           
                                echo '</header>';
                                echo '<div class="card-content">';
                                echo '<div class="content">';
                                echo "ppg: ";
                                echo "$row[ppg]";
                                echo "<br/>";
                                echo "rpg: ";
                                echo "$row[rpg]";
                                echo "<br/>";
                                echo "apg: ";
                                echo "$row[apg]";
                                echo "<br/>";
                                echo "<a href='moreinfo.php?player_name=$row[player_name]' >";
                                echo "More";
                                echo "</a>";
                                echo "<br/>";
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }

                            mysqli_close($link);
                        }
                    ?>

                    <!-- Fetch the data for Position inputs -->
                    <?php

                        if (isset($_GET['selections']) && isset($_GET['PositionSubmit'])) {
                            $selectType = $_GET['selections'];

                            $selectType = preg_replace("/[^ 0-9a-zA-Z]+/", "", $selectType);
                            
                            $searchq = 
                                "SELECT
                                    Player.player_id,
                                    Player.player_name,
                                    Player.ppg,
                                    Player.rpg,
                                    Player.apg,
                                    Player.fg_percent,
                                    Player.ft_percent,
                                    Player.all_star_suggestions,
                                    Player.mvps,
                                    Player.all_nba_teams,
                                    Player.championships,
                                    Player.nickname,
                                    Player.position
                            
                                    FROM Player
                            
                                    WHERE
                                        Player.position LIKE '$selectType'";

                            $listresult = mysqli_query($link, $searchq);

                            while ($row = mysqli_fetch_array($listresult)) {

                                echo '<div class="column is-one-quarter">';
                                echo '<div class="card">';
                                echo '<header class="card-header">';
                                echo '<p class="card-header-title">';
                                echo "$row[player_name] ($row[nickname])";
                                echo '</p>';           
                                echo '</header>';
                                echo '<div class="card-content">';
                                echo '<div class="content">';
                                echo "ppg: ";
                                echo "$row[ppg]";
                                echo "<br/>";
                                echo "rpg: ";
                                echo "$row[rpg]";
                                echo "<br/>";
                                echo "apg: ";
                                echo "$row[apg]";
                                echo "<br/>";
                                echo "position: ";
                                echo "$row[position]";
                                echo "<br/>";
                                echo "<a href='moreinfo.php?player_name=$row[player_name]' >";
                                echo "More";
                                echo "</a>";
                                echo "<br/>";
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            mysqli_close($link);
                        }
                    ?>

                    <!-- Fetch the data for Position inputs -->
                    <?php

                        if ((isset($_GET['ppgmin']) && isset($_GET['FilterSubmit'])) ||
                            (isset($_GET['rpgmin']) && isset($_GET['FilterSubmit'])) ||
                            (isset($_GET['apgmin']) && isset($_GET['FilterSubmit'])) ||
                            (isset($_GET['ppgmax']) && isset($_GET['FilterSubmit'])) ||
                            (isset($_GET['rpgmax']) && isset($_GET['FilterSubmit'])) ||
                            (isset($_GET['apgmax']) && isset($_GET['FilterSubmit'])) 
                        ) {
                            $ppgmin = !empty($_GET['ppgmin']) ? $_GET['ppgmin'] : 0;
                            $rpgmin = !empty($_GET['rpgmin']) ? $_GET['rpgmin'] : 0;
                            $apgmin = !empty($_GET['apgmin']) ? $_GET['apgmin'] : 0;
                            $ppgmax = !empty($_GET['ppgmax']) ? $_GET['ppgmax'] : 100;
                            $rpgmax = !empty($_GET['rpgmax']) ? $_GET['rpgmax'] : 100;
                            $apgmax = !empty($_GET['apgmax']) ? $_GET['apgmax'] : 100;

                            // $selectType = preg_replace("/[^ 0-9a-zA-Z]+/", "", $selectType);
                            
                            $searchq = 
                                "SELECT
                                    Player.player_id,
                                    Player.player_name,
                                    Player.ppg,
                                    Player.rpg,
                                    Player.apg,
                                    Player.fg_percent,
                                    Player.ft_percent,
                                    Player.all_star_suggestions,
                                    Player.mvps,
                                    Player.all_nba_teams,
                                    Player.championships,
                                    Player.nickname,
                                    Player.position
                                
                                FROM Player
                                
                                WHERE
                                    (Player.ppg >= '$ppgmin' AND Player.ppg <= '$ppgmax')
                                    AND (Player.rpg >= '$rpgmin' AND Player.rpg <= '$rpgmax')
                                    AND (Player.apg >= '$apgmin' AND Player.apg <= '$apgmax')";
                          

                            $listresult = mysqli_query($link, $searchq);

                            while ($row = mysqli_fetch_array($listresult)) {

                                echo '<div class="column is-one-quarter">';
                                echo '<div class="card">';
                                echo '<header class="card-header">';
                                echo '<p class="card-header-title">';
                                echo "$row[player_name] ($row[nickname])";
                                echo '</p>';           
                                echo '</header>';
                                echo '<div class="card-content">';
                                echo '<div class="content">';
                                echo "ppg: ";
                                echo "$row[ppg]";
                                echo "<br/>";
                                echo "rpg: ";
                                echo "$row[rpg]";
                                echo "<br/>";
                                echo "apg: ";
                                echo "$row[apg]";
                                echo "<br/>";
                                echo "<a href='moreinfo.php?player_name=$row[player_name]' >";
                                echo "More";
                                echo "</a>";
                                echo "<br/>";
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            mysqli_close($link);
                        }
                    ?>
                </div>
          </section>

          <script>
              function openTab(evt, tabName) {
                var tablinks = document.getElementsByClassName("tablink");
                var tabcontents = document.getElementsByClassName("tabcontent");
                for (var i = 0; i < tablinks.length; i++) {
                    if (tablinks[i].id !== tabName) {
                        tablinks[i].classList.remove("is-active");
                        tabcontents[i].style.display = "none";
                    } else {
                        tablinks[i].classList.add("is-active");
                        tabcontents[i].style.display = "block";
                    }
                }
              }

            //   $(document).ready(function () {
            //     $("li").click(function () {
            //         var id = $(this).attr("id");

            //         $('#' + id).siblings().find(".is-active").removeClass("is-active");
            //         $('#' + id).addClass("is-active");
            //         localStorage.setItem("selectedolditem", id);
            //     });

            //     var selectedolditem = localStorage.getItem('selectedolditem');

            //     if (selectedolditem != null) {
            //         $('#' + selectedolditem).siblings().find(".is-active").removeClass("is-active");
            //         $('#' + selectedolditem).addClass("is-active");
            //     }
            // });
          </script>
	</body>
</html>
