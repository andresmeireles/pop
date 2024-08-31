<?php

declare(strict_types=1);

namespace App\Exception;

use App\Contracts\ApiResponseExceptionInterface;
use App\Contracts\LogExceptionInterface;

class ApiException extends \Exception implements LogExceptionInterface, ApiResponseExceptionInterface
{
}
