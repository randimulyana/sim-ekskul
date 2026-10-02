<?php

namespace Tests\Feature\Services;

use App\Services\CompatibilityCalculator;
use Tests\TestCase;

class CompatibilityCalculatorTest extends TestCase
{
    protected CompatibilityCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new CompatibilityCalculator();
    }

    public function test_compatibility_is_one_when_student_and_target_are_equal(): void
    {
        $this->assertEquals(1.00, $this->calculator->calculate(5.0, 5.0));
        $this->assertEquals(1.00, $this->calculator->calculate(3.0, 3.0));
        $this->assertEquals(1.00, $this->calculator->calculate(1.0, 1.0));
    }

    public function test_compatibility_with_difference_of_one(): void
    {
        // |5 - 4| = 1 -> 1 - 1/4 = 0.75
        $this->assertEquals(0.75, $this->calculator->calculate(5.0, 4.0));
        $this->assertEquals(0.75, $this->calculator->calculate(4.0, 5.0));
    }

    public function test_compatibility_with_difference_of_two(): void
    {
        // |5 - 3| = 2 -> 1 - 2/4 = 0.50
        $this->assertEquals(0.50, $this->calculator->calculate(5.0, 3.0));
        $this->assertEquals(0.50, $this->calculator->calculate(2.0, 4.0));
    }

    public function test_compatibility_with_difference_of_three(): void
    {
        // |5 - 2| = 3 -> 1 - 3/4 = 0.25
        $this->assertEquals(0.25, $this->calculator->calculate(5.0, 2.0));
    }

    public function test_compatibility_with_difference_of_four(): void
    {
        // |5 - 1| = 4 -> 1 - 4/4 = 0.00
        $this->assertEquals(0.00, $this->calculator->calculate(5.0, 1.0));
        $this->assertEquals(0.00, $this->calculator->calculate(1.0, 5.0));
    }

    public function test_compatibility_with_decimal_difference(): void
    {
        // student = 4.5, target = 4.0 -> |4.5 - 4| = 0.5 -> 1 - 0.5/4 = 0.875
        $this->assertEquals(0.875, $this->calculator->calculate(4.5, 4.0));
    }

    public function test_target_null_returns_null_and_needs_validation_status(): void
    {
        $this->assertNull($this->calculator->calculate(5.0, null));

        $evaluation = $this->calculator->evaluate(5.0, null);
        $this->assertNull($evaluation['compatibility']);
        $this->assertEquals('NEEDS_VALIDATION', $evaluation['status']);
    }

    public function test_student_null_returns_null_and_not_ready_status(): void
    {
        $this->assertNull($this->calculator->calculate(null, 4.0));

        $evaluation = $this->calculator->evaluate(null, 4.0);
        $this->assertNull($evaluation['compatibility']);
        $this->assertEquals('NOT_READY', $evaluation['status']);
    }

    public function test_both_null_returns_null(): void
    {
        $this->assertNull($this->calculator->calculate(null, null));
    }

    public function test_unvalidated_mapping_status_returns_needs_validation(): void
    {
        $evaluation = $this->calculator->evaluate(5.0, 4.0, 'needs_validation');
        $this->assertEquals(0.75, $evaluation['compatibility']);
        $this->assertEquals('NEEDS_VALIDATION', $evaluation['status']);
    }

    public function test_validated_mapping_status_returns_ready(): void
    {
        $evaluation = $this->calculator->evaluate(5.0, 4.0, 'validated');
        $this->assertEquals(0.75, $evaluation['compatibility']);
        $this->assertEquals('READY', $evaluation['status']);
    }
}
