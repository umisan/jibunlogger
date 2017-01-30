<?php
/**
 * Created by PhpStorm.
 * User: umino
 * Date: 17/01/28
 * Time: 15:53
 */
require_once './Twig-1.30.0/lib/Twig/Autoloader.php';
require_once './database.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader,
    array(
        'debug' => true,
    ));
$template = $twig->load('signup.twig');
echo $template->render();
?>