<?php

/**
 * Database connector
 *
 * @author Pieter
 */
class db {
    
    /**
     * de actieve connectie
     */
    public static $con;
    
    /**
     * singleton
     */
    private static $db=null;
    
    private static $dbuser="astrid";
    private static $database="astrid";
	private static $dbpw="LYQHT76p4be6kRbA3nwB";
    private static $dblocation="localhost";
    
    /**
     * maakt $con een open connectie
     * (als die reeds open is, gebeurt er niets)
     */
    static function open_connection(){
        if(is_null(db::$db)){
            db::$db = new db();
            db::$con = mysql_connect(db::$dblocation, db::$dbuser, db::$dbpw) or die(mysql_error());
            mysql_select_db(db::$database,db::$con);
        }
    }
    
    /**
     * sluit $con
     * (als die reeds gesloten is, gebeurt er niets)
     */
    static function close_connection(){
        if(!is_null(db::$db)){
            mysql_close(db::$con);
            db::$db=null;
        }
    }

}

?>
