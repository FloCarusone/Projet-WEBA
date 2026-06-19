<?php

class SecurityHelper {

    private static string $apiKey = "IDjiaosudh128eudaj8ih";

    //fonction qui vérifie que la clé d'API soit valide
    public static function isAPIKeyValid(): bool {

        $headers = getallheaders();

        //vérifie que le header Autorization existe 
        if (isset($headers["Authorization"])){
            $authHeader = $headers["Authorization"];
        } else {
            return false;
        }

        
        //vérifie le préfixe "Bearer " (il est important de mettre 7 caractères, car l'espace après le berar est imposé par PHP)
        if (str_starts_with($authHeader, "Bearer ")){
            //on extrait le "bearer "
            $receivedKey = substr($authHeader, 7);
            //on compare avec la clé existente
            if ($receivedKey == self::$apiKey){
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public static function generateAPIAccessError() {
        (new Response(httpCode: 401))->generateResponse();
    }
}

?>