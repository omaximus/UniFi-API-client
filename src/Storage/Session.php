<?php

namespace Pisochek\UniFi\Storage;

class Session implements StorageInterface
{
    protected $sessionKey;

    public function __construct(string $sessionKey = null)
    {
        if (!$sessionKey) {
            $sessionKey = md5(static::class);
        }

        $this->sessionKey = $sessionKey;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, mixed $data): void
    {
        $_SESSION[$this->sessionKey][$key] = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$this->sessionKey][$key];
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $key): bool
    {
        if (isset($_SESSION[$this->sessionKey][$key])) {
            unset($_SESSION[$this->sessionKey][$key]);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return (array)$_SESSION[$this->sessionKey];
    }
}
