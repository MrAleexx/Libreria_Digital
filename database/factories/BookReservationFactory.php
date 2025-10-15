<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookReservationFactory extends Factory
{
    public function definition(): array
    {
        $reservationDate = fake()->dateTimeBetween('-7 days', 'now');
        $pickupDeadline = (clone $reservationDate)->modify('+3 days');

        return [
            'user_id' => \App\Models\User::factory(),
            'book_id' => \App\Models\Book::factory(),
            'physical_copy_id' => null,
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'pending',
        ];
    }

    public function pending()
    {
        $reservationDate = fake()->dateTimeBetween('-2 days', 'now');
        $pickupDeadline = (clone $reservationDate)->modify('+3 days');

        return $this->state(fn(array $attributes) => [
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'pending',
        ]);
    }

    public function readyForPickup()
    {
        $reservationDate = fake()->dateTimeBetween('-2 days', 'now');
        $pickupDeadline = (clone $reservationDate)->modify('+3 days');

        return $this->state(fn(array $attributes) => [
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'ready_for_pickup',
        ]);
    }

    public function pickedUp()
    {
        $reservationDate = fake()->dateTimeBetween('-5 days', '-3 days');
        $pickupDeadline = (clone $reservationDate)->modify('+3 days');

        return $this->state(fn(array $attributes) => [
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'picked_up',
        ]);
    }

    public function cancelled()
    {
        $reservationDate = fake()->dateTimeBetween('-5 days', '-2 days');
        $pickupDeadline = (clone $reservationDate)->modify('+3 days');

        return $this->state(fn(array $attributes) => [
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'cancelled',
        ]);
    }

    public function expired()
    {
        $reservationDate = fake()->dateTimeBetween('-5 days', '-4 days');
        $pickupDeadline = (clone $reservationDate)->modify('+1 day'); // Ya expirado

        return $this->state(fn(array $attributes) => [
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'expired',
        ]);
    }

    public function withPhysicalCopy($physicalCopy = null)
    {
        return $this->state(fn(array $attributes) => [
            'physical_copy_id' => $physicalCopy ? $physicalCopy->id : \App\Models\PhysicalCopy::factory(),
        ]);
    }

    public function forUser($user)
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    public function forBook($book)
    {
        return $this->state(fn(array $attributes) => [
            'book_id' => $book->id,
        ]);
    }

    public function withPastDeadline()
    {
        $reservationDate = fake()->dateTimeBetween('-5 days', '-4 days');
        $pickupDeadline = (clone $reservationDate)->modify('+1 day'); // Ya expirado

        return $this->state(fn(array $attributes) => [
            'reservation_date' => $reservationDate,
            'pickup_deadline' => $pickupDeadline,
            'status' => 'pending', // Pendiente pero con deadline pasado
        ]);
    }
}
