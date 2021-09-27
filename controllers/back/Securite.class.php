<?php 

    class Securite{
        public static function secureHTML($string){
            return htmlentities($string);
        }

        //verifie si la session admin est remplie et presente et qu'elle correspond bien a admin 
        public static function verifAccessSession(){
            return (!empty($_SESSION['access']) && $_SESSION['access'] === "admin");
        }
    }


?>