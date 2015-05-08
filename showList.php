<?php
    require_once('server.php');

    ////////////////////////////////////////////////////////////
    // Here, we make a call to the /instances API to retrieve //
    // the list of instances. Below, we filter out the display//
    // of any instances that do not have a key of 'box'       //
    ////////////////////////////////////////////////////////////
    $result = $CallAPI('GET', 'instances');
    $_SESSION['instances'] = json_decode($result);
?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>

<div class="jumbotron">
    <div class="container">
        <table class="table table-striped">
            <thead>
                <th>Id</th>
                <th>Instance Name</th>
                <th>Token</th>
            </thead>
            <tbody>
                <?php
                    foreach($_SESSION['instances'] as $object) {
                        if($object->element->key == 'box') {
                            echo '<tr><td>' . $object->id . '</td>' .
                                '<td>' . $object->name . '</td>' .
                                '<td>' . $object->token . '</td></tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>