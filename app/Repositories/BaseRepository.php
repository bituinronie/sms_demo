<?php

namespace App\Repositories;

use App\Traits\ResponseAPI,
    App\Traits\JwtAuth,
    App\Traits\FileHandling,
    App\Traits\FileDirectory,
    App\Traits\Email,
    App\Traits\Getter,
    App\Traits\Generator,
    App\Traits\ActivityLog,
    App\Traits\Scheduling;

class BaseRepository
{
    use ResponseAPI, JwtAuth, FileHandling, FileDirectory, Email, Getter, Generator, ActivityLog, Scheduling;
}
