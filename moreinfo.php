<html>
    <head>
        <title>NBA Query</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
    </head>
    <body>
        <section class="section is-fullheight is-bold is-dark">
            <div class="container">
                <h1 class="title">
                    Search Results
                </h1>
                <?php
                    //defines the 4 variables needed to create a database link
                    $host = "localhost";
                    $user = "nbalegends";
                    $password = "inf385";
                    $database = "nbalegends";

                    //creates a link to the MySQL database through the mysqli_connect command
                    //mysqli_connect command needs the four inputs of the host, username, password, and database name
                    $link = mysqli_connect($host, $user, $password, $database);

                    // get player name and team name
                    $player_name = isset($_GET['player_name']) ? $_GET['player_name'] : "";
                    $team_name = isset($_GET['team_name']) ? $_GET['team_name'] : "";

                    //sanitizes the variables
                    $player_name = preg_replace("/ [^0-9a-zA-Z]+/", "", $player_name);
                    $team_name = preg_replace("/ [^0-9a-zA-Z]+/", "", $team_name);

                    $searchq;

                    // if input is player_name
                    if (isset($_GET['player_name'])) {
                        $searchq = "SELECT
                            Player_Team.pt_id,
                            Player_Team.player_id,
                            Player_Team.pt_abbreviation,
                            Team.team_name
                        
                        FROM Player_Team
                            LEFT JOIN Team on Player_Team.pt_abbreviation = Team.team_abbreviation
                            LEFT JOIN (SELECT Player.player_id, Player.player_name, Player.nickname from Player) sq on Player_Team.player_id = sq.player_id
                        
                        WHERE
                            -- we may want to adjust this to ensure that the list of teams is shown for only the player selected (are we doing links to another page?)
                            sq.player_name LIKE '%$player_name%'
                            OR sq.nickname LIKE '%$player_name%'
                        
                        -- we will need to figure out how to format the multiple rows of teams for each single player name (array?)
                        GROUP BY Player_Team.pt_id";

                        //creates the query and link relationship that will be passed through
                        $listresult = mysqli_query($link, $searchq);

                        //creates the variable row and assigns it to the array formed from the MySQL query
                        echo "<h2 class='title'>$player_name were in these teams: </h2>";
                        echo "<br/>";
                        echo '<table class="table is-striped is-fullwidth">';
                        echo '<tbody>';
                        echo "<tr>";
                        echo "<td>";
                        echo "Team Name";
                        echo "</td>";
                        echo "<td>";
                        echo "Team Name Abbreviation";
                        echo "</td>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_array($listresult)) {
                            echo "<tr>";
                            echo "<td>";
                            echo "$row[team_name]";
                            echo "</td>";
                            echo "<td>";
                            echo "$row[pt_abbreviation]";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo '</tbody>';
                        echo '</table>';



                    // the input is team_name
                    } else if (isset($_GET['team_name'])) {
                        $searchq = "SELECT
                            Player_Team.pt_id,
                            Team.team_name,
                            Team.team_abbreviation,
                            sq.player_name,
                            sq.nickname,
                            sq.championships,
                            sq.mvps,
                            sq.all_star_suggestions

                            FROM Player_Team
                            LEFT JOIN Team on Player_Team.pt_abbreviation = Team.team_abbreviation
                            LEFT JOIN (SELECT Player.player_id, Player.player_name, Player.nickname, Player.championships, Player.mvps, Player.all_star_suggestions from Player) sq on Player_Team.player_id = sq.player_id
                            
                            WHERE
                            Team.team_name LIKE '$team_name'
                            OR Player_Team.pt_abbreviation LIKE '$team_name'
                            
                            -- we will need to figure out how to format the multiple rows of player names for each single team (array?)
                            GROUP BY Player_Team.pt_id";

                        //creates the query and link relationship that will be passed through
                        $listresult = mysqli_query($link, $searchq);

                        //creates the variable row and assigns it to the array formed from the MySQL query
                        echo "<h2 class='title'>$team_name has these players: </h2>";
                        echo '<table class="table is-striped is-fullwidth">';
                        echo '<tbody>';
                        echo "<tr>";
                        echo "<td>";
                        echo "Player Name";
                        echo "</td>";
                        echo "<td>";
                        echo "Nick Name";
                        echo "</td>";
                        echo "<td>";
                        echo "Championships";
                        echo "</td>";
                        echo "<td>";
                        echo "MVPs";
                        echo "</td>";
                        echo "<td>";
                        echo "All Star Suggestions";
                        echo "</td>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_array($listresult)) {
                            echo "<tr>";
                            echo "<td>";
                            echo "$row[player_name]";
                            echo "</td>";
                            echo "<td>";
                            echo "$row[nickname]";
                            echo "</td>";
                            echo "<td>";
                            echo "$row[championships]";
                            echo "</td>";
                            echo "<td>";
                            echo "$row[mvps]";
                            echo "</td>";
                            echo "<td>";
                            echo "$row[all_star_suggestions]";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo '</tbody>';
                        echo '</table>';
                    }


                    //closes the MySQL link
                    mysqli_close($link);
                ?>
            </div>
        </section>
    </body>
</html>
