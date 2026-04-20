<?php

namespace Proglab\PrintSmarterApiClient\Error;

class PrintSmarterApiException extends \Exception
{
    public function __construct(
        string $message,
        private readonly int $httpStatusCode = 0,
        private readonly ?string $apiResponse = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $httpStatusCode, $previous);
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getApiResponse(): ?string
    {
        return $this->apiResponse;
    }
}
