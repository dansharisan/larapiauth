<?php

use App\Enums\Error;

return [
    Error::class => [
        Error::AUTH0001 => "Wrong combination of email and password or unverified email",
        Error::AUTH0002 => "Invalid activation token",
        Error::AUTH0003 => "Couldn't find the user with that e-mail address",
        Error::AUTH0004 => "Invalid password reset token",
        Error::AUTH0005 => "Expired password reset token",
        Error::AUTH0006 => "Invalid email and/or token",
        Error::AUTH0007 => "Invalid access token",
        Error::AUTH0008 => "Expired access token",
        Error::AUTH0009 => "Blacklisted access token",
        Error::AUTH0010 => "Unauthorized request",
    ],
];
