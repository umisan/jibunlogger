<?php
/**
 * Created by PhpStorm.
 * User: umino
 * Date: 17/01/14
 * Time: 17:59
 */
class Database{
    const dbname = 'jibunlogger';
    const host = 'localhost';
    const port = 80;
    const user = 'umino@localhost';
    const password = 'ballerup2016';

    public static function connect()
    {
        $link = mysql_connect(self::host, self::user, self::password);
        if(! $link) {
            echo mysql_error();
        }
        return $link;
    }

    public static function close($link)
    {
        mysql_close($link);
    }

    public static function selectDatabase($link)
    {
        $result = mysql_select_db(self::dbname, $link);
        if(!$link)
        {
            echo mysql_error();
        }
        return $result;
    }

    public static function issue($query)
    {
        $result = mysql_query($query);
        if($result)
        {
            echo mysql_error();
        }
        return $result;
    }


}
?>