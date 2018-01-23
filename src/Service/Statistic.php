<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Service;

class Statistic extends AbstractService
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

        $response = $this->process($data, 'report/5minutes.site');

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

        $response = $this->process($data, 'report/hourly.site');

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

        $response = $this->process($data, 'report/daily.site');

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

        $response = $this->process($data, 'report/5minutes.ap');

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

        $response = $this->process($data, 'report/hourly.ap');

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

        $response = $this->process($data, 'report/daily.ap');

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

        $response = $this->process($data, 'session');

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

        $response = $this->process($data, 'session');

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

        $response = $this->process($data, 'authorization');

        return $this->process_response($response);
    }

    public function users(int $hours = 8760)
    {
        $data = [
            'type'   => 'all',
            'conn'   => 'all',
            'within' => $hours,
        ];

        $response = $this->process($data, 'alluser');

        return $this->process_response($response);
    }

    public function guests(int $hours = 8760)
    {
        $data = ['within' => $hours,];

        $response = $this->process($data, 'guest');

        return $this->process_response($response);
    }

    public function clients(string $mac = null)
    {
        $response = $this->process([], 'sta/' . trim($mac));

        return $this->process_response($response);
    }

    public function client(string $mac)
    {
        $response = $this->process([], 'user/' . trim($mac));

        return $this->process_response($response);
    }

    public function health()
    {
        $response = $this->process([], 'health');

        return $this->process_response($response);
    }
}
