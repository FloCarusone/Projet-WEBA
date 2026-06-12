<?php

class SecurityHelper {

    private static string $apiKey = "IDjiaosudh128eudaj8ih";

    public static function isAPIKeyValid(): bool {

        $headers = getallheaders();

        $authHeader = $headers['Authorization'] ?? '';
        
        if(!str_starts_with($authHeader, 'Bearer')){
            return false;
        }

        $receivedKey = substr($authHeader, 7);

        return $receivedKey === self::$apikey;
    }

    public static function generateAPIAccessError() {
        (new Response(httpCode: 401))->generateResponse();
    }
}

?>