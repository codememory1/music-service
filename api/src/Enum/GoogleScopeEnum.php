<?php

namespace App\Enum;

enum GoogleScopeEnum: string
{
    case EMAIL = 'https://www.googleapis.com/auth/userinfo.email';
    case PROFILE = 'https://www.googleapis.com/auth/userinfo.profile';
    case PHONES = 'https://www.googleapis.com/auth/user.phonenumbers.read';
    case ORGANIZATION = 'https://www.googleapis.com/auth/user.organization.read';
    case GENDER = 'https://www.googleapis.com/auth/user.gender.read';
    case BIRTHDAY = 'https://www.googleapis.com/auth/user.birthday.read';
    case ADDRESS = 'https://www.googleapis.com/auth/user.addresses.read';
}