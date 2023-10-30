<?php

namespace G4\CleanCore\Response;

use G4\Constants\Http;

class Code
{
    public static function asMessage($code)
    {
        return Http::$messages[$code] ?? 'Unknown';
    }

    public static function isValid($code): bool
    {
        return array_key_exists($code, Http::$messages);
    }
}
