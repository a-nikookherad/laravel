<?php

namespace App\Exceptions;

use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Log;

class PositionStoreException extends Exception
{
    use Response;

    public function report()
    {
        Log::info($this->getMessage(), [
            "file:" => $this->getFile(),
            "line:" => $this->getLine(),
            "status_code:" => $this->getCode(),
        ]);
    }

    public function render($request)
    {
        if (env("APP_DEBUG")) {
            $resData = [
                "message" => $this->getMessage(),
                "file" => $this->getFile(),
                "line" => $this->getLine(),
            ];
        } else {
            $resData = [
                "message" => $this->getMessage(),
            ];
        }
        return $this->errorResponse(__("messages.something_went_wrong"), $resData, $this->getCode());
    }
}
