<?php

namespace App\Exceptions;


class AppCustomHttpException extends \Exception {

    public function __construct($message, $statusCode) {
        parent::__construct($message, $statusCode);
    }

}