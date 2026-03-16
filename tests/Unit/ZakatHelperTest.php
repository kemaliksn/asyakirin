<?php

namespace Tests\Unit;

use App\Helpers\ZakatHelper;
use PHPUnit\Framework\TestCase;

class ZakatHelperTest extends TestCase
{
    public function test_parse_decimal_accepts_comma_and_dot_as_decimal_separator(): void
    {
        $this->assertSame(3.5, ZakatHelper::parseDecimal('3,5'));
        $this->assertSame(3.5, ZakatHelper::parseDecimal('3.5'));
        $this->assertSame(1250.5, ZakatHelper::parseDecimal('1.250,5'));
        $this->assertSame(1250.5, ZakatHelper::parseDecimal('1,250.5'));
    }

    public function test_parse_decimal_returns_zero_for_empty_or_invalid_values(): void
    {
        $this->assertSame(0.0, ZakatHelper::parseDecimal(''));
        $this->assertSame(0.0, ZakatHelper::parseDecimal(null));
        $this->assertSame(0.0, ZakatHelper::parseDecimal('abc'));
    }
}