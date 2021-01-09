<?php

namespace Tests\Unit\Models\Consumer;

use App\Consumer;
use App\ConsumerSubsidization;
use App\SubsidizationRule;
use Carbon\Carbon;
use Tests\TestCase;

class ConsumerTest extends TestCase
{
    /** @test */
    public function consumer_has_subsidization_even_all_dates_are_empty()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        $this->assertTrue($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumer_has_subsidization_when_today_is_inside_all_date_ranges()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->addDays(10),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(5),
            'subsidization_end'      => Carbon::now()->addDays(5),
        ]);

        $this->assertTrue($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumer_has_subsidization_when_today_is_inside_subsidization_date_range()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(5),
            'subsidization_end'      => Carbon::now()->addDays(5),
        ]);

        $this->assertTrue($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumer_has_subsidization_when_today_is_inside_subsidization_rules_date_range()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->addDays(10),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        $this->assertTrue($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_period_and_correct_subsidization_rules_period()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->addDays(10),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(10),
            'subsidization_end'      => Carbon::now()->subDays(5),
        ]);

        $this->assertFalse($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_period_and_empty_subsidization_rules_period()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(10),
            'subsidization_end'      => Carbon::now()->subDays(5),
        ]);

        $this->assertFalse($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_rules_period_and_correct_subsidization_period()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->subDays(5),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => Carbon::now()->subDays(10),
            'subsidization_end'      => Carbon::now()->addDays(10),
        ]);

        $this->assertFalse($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumers_subsidization_is_expired_due_wrong_subsidization_rules_period_and_empty_subsidization_period()
    {
        $today = Carbon::now();

        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => Carbon::now()->subDays(10),
            'end_date'   => Carbon::now()->subDays(5),
        ]);

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        $this->assertFalse($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumer_does_not_have_subsidization()
    {
        $today = Carbon::now();

        $consumer = create(Consumer::class);

        $this->assertFalse($consumer->isSubsidized($today));
    }

    /** @test */
    public function consumer_is_not_subsidized_because_does_not_have_subsidization_rule()
    {
        $today = Carbon::now();

        $consumer = create(Consumer::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => null,
            'subsidization_start'    => Carbon::now()->subDays(5),
            'subsidization_end'      => Carbon::now()->addDays(5),
        ]);

        $this->assertFalse($consumer->isSubsidized($today));
    }
}
