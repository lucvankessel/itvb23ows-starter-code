<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if (!isset($_SESSION)) {
        session_start(); 
    }

    require_once 'src/utils/util.php';
    require_once 'src/db/database.php';
    require_once 'src/game_rules/insect.php';
    require_once 'src/game/play.php';

    use db\connection;
    use \insects;
    use game\play;

    if (!isset($_SESSION['board'])) {
        header('Location: src/api/restart.php');
        exit(0);
    }

    $board = $_SESSION['board'];
    $player = $_SESSION['player'];
    $hand = $_SESSION['hand'];

    $to = insects\find_contour($board);
    if (!count($to)) $to[] = '0,0';

    $win_var = insects\is_win($board);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hive</title>
        <style>
            div.board {
                width: 60%;
                height: 100%;
                min-height: 500px;
                float: left;
                overflow: scroll;
                position: relative;
            }

            div.board div.tile {
                position: absolute;
            }

            div.tile {
                display: inline-block;
                width: 4em;
                height: 4em;
                border: 1px solid black;
                box-sizing: border-box;
                font-size: 50%;
                padding: 2px;
            }

            div.tile span {
                display: block;
                width: 100%;
                text-align: center;
                font-size: 200%;
            }

            div.player0 {
                color: black;
                background: white;
            }

            div.player1 {
                color: white;
                background: black
            }

            div.stacked {
                border-width: 3px;
                border-color: red;
                padding: 0;
            }
        </style>

        <!-- Jquery ftw -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>
    <body>
        <div class="board">
            <?php
                $min_p = 1000;
                $min_q = 1000;
                foreach ($board as $pos => $tile) {
                    $pq = explode(',', $pos);
                    if ($pq[0] < $min_p) $min_p = $pq[0];
                    if ($pq[1] < $min_q) $min_q = $pq[1];
                }
                foreach (array_filter($board) as $pos => $tile) {
                    $pq = explode(',', $pos);
                    $pq[0];
                    $pq[1];
                    $h = count($tile);
                    echo '<div class="tile player';
                    echo $tile[$h-1][0];
                    if ($h > 1) echo ' stacked';
                    echo '" style="left: ';
                    echo ($pq[0] - $min_p) * 4 + ($pq[1] - $min_q) * 2;
                    echo 'em; top: ';
                    echo ($pq[1] - $min_q) * 4;
                    echo "em;\">($pq[0],$pq[1])<span>";
                    echo $tile[$h-1][1];
                    echo '</span></div>';
                }
            ?>
        </div>
        <div class="hand">
            White:
            <?php
                foreach ($hand[0] as $tile => $ct) {
                    for ($i = 0; $i < $ct; $i++) {
                        echo '<div class="tile player0"><span>'.$tile."</span></div> ";
                    }
                }
            ?>
        </div>
        <div class="hand">
            Black:
            <?php
            foreach ($hand[1] as $tile => $ct) {
                for ($i = 0; $i < $ct; $i++) {
                    echo '<div class="tile player1"><span>'.$tile."</span></div> ";
                }
            }
            ?>
        </div>
        <div class="turn">
            Turn: <?php if ($player == 0) echo "White"; else echo "Black"; ?>
        </div>

        <form method="post" action="src/api/play.php">
            <select name="piece">
                <?php
                    foreach( $hand[$player] as $title => $ct ) {
                        if ($ct > 0) {
                            echo "<option value=\"$title\">$title</option>";
                        }
                    }
                ?>
            </select>
            <select name="to">
                <?php
                    foreach ($to as $pos) {
                        if(play\isValidPlayTile($board, $hand[$player], $player, $pos)) {
                            echo "<option value=\"$pos\">$pos</option>";
                        }
                    }
                ?>
            </select>
            <input type="submit" value="Play" id="play-btn">
        </form>

        <form method="POST" action="src/api/move.php">
            <select name="from" id="select-move-from">
                <?php
                    foreach (array_keys($board) as $pos) {
                        if ($board[$pos][0][0] != $player) {
                            continue;
                        }

                        echo "<option value=\"$pos\">$pos</option>";
                    }
                ?>
            </select>
            <select name="to" id="select-move-to">
                    <!-- is filled according to what is selected in the from select above. and is done through javascript -->
            </select>
            <input type="submit" value="Move" id="move-btn">
        </form>

        <form method="POST" action="src/api/pass.php">
            <input type="submit" value="Pass" id="pass-btn">
        </form>

        <form method="POST" action="src/api/restart.php">
            <input type="submit" value="Restart" id="restart-btn">
        </form>

        <strong><?php if (isset($_SESSION['error'])) echo($_SESSION['error']); unset($_SESSION['error']); ?></strong>
        
        <ol>
            <?php
                $db = connection\database::getInstance()->get_connection();
                $stmt = $db->prepare('SELECT * FROM moves WHERE game_id = ?');
                $stmt->execute([$_SESSION['game_id']]);
                $result = $stmt->fetchall(PDO::FETCH_ASSOC);
                foreach($result as $key=>$row) {
                    echo '<li>'.$row['type'].' '.$row['move_from'].' '.$row['move_to'].'</li>';
                }
            ?>
        </ol>

        <form method="POST" action="src/api/ai_player.php">
            <input type="submit" value="Ai move" id="ai-btn">
        </form>

        <form method="POST" action="src/api/undo.php">
            <input type="submit" value="Undo" id="undo-btn">
        </form>

    </body>

    <script>
    $(document).ready(function() {

        var win_var = <?php echo $win_var ?>;
        console.log(win_var)
        if (win_var != 0) {
            switch(win_var) {
                case 1:
                    alert("white wins!");
                    break;
                case 2:
                    alert("black wins!");
                    break;
                case 3:
                    alert("Draw!");
                    break;
            }
            document.getElementById("play-btn").style.display = "none"
            document.getElementById("move-btn").style.display = "none"
            document.getElementById("undo-btn").style.display = "none"
            document.getElementById("ai-btn").style.display = "none"
            document.getElementById("pass-btn").style.display = "none"
        }

        function updateOptions(selectedValue) {
            $.ajax({
                url: "http://localhost:8000/src/api/get_options.php",
                type: "POST",
                data: { from: selectedValue },
                dataType: "json",
                success: function(options) {
                    updateSelectOptions(options);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching options:", error);
                }
            });
        }

        function updateSelectOptions(options) {
            var selectTo = $("#select-move-to");

            selectTo.empty();

            $.each(options, function(index, value) {
                selectTo.append($("<option></option>")
                    .attr("value", value)
                    .text(value));
            });
        }

        $("#select-move-from").change(function() {
            var selectedValue = $(this).val();
            updateOptions(selectedValue);
        });

        // Make an initial AJAX request when the page is loaded
        var initialSelectedValue = $("#select-move-from").val();
        updateOptions(initialSelectedValue);

    });
</script>

</html>

