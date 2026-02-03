<?php

namespace App\Exceptions;

use Exception;

class UserDeleteException extends Exception
{
    protected $message = 'امکان حذف کاربر وجود ندارد.';
}
