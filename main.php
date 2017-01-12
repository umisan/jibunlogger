<?php
/**
 * Created by PhpStorm.
 * User: tomoki
 * Date: 2017/01/12
 * Time: 14:53
 */
require_once './Twig-1.30.0/lib/Twig/Autoloader.php';
$loader = new Twig_Loader_Filesystem('./');
$twig = new Twig_Environment($loader,
    array(
        'cache' => './cache',
    ));

$template = $twig->load('main.html');
echo $template->render();
?>