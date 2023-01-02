<?php

namespace App\Context;

use App\Entity\Learner;
use App\Helper\SingletonTrait;

class ApplicationContext
{
    private static Learner $current_user;

    public static function getCurrentUser(): Learner
    {
        return self::$current_user;
    }

    public static function setCurrentUser(Learner $currentUser): void
    {
        self::$current_user = $currentUser;
    }
}
