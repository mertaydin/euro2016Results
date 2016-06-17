<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-79527928-1', 'auto');
        ga('send', 'pageview');

    </script>
    
</head>
<body>

<?php

include_once "base.php";


$data = getFootBallData(null, $_GET['url']);
$result = [];

foreach ($data->fixtures as $index => $row) {
    $result[$index]["date"] = $row->date;
    $result[$index]["status"] = $row->status;
    $result[$index]["homeTeamName"] = $row->homeTeamName;
    $result[$index]["awayTeamName"] = $row->awayTeamName;
    $result[$index]["result"]["goalsHomeTeam"] = $row->result->goalsHomeTeam;
    $result[$index]["result"]["goalsAwayTeam"] = $row->result->goalsAwayTeam;
    $result[$index]["result"]["halfTime"]["goalsHomeTeam"] = isset($row->result->halfTime->goalsHomeTeam) ? $row->result->halfTime->goalsHomeTeam : '' ;
    $result[$index]["result"]["halfTime"]["goalsAwayTeam"] = isset($row->result->halfTime->goalsAwayTeam) ? $row->result->halfTime->goalsAwayTeam : '';

    $result[$index]["links"]["selfhref"] = $row->_links->self->href;
    $result[$index]["links"]["soccerseason"] = $row->_links->soccerseason->href;
    $result[$index]["links"]["homeTeam"] = $row->_links->homeTeam->href;
    $result[$index]["links"]["awayTeam"] = $row->_links->awayTeam->href;
}

?>

<table border="1">
    <tr>
        <td>Tarih</td>
        <td>Durum</td>
        <td>Ev Sahibi</td>
        <td>Misafir</td>
        <td>Sonuç</td>
        <td>İlk Yarı Sonuç</td>
    </tr>

    <?php foreach ($result as $index => $row) { ?>
    <tr>
        <td><?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></td>
        <td><?php echo $time_params[$row['status']]; ?></td>
        <td><?php echo $teams_array[$row['homeTeamName']]; ?></td>
        <td><?php echo $teams_array[$row['awayTeamName']]; ?></td>
        <td><?php echo $row["result"]["goalsHomeTeam"] . " - " . $row["result"]["goalsAwayTeam"] ?></td>
        <td><?php echo $row["result"]["halfTime"]["goalsHomeTeam"] . " - " . $row["result"]["halfTime"]["goalsAwayTeam"] ?></td>
    </tr>
    <?php } ?>
</table>
<?php
echo '<a href="/euro2016">Ana sayfa</a>';
?>


</body>
</html>