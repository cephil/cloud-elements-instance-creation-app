<?php

    //////////////////////////////////////////////////////////////////////////////////
    // NOTE: The 'User Secret ($uSec)' and 'Organization Secret($oSec)' variables   //
    // should ideally be coming from a database, and not hardcorded as shown below. //
    //////////////////////////////////////////////////////////////////////////////////

    $baseUrl = 'https://console.cloud-elements.com/elements/api-v2/';
    $uSec = 'enter Cloud-Elements user secret';
    $oSec = 'enter Cloud-Elements organization secret';

    $CallAPI = function ($method, $url, $data = false) use ($baseUrl, $uSec, $oSec) {

        $curl = curl_init();

        // Concatenate baseUrl with url provided in scope
        $url = $baseUrl . $url;

        //////////////////////////////////////////////////////////
        // Setting required headers for Cloud-Elements API      //
        //////////////////////////////////////////////////////////
        // NOTE: Content-Type is not always 'application/json', //
        //       but for purposes of this demo, we are hard     //
        //       coding it to this value.                       //
        //////////////////////////////////////////////////////////
        $headers = Array(
            "Authorization: User {$uSec}, Organization {$oSec}",
            "Content-Type: application/json"
        );

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
?>