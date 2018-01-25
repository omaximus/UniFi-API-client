<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Service;

class Cmd extends AbstractService
{
    protected $uri = 'cmd';

    public function authorizeDevice(
        string $mac,
        int $minutes,
        int $up = null,
        int $down = null,
        int $MBytes = null,
        string $apMac = null
    ) {
        $data = [
            'cmd'     => 'authorize-guest',
            'mac'     => strtolower($mac),
            'minutes' => intval($minutes),
            'up'      => intval($up),
            'down'    => intval($down),
            'bytes'   => intval($MBytes),
            'ap_mac'  => $apMac
        ];

        $response = $this->process('stamgr', $data);

        return $this->process_response_boolean($response);
    }

    public function unauthorizeDevice(string $mac)
    {
        $data = [
            'cmd' => 'unauthorize-guest',
            'mac' => strtolower($mac)
        ];

        $response = $this->process('stamgr', $data);

        return $this->process_response_boolean($response);
    }

    public function reconnectDevice(string $mac)
    {
        $data = [
            'cmd' => 'kick-sta',
            'mac' => strtolower($mac)
        ];

        $response = $this->process('stamgr', $data);

        return $this->process_response_boolean($response);
    }

    public function blockDevice(string $mac)
    {
        $data = [
            'cmd' => 'block-sta',
            'mac' => strtolower($mac)
        ];

        $response = $this->process('stamgr', $data);

        return $this->process_response_boolean($response);
    }

    public function unblockDevice(string $mac)
    {
        $data = [
            'cmd' => 'unblock-sta',
            'mac' => strtolower($mac)
        ];

        $response = $this->process('stamgr', $data);

        return $this->process_response_boolean($response);
    }

    public function createSite(string $description)
    {
        $data = [
            'cmd'  => 'add-site',
            'desc' => $description
        ];

        $response = $this->process('sitemgr', $data);

        return $this->process_response_boolean($response);
    }

    public function deleteSite($id)
    {
        $data = [
            'cmd'  => 'delete-site',
            'site' => $id
        ];

        $response = $this->process('sitemgr', $data);

        return $this->process_response_boolean($response);
    }

    public function getAdmins()
    {
        $data = [
            'cmd' => 'get-admins',
        ];

        $response = $this->process('sitemgr', $data);

        return $this->process_response_boolean($response);
    }

    public function createVoucher(
        int $minutes,
        int $count = 1,
        int $quota = 0,
        string $note = '',
        int $uploadSpeed = 0,
        int $downloadSpeed = 0,
        int $limit = 0
    ) {
        $data = [
            'cmd'    => 'create-voucher',
            'expire' => $minutes,
            'n'      => $count,
            'quota'  => $quota,
            'note' => $note,
            'up' => $uploadSpeed,
            'down' => $downloadSpeed,
            'bytes' => $limit
        ];

        $response = $this->process('hotspot', $data);

        return $this->process_response_boolean($response);
    }

    public function revokeVoucher(string $id)
    {
        $data = ['_id' => $id, 'cmd' => 'delete-voucher'];

        $response = $this->process('hotspot', $data);

        return $this->process_response_boolean($response);
    }

    public function extendGuestValidity($id)
    {
        $data =['_id' => $id, 'cmd' => 'extend'];

        $response = $this->process('hotspot', $data);

        return $this->process_response_boolean($response);
    }

    public function adoptDevice(string $mac)
    {
        $data = ['mac' => strtolower($mac), 'cmd' => 'adopt'];

        $response = $this->process('devmgr', $data);

        return $this->process_response_boolean($response);
    }

    public function restartAP(string $mac)
    {
        $data = ['cmd' => 'restart', 'mac' => strtolower($mac)];

        $response = $this->process('devmgr', $data);

        return $this->process_response_boolean($response);
    }

    public function locateAP(string $mac, bool $enable)
    {
        $data = ['cmd' => $enable ? 'set-locate' : 'unset-locate', 'mac' => strtolower($mac)];

        $response = $this->process('devmgr', $data);

        return $this->process_response_boolean($response);
    }

    public function moveDevice(string $mac, string $siteId)
    {
        $data = ['site' => $siteId, 'mac' => $mac, 'cmd' => 'move-device'];

        $response = $this->process('sitemgr', $data);

        return $this->process_response_boolean($response);
    }

    public function deleteDevice(string $mac)
    {
        $data = ['mac' => $mac, 'cmd' => 'delete-device'];

        $response = $this->process('sitemgr', $data);

        return $this->process_response_boolean($response);
    }

    public function archiveAlarm(string $id)
    {
        // TODO: POST request type
        $data = ['_id' => $id, 'cmd' => 'archive-alarm'];

        $response = $this->process('evtmgr', $data);

        return $this->process_response_boolean($response);
    }

    public function archiveAlarms()
    {
        // TODO: POST request type
        $data = ['cmd' => 'archive-all-alarms'];

        $response = $this->process('evtmgr', $data);

        return $this->process_response_boolean($response);
    }
}