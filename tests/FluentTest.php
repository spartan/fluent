<?php

namespace Spartan\Fluent\Test;

use PHPUnit\Framework\TestCase;
use Spartan\Fluent\Str;

class FluentTest extends TestCase
{
    public function testArrayAccess()
    {
        $tags = 'one,two,three,four';

        $this->assertSame(0, \fluent($tags)->split(',')->flip()['one']);

        $this->assertSame(
            [
                'one'   => 0,
                'two'   => 1,
                'three' => 2,
                'four'  => 3,
            ],
            \fluent($tags)->split(',')->flip()->toArray()
        );
    }

    public function testForeachBreak()
    {
        $array = [1, 2, 3];

        $sum = 0;

        \fluent($array)
            ->forEach(
                function ($value) use (&$sum) {
                    if ($value > 2) {
                        return false;
                    }
                    $sum += $value;
                }
            );

        $this->assertSame(3, $sum);
    }

    public function testRandom()
    {
        $rand = Str::generate();

        $this->assertTrue((bool)preg_match('/^[A-Za-z0-9]{8}$/', $rand));
    }
}
