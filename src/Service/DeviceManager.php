<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Service;

class DeviceManager extends AbstractService
{
    protected $uri = 'cmd/stamgr';

    public function authorize(
        string $mac,
        int $minutes,
        int $up = null,
        int $down = null,
        int $MBytes = null,
        string $apMac = null
    ) {
        $data = [
            'cmd' => 'authorize-guest',
            'mac' => strtolower($mac),
            'minutes' => intval($minutes),
            'up' => intval($up),
            'down' => intval($down),
            'bytes' => intval($MBytes),
            'ap_mac' => $apMac
        ];

        $response = $this->process(array_filter($data));

        return $this->process_response_boolean($response);
    }

    public function unAuthorize(string $mac)
    {
        $response = $this->process(['cmd' => 'unauthorize-guest', 'mac' => strtolower($mac)]);

        return $this->process_response_boolean($response);
    }

    public function reconnect(string $mac)
    {
        $response = $this->process(['cmd' => 'kick-sta', 'mac' => strtolower($mac)]);

        return $this->process_response_boolean($response);
    }

    public function block(string $mac)
    {
        $response = $this->process(['cmd' => 'block-sta', 'mac' => strtolower($mac)]);

        return $this->process_response_boolean($response);
    }

    public function unblock(string $mac)
    {
        $response = $this->process(['cmd' => 'unblock-sta', 'mac' => strtolower($mac)]);

        return $this->process_response_boolean($response);
    }
}