<?php
     require_once('server.php');

    ////////////////////////////////////////////////////////////
    // We will be using sessions to help transfer some of the //
    // data into the template and for access later on after   //
    // the redirect from Box                                  //
    ////////////////////////////////////////////////////////////
    session_start();

    ////////////////////////////////////////////////////////////
    // The following $apiKey, $apiSec, and $callbackUrl are   //
    // on the Box developer page [http://developers.box.com   //
    ////////////////////////////////////////////////////////////
    $apikey = 'enter box client_id';
    $apiSec = 'enter box client_secret';
    $callbackUrl = 'http://127.0.0.1:8080/index.php';

    $queryParams = "?apiKey={$apikey}&apiSecret={$apiSec}&callbackUrl={$callbackUrl}";

    ////////////////////////////////////////////////////////////
    // The following is for when we return from Box Oauth     //
    // and prepare the proper data array to send to the API   //
    ////////////////////////////////////////////////////////////
    $provisionInstance = array(
        'name' => '',
        'element' => array(
            'key' => ''
        ),
        'providerData' => array(
            'code' => ''
        ),
        'configuration' => array(
            'document.tagging' => true,
            'oauth.api.key' => $apikey,
            'oauth.api.secret' => $apiSec,
            'oauth.callback.url' => $callbackUrl
        )
    );

    //////////////////////////////////////////////////////////////////
    // $CallAPI is our server -> REST server function in server.php //
    //////////////////////////////////////////////////////////////////
    $data = json_decode($CallAPI('GET', "/elements/box/oauth/url{$queryParams}"));

    ////////////////////////////////////////////////////////////
    // Here, we add the oauthUrl field from Cloud-Elements    //
    // payload for use further down in the template, to make  //
    // sure we provide the proper url to Box OAuth            //
    ////////////////////////////////////////////////////////////
    $_SESSION["oauthUrl"] = $data->{"oauthUrl"};

    ///////////////////////////////////////////////////////////
    // When Box returns to the provided redirect url, it will//
    // pass query parameters to us, which we use below to    //
    // render the page with different text, and begin        //
    // building our POST payload for the Cloud-Elements API  //
    ///////////////////////////////////////////////////////////
    if (isset($_REQUEST['code'], $_REQUEST['state'])) {

        $provisionInstance['element']['key'] = $_REQUEST['state'];
        $provisionInstance['providerData']['code'] = $_REQUEST['code'];
        $provisionInstance['name'] = 'myUserInstance' . rand();

        //////////////////////////////////////////////////////////
        // Here, we make a POST call to the /instances API with //
        // the $provisionInstance array we prepared above.      //
        //////////////////////////////////////////////////////////
        $result = json_decode($CallAPI('POST', 'instances', json_encode($provisionInstance)));

        // Error check the result, ensure a 'name' field is returned
        if (isset($result->name)) {

            // Store the result to the session, and redirect to the
            // page that lists the accounts
            $_SESSION['boxDetails'] = $result;
            header('Location: http://127.0.0.1:8080/showList.php');
        }
    }
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
          <?php
            if (isset($_REQUEST['code'], $_REQUEST['state'])) {
                echo '<h1>Connected to your Box Account!</h1>'
                . '<p>Creating an instance of your account on the application.</p>';
            }
            else {
                echo '<h1>Add Your Box Account!</h1>'
                . '<p>Click on "Add Box Account" and follow the instructions to connect to your Box account.</p>' //
                . '<p><a class="btn btn-primary btn-lg" href="' . $_SESSION["oauthUrl"] . '" role=\"button\">Add Box Account &raquo;</a></p>';
            }
          ?>
      </div>
    </div>
    <script src="js/vendor/bootstrap.min.js"></script>
    </body>
</html>
