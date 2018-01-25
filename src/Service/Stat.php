<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Service;

use Carbon\Carbon;

class Stat extends AbstractService
{
    const SESSION_TYPE_GUEST = 'guest';
    const SESSION_TYPE_USER = 'user';
    const SESSION_TYPE_ALL = 'all';

    protected $uri = 'stat';
    private $attrs = [
        'site' => [
            'bytes',
            'wan-tx_bytes',
            'wan-rx_bytes',
            'wlan_bytes',
            'num_sta',
            'lan-num_sta',
            'wlan-num_sta',
            'time'
        ],
        'ap'   => [
            'bytes',
            'num_sta',
            'time'
        ],
    ];

    public function fiveMinSite(int $start = null, int $end = null)
    {
        $end = is_null($end) ? (time() * 1000) : $end;
        $start = is_null($start) ? $end - (12 * 3600 * 1000) : $start;

        $data = [
            'attrs' => $this->attrs['site'],
            'start' => $start,
            'end'   => $end
        ];

        $response = $this->process('report/5minutes.site', $data);

        return $this->process_response($response);
    }

    public function hourlySite(int $start = null, int $end = null)
    {
        $end = is_null($end) ? (time() * 1000) : $end;
        $start = is_null($start) ? $end - (7 * 24 * 3600 * 1000) : $start;

        $data = [
            'attrs' => $this->attrs['site'],
            'start' => $start,
            'end'   => $end
        ];

        $response = $this->process('report/hourly.site', $data);

        return $this->process_response($response);
    }

    public function dailySite(int $start = null, int $end = null)
    {
        $end = is_null($end) ? (time() * 1000) : $end;
        $start = is_null($start) ? $end - (52 * 7 * 24 * 3600 * 1000) : $start;

        $data = [
            'attrs' => $this->attrs['site'],
            'start' => $start,
            'end'   => $end
        ];

        $response = $this->process('report/daily.site', $data);

        return $this->process_response($response);
    }

    public function fiveMinAP(int $start = null, int $end = null, string $mac = null)
    {
        $end = is_null($end) ? (time() * 1000) : $end;
        $start = is_null($start) ? $end - (12 * 3600 * 1000) : $start;

        $data = [
            'attrs' => $this->attrs['ap'],
            'start' => $start,
            'end'   => $end,
            'mac'   => strtolower($mac),
        ];

        $response = $this->process('report/5minutes.ap', $data);

        return $this->process_response($response);
    }

    public function hourlyAP(int $start = null, int $end = null, string $mac = null)
    {
        $end = is_null($end) ? (time() * 1000) : $end;
        $start = is_null($start) ? $end - (7 * 24 * 3600 * 1000) : $start;

        $data = [
            'attrs' => $this->attrs['ap'],
            'start' => $start,
            'end'   => $end,
            'mac'   => strtolower($mac),
        ];

        $response = $this->process('report/hourly.ap', $data);

        return $this->process_response($response);
    }

    public function dailyAP(int $start = null, int $end = null, string $mac = null)
    {
        $end = is_null($end) ? (time() * 1000) : $end;
        $start = is_null($start) ? $end - (7 * 24 * 3600 * 1000) : $start;

        $data = [
            'attrs' => $this->attrs['ap'],
            'start' => $start,
            'end'   => $end,
            'mac'   => strtolower($mac),
        ];

        $response = $this->process('report/daily.ap', $data);

        return $this->process_response($response);
    }

    public function sessions(
        int $start = null,
        int $end = null,
        string $mac = null,
        string $type = self::SESSION_TYPE_ALL
    ) {
        $end = is_null($end) ? time() : $end;
        $start = is_null($start) ? $end - (7 * 24 * 3600) : $start;

        $data = [
            'type'  => $type,
            'start' => $start,
            'end'   => $end,
            'mac'   => strtolower($mac),
        ];

        $response = $this->process('session', $data);

        return $this->process_response($response);
    }

    public function sessionLatest(
        string $mac,
        int $limit = 5
    ) {
        $data = [
            'mac'    => strtolower($mac),
            '_limit' => $limit,
            '_sort'  => '-assoc_time',
        ];

        $response = $this->process('session', $data);

        return $this->process_response($response);
    }

    public function authorizations(int $start = null, int $end = null)
    {
        $end = is_null($end) ? time() : $end;
        $start = is_null($start) ? $end - (7 * 24 * 3600) : $start;

        $data = [
            'start' => $start,
            'end'   => $end,
        ];

        $response = $this->process('authorization', $data);

        return $this->process_response($response);
    }

    public function users(int $hours = 8760)
    {
        $data = [
            'type'   => 'all',
            'conn'   => 'all',
            'within' => $hours,
        ];

        $response = $this->process('alluser', $data);

        return $this->process_response($response);
    }

    public function guests(int $hours = 8760)
    {
        $data = ['within' => $hours,];

        $response = $this->process('guest', $data);

        return $this->process_response($response);
    }

    public function clientDevices(string $mac = null)
    {
        $response = $this->process('sta/' . trim($mac));

        return $this->process_response($response);
    }

    public function clientDevice(string $mac)
    {
        $response = $this->process('user/' . trim($mac));

        return $this->process_response($response);
    }

    public function health()
    {
        $response = $this->process([], 'health');

        return $this->process_response($response);
    }

    public function dashboard($fiveMinutes = false)
    {
        $params = ['scale' => $fiveMinutes ? '5minutes' : ''];
        $response = $this->process('dashboard', [], $params);

        return $this->process_response($response);
    }

    public function devices($mac = null)
    {
        $response = $this->process('device' . trim($mac));

        return $this->process_response($response);
    }

    public function rogueAP($hours = 24)
    {
        $data = ['within' => $hours,];

        $response = $this->process('rogueap', $data);

        return $this->process_response($response);
    }

    public function sites()
    {
        $response = $this->process('sites');

        return $this->process_response($response);
    }

    public function sysInfo()
    {
        $response = $this->process('sysinfo');

        return $this->process_response($response);
    }

    public function vouchers(Carbon $created)
    {
        $data = ['create_time' => $created->timestamp,];

        $response = $this->process('voucher', $data);

        return $this->process_response($response);
    }

    public function payments(int $hours = null)
    {
        $data = ['within' => $hours,];

        $response = $this->process('payment', $data);

        return $this->process_response($response);
    }

    public function portForward()
    {
        $response = $this->process('portforward');

        return $this->process_response($response);
    }

    public function dpi()
    {
        $response = $this->process('dpi');

        return $this->process_response($response);
    }

    public function currentChannels()
    {
        $response = $this->process('current-channel');

        return $this->process_response($response);
    }

    public function events(int $hours = 720, int $startNumber = 0, int $limit = 300)
    {
        $data = [
            '_sort'  => '-time',
            'within' => $hours,
            '_start' => $startNumber,
            '_limit' => $limit
        ];

        $response = $this->process('portforward', $data);

        return $this->process_response($response);
    }

    public function spectrumScan($mac)
    {
        $response = $this->process('spectrum-scan' . trim($mac));

        return $this->process_response($response);
    }
}
