<?php

namespace Tests\Unit\Models\Consumer;

use App\Consumer;
use App\ConsumerSubsidization;
use App\SubsidizationRule;
use Carbon\Carbon;
use Tests\TestCase;

class ConsumerTest extends TestCase
{
    /**
     * @var Carbon
     */
    protected $today;

    public function setUp(): void
    {
        parent::setUp();
        $this->today = Carbon::now();
    }

    /** @test */
    public function consumer_has_subsidization_even_all_dates_are_empty()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        $this->assertTrue($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumer_has_subsidization_when_today_is_inside_all_date_ranges()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->addDays(10),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(5),
            'subsidization_end'      => Carbon::now()->addDays(5),
        ]);

        $this->assertTrue($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumer_has_subsidization_when_today_is_inside_subsidization_date_range()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(5),
            'subsidization_end'      => Carbon::now()->addDays(5),
        ]);

        $this->assertTrue($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumer_has_subsidization_when_today_is_inside_subsidization_rules_date_range()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->addDays(10),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        $this->assertTrue($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_period_and_correct_subsidization_rules_period()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->addDays(10),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(10),
            'subsidization_end'      => Carbon::now()->subDays(5),
        ]);

        $this->assertFalse($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_period_and_empty_subsidization_rules_period()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(10),
            'subsidization_end'      => Carbon::now()->subDays(5),
        ]);

        $this->assertFalse($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_rules_period_and_correct_subsidization_period()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->subDays(5),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(10),
            'subsidization_end'      => Carbon::now()->addDays(10),
        ]);

        $this->assertFalse($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_rules_period_and_empty_subsidization_period()
    {
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->subDays(5),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        $this->assertFalse($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumer_does_not_have_subsidization()
    {
        $consumer = create(Consumer::class);

        $this->assertFalse($consumer->isSubsidized($this->today));
    }

    /** @test */
    public function consumer_is_not_subsidized_because_does_not_have_subsidization_rule()
    {
        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => null,
            'subsidization_start'    => Carbon::now()->subDays(5),
            'subsidization_end'      => Carbon::now()->addDays(5),
        ]);

        $this->assertFalse($consumer->isSubsidized($this->today));
    }
}
