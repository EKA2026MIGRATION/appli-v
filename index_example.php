<?php
error_reporting(0);

header("Access-Control-Allow-Origin: *");
include_once('config/config.php');
isset($_GET['r']) ? $url = $_GET['r'] : $url = 'app/home';

MyConfiguration::start($url);

if(!isset($_GET['r'])) {
    header('Location:'.HOST.'auth/display');
    exit;
 }

$routeur = new Routeur($url);
$routeur->renderController();
