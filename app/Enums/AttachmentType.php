<?php

namespace App\Enums;

enum AttachmentType: string{

    use ValueOf;

    case IMAGE = 'image';
    case VIDEO = 'video';

}
