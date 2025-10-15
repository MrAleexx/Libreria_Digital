<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\BookReservation;
use App\Models\Book;
use App\Models\User;
use App\Models\PhysicalCopy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $reservation = new BookReservation();

        $this->assertEquals([
            'user_id',
            'book_id',
            'physical_copy_id',
            'reservation_date',
            'pickup_deadline',
            'status',
        ], $reservation->getFillable());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $user = User::factory()->create();
        $reservation = BookReservation::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $reservation->user);
        $this->assertEquals($user->id, $reservation->user->id);
    }

    /** @test */
    public function it_belongs_to_book()
    {
        $book = Book::factory()->create();
        $reservation = BookReservation::factory()->create(['book_id' => $book->id]);

        $this->assertInstanceOf(Book::class, $reservation->book);
        $this->assertEquals($book->id, $reservation->book->id);
    }

    /** @test */
    public function it_checks_status_correctly()
    {
        // Crear reservas con fechas futuras para evitar auto-expiración
        $pending = BookReservation::factory()->create([
            'status' => BookReservation::STATUS_PENDING,
            'pickup_deadline' => now()->addDays(2) // Fecha futura
        ]);
        $ready = BookReservation::factory()->create([
            'status' => BookReservation::STATUS_READY_FOR_PICKUP,
            'pickup_deadline' => now()->addDays(2) // Fecha futura
        ]);

        $this->assertTrue($pending->isPending());
        $this->assertTrue($ready->isReadyForPickup());
        $this->assertTrue($pending->isActive());
        $this->assertTrue($ready->isActive());
    }

    /** @test */
    public function it_marks_as_ready_for_pickup()
    {
        $reservation = BookReservation::factory()->create(['status' => BookReservation::STATUS_PENDING]);

        $result = $reservation->markAsReadyForPickup();

        $this->assertTrue($result);
        $this->assertEquals(BookReservation::STATUS_READY_FOR_PICKUP, $reservation->status);
    }

    /** @test */
    public function it_calculates_time_remaining()
    {
        $reservation = BookReservation::factory()->create([
            'status' => BookReservation::STATUS_PENDING,
            'pickup_deadline' => now()->addDays(2)->addHours(12) // 2.5 días para asegurar 2 días completos
        ]);

        $this->assertEquals('2 días', $reservation->time_remaining);
    }

    /** @test */
    public function it_auto_expires_past_reservations()
    {
        $reservation = BookReservation::factory()->create([
            'status' => BookReservation::STATUS_PENDING,
            'pickup_deadline' => now()->subDay()
        ]);

        // Simular el saving event del boot method
        $reservation->save();

        $this->assertEquals(BookReservation::STATUS_EXPIRED, $reservation->status);
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $reservation = new BookReservation();

        $expectedCasts = [
            'reservation_date' => 'datetime',
            'pickup_deadline' => 'datetime',
        ];

        $actualCasts = $reservation->getCasts();

        // Remover casts automáticos
        unset($actualCasts['id']);
        unset($actualCasts['created_at']);
        unset($actualCasts['updated_at']);

        $this->assertEquals($expectedCasts, $actualCasts);
    }

    /** @test */
    public function it_can_be_cancelled()
    {
        $reservation = BookReservation::factory()->pending()->create();

        $result = $reservation->markAsCancelled();

        $this->assertTrue($result);
        $this->assertEquals(BookReservation::STATUS_CANCELLED, $reservation->status);
    }

    /** @test */
    public function it_can_be_marked_as_picked_up()
    {
        $reservation = BookReservation::factory()->readyForPickup()->create();

        $result = $reservation->markAsPickedUp();

        $this->assertTrue($result);
        $this->assertEquals(BookReservation::STATUS_PICKED_UP, $reservation->status);
    }

    /** @test */
    public function it_can_be_marked_as_expired()
    {
        $reservation = BookReservation::factory()->pending()->create();

        $result = $reservation->markAsExpired();

        $this->assertTrue($result);
        $this->assertEquals(BookReservation::STATUS_EXPIRED, $reservation->status);
    }

    /** @test */
    public function it_filters_pending_reservations()
    {
        $pending = BookReservation::factory()->pending()->create();
        $ready = BookReservation::factory()->readyForPickup()->create();

        $results = BookReservation::pending()->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains($pending));
        $this->assertFalse($results->contains($ready));
    }

    /** @test */
    public function it_filters_ready_for_pickup_reservations()
    {
        $pending = BookReservation::factory()->pending()->create();
        $ready = BookReservation::factory()->readyForPickup()->create();

        $results = BookReservation::readyForPickup()->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains($ready));
        $this->assertFalse($results->contains($pending));
    }

    /** @test */
    public function it_filters_active_reservations()
    {
        $pending = BookReservation::factory()->pending()->create();
        $ready = BookReservation::factory()->readyForPickup()->create();
        $cancelled = BookReservation::factory()->cancelled()->create();

        $results = BookReservation::active()->get();

        $this->assertCount(2, $results);
        $this->assertTrue($results->contains($pending));
        $this->assertTrue($results->contains($ready));
        $this->assertFalse($results->contains($cancelled));
    }

    /** @test */
    public function it_returns_correct_status_info()
    {
        $pending = BookReservation::factory()->pending()->create();
        $ready = BookReservation::factory()->readyForPickup()->create();
        $expired = BookReservation::factory()->expired()->create();

        $this->assertEquals(['label' => 'Pendiente', 'color' => 'warning'], $pending->status_info);
        $this->assertEquals(['label' => 'Listo para recoger', 'color' => 'info'], $ready->status_info);
        $this->assertEquals(['label' => 'Expirado', 'color' => 'danger'], $expired->status_info);
    }

    /** @test */
    public function it_can_be_cancelled_when_pending_or_ready()
    {
        $pending = BookReservation::factory()->pending()->create();
        $ready = BookReservation::factory()->readyForPickup()->create();
        $pickedUp = BookReservation::factory()->pickedUp()->create();

        $this->assertTrue($pending->canBeCancelled());
        $this->assertTrue($ready->canBeCancelled());
        $this->assertFalse($pickedUp->canBeCancelled());
    }
}
