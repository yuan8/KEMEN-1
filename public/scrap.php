<?php

$loginUrl = 'http://airminum.ciptakarya.pu.go.id/sinkronisasi/dashboard.php'; //action from the login form
$loginFields = array('username'=>'admin', 'password'=>'spam3257','AppType'=>'spam'); //login form field names and values
$remotePageUrl = 'http://airminum.ciptakarya.pu.go.id/sinkronisasi/rosimspamdatalist.php'; //url of the page you want to save  

$login = getUrl($loginUrl, 'post', $loginFields); //login to the site

$remotePage = getUrl($remotePageUrl); //get the remote page

function getUrl($url, $method='', $vars='') {
    $ch = curl_init();
    if ($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, (__dir__.'/cookies/cookies.txt'));
    curl_setopt($ch, CURLOPT_COOKIEFILE, (__dir__.'/cookies/cookies.txt'));
    $buffer = curl_exec($ch);
    curl_close($ch);
    return $buffer;
}

print_r($remotePage);
die;