<?php

declare(strict_types=1);

namespace Pisochek\UniFi;

use Exception;
use Pisochek\UniFi\Storage\StorageInterface;

class Client
{
    protected $storage;
    protected $username;
    protected $password;
    protected $baseUrl;
    protected $site;
    protected $version;
    protected $ssl;

    /**
     * Client constructor.
     *
     * @param \Pisochek\UniFi\Storage\StorageInterface $storage
     * @param string $username
     * @param string $password
     * @param string $baseUrl
     * @param string $site
     * @param string $version
     * @param bool $ssl
     *
     * @throws \Exception
     */
    public function __construct(
        StorageInterface $storage,
        string $username,
        string $password,
        string $baseUrl = 'https://127.0.0.1:8443',
        string $site = 'default',
        string $version = '5.4.16',
        bool $ssl = false
    ) {
        $this->storage = $storage;
        $this->username = trim($username);
        $this->password = trim($password);
        $this->baseUrl = trim($baseUrl);
        $this->site = trim($site);
        $this->version = trim($version);
        $this->ssl = $ssl;

        if (!filter_var($this->baseUrl, FILTER_VALIDATE_URL)) {
            throw new Exception('The URL provided is incomplete or invalid!');
        }
    }

    public function check()
    {

    }

    public function request(string $uri, array $data)
    {

    }
}
