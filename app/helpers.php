<?php
function url($uri)
{
    return sprintf(
        "%s://%s/%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',  // renvoie http ou https
		$_SERVER['SERVER_NAME'],  // renvoie le nom de domaine (ex localhost ou mondomaine.com)
		$_SERVER['SERVER_NAME'] == 'localhost' ? 'partagimage/' : '',
		$uri
    );
}

function randString($length)
{ // cette fonction servira à générer le jetton de session pour éviter les attaques CSRF
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function formatDate($year, $month, $day)
{
    if ($month < 10) {
        $month = '0'.$month;
    }
    if ($day < 10) {
        $day = '0'.$day;
    }
    return $year.'-'.$month.'-'.$day;
}

function redirect($location)
{
    header('location: '.$location);
    exit;
}

function isLogged()
{
    return isset($_SESSION['userId']);
}

function verifyToken()
{
    if ($_SESSION['csrf_token'] != $_POST['csrf_token']) die('Jeton de session invalide');
}
