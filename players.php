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

print_r(getFootBallData(null, $_GET['url']));

?>
</body>
</html>