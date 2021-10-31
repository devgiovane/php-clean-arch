<?php


declare(strict_types=1);


namespace App\Infra\Http\Notification;



final class NotificationError
{
    private array $message;
    private int $statusCode;

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @param array $message
     * @return NotificationError
     */
    public function setMessage(array $message): NotificationError
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return NotificationError
     */
    public function setStatusCode(int $statusCode): NotificationError
    {
        $this->statusCode = $statusCode;
        return $this;
    }

}
