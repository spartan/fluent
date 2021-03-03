<?php

namespace Spartan\Fluent;

/**
 * Php Fluent
 *
 * @package Spartan\Fluent
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Php
{
    /**
     * JSON encode
     *
     * @param mixed $subject
     * @param int   $options
     *
     * @return false|string
     */
    public static function encode($subject, int $options = 0)
    {
        return json_encode($subject, $options);
    }

    /**
     * JSON decode
     *
     * @param mixed $subject
     * @param bool  $assoc
     *
     * @return mixed
     */
    public static function decode($subject, bool $assoc = true)
    {
        return json_decode($subject, $assoc);
    }

    /**
     * Safe serialization of closures
     *
     * @param mixed $subject
     *
     * @return string
     */
    public static function serialize($subject)
    {
        return \Opis\Closure\serialize($subject);
    }

    /**
     * Safe unserialization of closures
     *
     * @param mixed $subject
     * @param array $options
     *
     * @return mixed
     */
    public static function unserialize($subject, array $options = [])
    {
        return \Opis\Closure\unserialize($subject, $options);
    }

    /**
     * Read from file
     *
     * @param string $file
     *
     * @return false|string
     */
    public static function read(string $file)
    {
        return file_get_contents($file);
    }

    /**
     * Write to file
     *
     * @param        $data
     * @param string $file
     *
     * @return mixed
     */
    public static function write($data, string $file)
    {
        file_put_contents($file, $data);

        return $data;
    }
}
