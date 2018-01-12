<?php namespace App\Model;

class Notification
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $message;

    /** @var string|null */
    protected $device;

    /** @var int|null */
    protected $priority;

    /** @var boolean */
    protected $isHtml = false;

    /**
     * Notification constructor.
     * @param string $title
     * @param string $message
     */
    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return null|string
     */
    public function getDevice(): ?string
    {
        return $this->device;
    }

    /**
     * @return null|int
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @return bool
     */
    public function isHtml(): bool
    {
        return $this->isHtml;
    }

    /**
     * @param bool $isHtml
     * @return $this
     */
    public function setIsHtml(bool $isHtml)
    {
        $this->isHtml = $isHtml;
        return $this;
    }

    /**
     * @param null|string $device
     * @return $this
     */
    public function setDevice($device)
    {
        $this->device = $device;
        return $this;
    }

    /**
     * @param int|null $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
}