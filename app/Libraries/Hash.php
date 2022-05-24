<?php 
namespace App\Libraries;

class Hash
{
    public static function make($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function check($entred_password, $db_password ){
        if(password_verify($entred_password, $db_password)){
            return true;
        }else{
            return false;
        }
    }

}

?>