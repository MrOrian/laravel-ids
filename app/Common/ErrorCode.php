<?php

namespace App\Common;

class ErrorCode{
    const FAILED = 1001;
    const SUCCESS = 2000;
    const USER_CREATED = 2001;
    const USER_UPDATED = 2002;
    const USER_DELETED = 2003;
    const FORBIDDEN = 4031;
    const EMAIL_INVALID = 4001;
    const NAME_REQUIRED = 4002;
    const NAME_MAX_LENGTH = 4003;
    const EMAIL_REQUIRED = 4004;
    const EMAIL_INVALID_FORMAT = 4005;
    const EMAIL_DUPLICATE = 4006;
    const PASSWORD_REQUIRED = 4007;
    const PASSWORD_MIN_LENGTH = 4008;
    const PASSWORD_CONFIRMATION_FAILED = 4009;
}