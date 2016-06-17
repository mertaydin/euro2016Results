<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <style>
        .name {
            vertical-align: middle;
        }

        .floatLeft {
            float: left;
        }
        .container {
            border: 1px solid #00a6fd;
            width: 135px;
            height:170px;
            margin-right:10px;
            margin-bottom:10px;
            text-align: center;
        }
        .container2 {
            border: 1px solid #00a6fd;
            width: 450px;
            height:210px;
            margin-right:10px;
            margin-bottom:10px;
            text-align: center;
        }
        .center {
            text-align: center;
            font-size: 25px;
        }
        .links {
            padding-top: 10px;
        }
        .clear {
            clear: both;
        }
    </style>

</head>
<body>

<?php
include_once "base.php";

$cachedosyasi = "caches/".convertToSef($_SERVER['REQUEST_URI']).".mrt";
if (file_exists($cachedosyasi) && (time() - 180 < filemtime($cachedosyasi))) {
    include($cachedosyasi);
    exit;
}
ob_start();

$teams_data = getFootBallData("teams");
$teams = array();


foreach ($teams_data->teams as $row) {
    $teams[$row->name]['name'] = $row->name;
    $teams[$row->name]['code'] = $row->code;
    $teams[$row->name]['flag'] = $row->crestUrl;
    $teams[$row->name]["selfUrl"] = $row->_links->self->href;
    $teams[$row->name]["fixtures"] = $row->_links->fixtures->href;
    $teams[$row->name]["players"] = $row->_links->players->href;
}

$groups_data = getFootBallData("leagueTable");
$groups= array();
foreach ($groups_data->standings as $row) {
    foreach ($row as $index => $_row) {
        $groups[$_row->group][$index]["group"] = $_row->group;
        $groups[$_row->group][$index]["rank"] = $_row->rank;
        $groups[$_row->group][$index]["team"] = $_row->team;
        $groups[$_row->group][$index]["teamId"] = $_row->teamId;
        $groups[$_row->group][$index]["playedGames"] = $_row->playedGames;
        $groups[$_row->group][$index]["crestURI"] = $_row->crestURI;
        $groups[$_row->group][$index]["points"] = $_row->points;
        $groups[$_row->group][$index]["goals"] = $_row->goals;
        $groups[$_row->group][$index]["goalsAgainst"] = $_row->goalsAgainst;
        $groups[$_row->group][$index]["goalDifference"] = $_row->goalDifference;
    }
}

$today_matches = array();
foreach ($teams as $row) {
    $data = getFootBallData(null, $row['fixtures']);

    foreach ($data->fixtures as $_row) {
        if (strtotime(date('d-m-Y')) == strtotime(date('d-m-Y', strtotime($_row->date))))
        {
            $today_matches[$_row->homeTeamName.$_row->awayTeamName] = $_row;
        }
    }
}

?>


<h2 class="center">Gruplar</h2>
<?php


/*foreach ($groups as $_row) {
    echo '<div class="container floatLeft">';
    echo '<div class="team-box floatLeft">';
    echo "<b>" . $_row[0]['group'] . " Grubu</b>";
        foreach ($_row as $__row) {
            echo '<ul>';
            echo '<li>' . $__row['team'];
            echo '</ul>';
        }
    echo '</div>';
    echo '</div>';
}*/

foreach ($groups as $_row) {
    echo '<div class="container2 floatLeft">';
    echo '<div class="container2 floatLeft">';
    echo "<b>" . $_row[0]['group'] . " Grubu</b>";

    echo '<table border="1">';
    echo '<tr>';
    echo '<td>&nbsp;bayrak</td>';
    echo '<td>Sıra</td>';
    echo '<td>Adı</td>';
    echo '<td>Oyn.</td>';
    echo '<td>A. Gol</td>';
    echo '<td>Y. Gol</td>';
    echo '<td>Averaj</td>';
    echo '<td>Puan</td>';
    echo '</tr>';
    foreach ($_row as $__row) {
            echo '<tr style="text-align: center;">';
                echo '<td><img width="30" height="30" src="' . $__row['crestURI'] . '"></td>';
                echo '<td>' . $__row['rank']. '</td>';
                echo '<td>' . $__row['team'] . '</td>';
                echo '<td>' . $__row['playedGames'] . '</td>';
                echo '<td>' . $__row['goals'] . '</td>';
                echo '<td>' . $__row['goalsAgainst'] . '</td>';
                echo '<td>' . $__row['goalDifference'] . '</td>';
                echo '<td>' . $__row['points'] . '</td>';
    }
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
}


?>

<div class="clear"></div>

<h2 class="center">Bu güne ait maçlar</h2>
<table border="1">
    <tr>
        <td>Tarih</td>
        <td>Durum</td>
        <td>Ev Sahibi</td>
        <td>Misafir</td>
        <td>Sonuç</td>
        <td>İlk Yarı Sonuç</td>
    </tr>

    <?php foreach ($today_matches as $index => $row) { ?>
        <tr>
            <td><?php echo date('d-m-Y H:i', strtotime($row->date)); ?></td>
            <td><?php echo $time_params[$row->status]; ?></td>
            <td><?php echo $row->homeTeamName; ?></td>
            <td><?php echo $row->awayTeamName; ?></td>
            <td><?php echo isset($row->result->goalsHomeTeam) ? $row->result->goalsHomeTeam : '' . " - " . isset($row->result->goalsAwayTeam) ? $row->result->goalsAwayTeam : '' ?></td>
            <td><?php echo (isset($row->result->halfTime) ? $row->result->halfTime->goalsHomeTeam : '') . " - " . (isset($row->result->halfTime) ? $row->result->halfTime->goalsAwayTeam : '') ?></td>
        </tr>
    <?php } ?>
</table>
<?php
echo '<a href="/euro2016">Ana sayfa</a>';
?>

<div class="clear"></div>


<h2 class="center">Takımlar</h2>
<?php
foreach ($teams as $row) {

    echo '<div class="container floatLeft">';
    echo '<div class="team-box floatLeft">';
    echo '<div class="name">';
    echo $row['name'];
        echo '</div>';
        echo '<div class="flag">';
            echo '<img width="75" height="75" src="' . $row['flag'] . '">';
        echo '</div>';
        echo '<div class="links">';
            echo '<a href="teams.php?url=' . $row['selfUrl'] .'">Takım URL</a><br>';
            echo '<a href="fixtures.php?url=' . $row['fixtures'] .'">Fikstür URL</a><br>';
            echo '<a href="players.php?url=' . $row['players'] .'">Oyuncular URL</a>';
        echo '</div>';
    echo '</div>';
echo '</div>';
}
?>


</body>
</html>
<?php
$ch = fopen($cachedosyasi, 'w');
fwrite($ch, ob_get_contents());
fclose($ch);
ob_end_flush();
?>