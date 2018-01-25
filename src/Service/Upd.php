<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Service;

class Upd extends AbstractService
{
    public function deviceNote(string $userId, string $note = null)
    {
        $data = [
            'note' => $note,
            'noted' => (bool)$note,
        ];

        $response = $this->process('upd/user' . trim($userId), $data);

        return $this->process_response_boolean($response);
    }

    public function deviceName(string $userId, string $name = null)
    {
        $response = $this->process('upd/user' . trim($userId), ['name' => $name]);

        return $this->process_response_boolean($response);
    }
}