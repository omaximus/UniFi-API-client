<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Service;

use Pisochek\UniFi\Client;

abstract class AbstractService
{
    protected $client;
    protected $uri = '';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function process(string $uri, array $data = [], array $params = [])
    {
        $this->client->request($this->uri, $data);

        return '';
    }
}
