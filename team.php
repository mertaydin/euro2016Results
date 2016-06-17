<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<?php

include_once "base.php";


$data = getFootBallData(null, $_GET['url']);

echo '<h1> Takım Adı</h1>';
echo $data->name;
echo "<br>";
echo '<h1> Takım Bayrağı</h1>';
echo '<img width="150" height="150" src="' . $data->crestUrl . '">';

echo '<a href="/euro2016">Ana sayfa</a>';

?>
</body>
</html>