<?php

class Config {
   
    const APP_NAME = "My Application"; 

    public static function getAppName() {
        return self::APP_NAME;  
    }
}

echo "Название приложения: " . Config::APP_NAME . "<br>";

echo "Название приложения (через self): " . Config::getAppName();

?>