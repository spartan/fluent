<?php

use Spartan\Fluent\Fluent;

if (!function_exists('fluent')) {
    /**
     * @param     $data
     * @param int $options
     *
     * @return Fluent
     */
    function fluent($data, int $options = 0): Fluent
    {
        return new Fluent($data, $options);
    }
}
