<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use Authorizable;
}
