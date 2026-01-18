<?php

namespace App\Helpers;

class IdHelper{

    public static function parse($id, $prefix): string{
            
        $removedPrefix =  ltrim($id, $prefix);

        return ltrim($removedPrefix, '0');
    }

}

?>
