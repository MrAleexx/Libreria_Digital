<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\BookLoan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookLoanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_filters_active_loans()
    {
        // Crear préstamos con diferentes estados
        $activeLoan = BookLoan::factory()->active()->create();
        $returnedLoan = BookLoan::factory()->returned()->create();

        $results = BookLoan::active()->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains($activeLoan));
        $this->assertFalse($results->contains($returnedLoan));
    }

    /** @test */
    public function it_filters_overdue_loans()
    {
        $overdueLoan = BookLoan::factory()->create([
            'status' => BookLoan::STATUS_ACTIVE,
            'due_date' => now()->subDays(5)
        ]);

        $activeLoan = BookLoan::factory()->create([
            'status' => BookLoan::STATUS_ACTIVE,
            'due_date' => now()->addDays(5)
        ]);

        $results = BookLoan::overdue()->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains($overdueLoan));
    }

    /** @test */
    public function it_calculates_days_overdue_correctly()
    {
        $loan = BookLoan::factory()->create([
            'status' => BookLoan::STATUS_ACTIVE,
            'due_date' => now()->subDays(3)
        ]);

        $this->assertEquals(3, abs($loan->days_overdue));
    }

    /** @test */
    public function it_determines_if_loan_can_be_renewed()
    {
        $renewableLoan = BookLoan::factory()->create([
            'status' => BookLoan::STATUS_ACTIVE,
            'due_date' => now()->addDays(5),
            'renewal_count' => 0
        ]);

        $maxRenewalsLoan = BookLoan::factory()->create([
            'status' => BookLoan::STATUS_ACTIVE,
            'due_date' => now()->addDays(5),
            'renewal_count' => BookLoan::MAX_RENEWALS
        ]);

        $this->assertTrue($renewableLoan->canBeRenewed());
        $this->assertFalse($maxRenewalsLoan->canBeRenewed());
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $loan = new BookLoan();

        $this->assertEquals([
            'user_id',
            'physical_copy_id',
            'reservation_id',
            'loan_date',
            'due_date',
            'actual_return_date',
            'renewal_count',
            'status',
        ], $loan->getFillable());
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $loan = new BookLoan();

        $expectedCasts = [
            'loan_date' => 'datetime',
            'due_date' => 'datetime',
            'actual_return_date' => 'datetime',
            'renewal_count' => 'integer',
        ];

        $actualCasts = $loan->getCasts();

        // Remover casts automáticos
        unset($actualCasts['id']);
        unset($actualCasts['created_at']);
        unset($actualCasts['updated_at']);

        $this->assertEquals($expectedCasts, $actualCasts);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $user = \App\Models\User::factory()->create();
        $loan = BookLoan::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(\App\Models\User::class, $loan->user);
        $this->assertEquals($user->id, $loan->user_id);
    }

    /** @test */
    public function it_belongs_to_physical_copy()
    {
        $physicalCopy = \App\Models\PhysicalCopy::factory()->create();
        $loan = BookLoan::factory()->create(['physical_copy_id' => $physicalCopy->id]);

        $this->assertInstanceOf(\App\Models\PhysicalCopy::class, $loan->physicalCopy);
        $this->assertEquals($physicalCopy->id, $loan->physical_copy_id);
    }

    /** @test */
    public function it_can_be_renewed()
    {
        $loan = BookLoan::factory()->active()->create([
            'renewal_count' => 0,
            'due_date' => now()->addDays(5)
        ]);

        $this->assertTrue($loan->canBeRenewed());
    }

    /** @test */
    public function it_cannot_be_renewed_when_overdue()
    {
        $loan = BookLoan::factory()->create([
            'status' => 'overdue',
            'due_date' => now()->subDays(5)
        ]);

        $this->assertFalse($loan->canBeRenewed());
    }

    /** @test */
    public function it_cannot_be_renewed_when_max_renewals_reached()
    {
        $loan = BookLoan::factory()->active()->create([
            'renewal_count' => 2, // MAX_RENEWALS
            'due_date' => now()->addDays(5)
        ]);

        $this->assertFalse($loan->canBeRenewed());
    }

    /** @test */
    public function it_can_be_marked_as_returned()
    {
        $physicalCopy = \App\Models\PhysicalCopy::factory()->create(['status' => 'loaned']);
        $loan = BookLoan::factory()->active()->create([
            'physical_copy_id' => $physicalCopy->id
        ]);

        $result = $loan->markAsReturned();

        $this->assertTrue($result);
        $this->assertEquals('returned', $loan->status);
        $this->assertNotNull($loan->actual_return_date);
        $this->assertEquals('available', $physicalCopy->fresh()->status);
    }
}
