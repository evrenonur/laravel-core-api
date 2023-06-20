<?php

namespace App\Core;

class ServiceResponse
{
    private bool $isSuccess;

    private string $message;

    private int $statusCode;

    private mixed $data;

    public function __construct(
        bool   $isSuccess,
        string $message,
        mixed  $data,
        int    $statusCode,
    )
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

}
