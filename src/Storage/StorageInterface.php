<?php

declare(strict_types=1);

namespace Pisochek\UniFi\Storage;

interface StorageInterface
{
    /**
     * Set data by key
     *
     * @param string $key
     * @param mixed $data
     *
     * @return void
     */
    public function set(string $key, mixed $data) : void;

    /**
     * Get data by specified key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key) : mixed;

    /**
     * Delete data by key
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key) : bool;

    /**
     * Get all data stored
     *
     * @return array
     */
    public function all() : array;
}
