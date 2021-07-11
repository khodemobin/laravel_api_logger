<?php


namespace LaravelApiLogger\Contracts;


class Log
{
    public function __construct(
        protected ?string $created_at = null,
        protected ?string $method = null,
        protected ?string $controller = null,
        protected ?string $action = null,
        protected ?string $url = null,
        protected ?string $payload = null,
        protected ?string $response = null,
        protected ?string $duration = null,
        protected ?string $ip = null,
        protected ?string $realIP = null,
        protected ?string $device = null,
        protected ?string $platform = null,
        protected ?string $platformVersion = null,
        protected ?string $browser = null,
        protected ?string $browserVersion = null,
    )
    {
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getPayload(): ?string
    {
        return $this->payload;
    }

    /**
     * @return string|null
     */
    public function getResponse(): ?string
    {
        return $this->response;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @return string|null
     */
    public function getRealIP(): ?string
    {
        return $this->realIP;
    }

    /**
     * @return string|null
     */
    public function getDevice(): ?string
    {
        return $this->device;
    }

    /**
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * @return string|null
     */
    public function getPlatformVersion(): ?string
    {
        return $this->platformVersion;
    }

    /**
     * @return string|null
     */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    /**
     * @return string|null
     */
    public function getBrowserVersion(): ?string
    {
        return $this->browserVersion;
    }

    public function serialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'method' => $this->method,
            'controller' => $this->controller,
            'action' => $this->action,
            'url' => $this->url,
            'payload' => $this->payload,
            'response' => $this->response,
            'duration' => $this->duration,
            'ip' => $this->ip,
            'realIP' => $this->realIP,
            'device' => $this->device,
            'platform' => $this->platform,
            'platformVersion' => $this->platformVersion,
            'browser' => $this->browser,
            'browserVersion' => $this->browserVersion,
        ];
    }
}
