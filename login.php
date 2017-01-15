<?php
/**
 * Created by PhpStorm.
 * User: tomoki
 * Date: 2017/01/12
 * Time: 15:34
 */
require_once './Twig-1.30.0/lib/Twig/Autoloader.php';
require_once './database.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader,
    array(
        'debug' => true,
    ));
$template = $twig->load('login.twig');
echo $template->render();
?>