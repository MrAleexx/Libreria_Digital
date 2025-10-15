<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookLoanFactory extends Factory
{
    public function definition(): array
    {
        $loanDate = fake()->dateTimeBetween('-30 days', 'now');
        $dueDate = (clone $loanDate)->modify('+14 days');

        return [
            'user_id' => \App\Models\User::factory(),
            'physical_copy_id' => \App\Models\PhysicalCopy::factory(),
            'reservation_id' => null,
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'actual_return_date' => null,
            'renewal_count' => 0,
            'status' => 'active',
        ];
    }

    public function active()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
            'actual_return_date' => null,
        ]);
    }

    public function returned()
    {
        $loanDate = fake()->dateTimeBetween('-30 days', '-15 days');
        $dueDate = (clone $loanDate)->modify('+14 days');
        $returnDate = (clone $dueDate)->modify('-2 days');

        return $this->state(fn(array $attributes) => [
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'actual_return_date' => $returnDate,
            'status' => 'returned',
        ]);
    }

    public function overdue()
    {
        $loanDate = fake()->dateTimeBetween('-30 days', '-20 days');
        $dueDate = (clone $loanDate)->modify('+14 days');

        return $this->state(fn(array $attributes) => [
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'actual_return_date' => null,
            'status' => 'overdue',
        ]);
    }

    public function withRenewals($count)
    {
        $loanDate = fake()->dateTimeBetween('-30 days', 'now');
        $dueDate = (clone $loanDate)->modify('+14 days')->modify("+{$count} weeks");

        return $this->state(fn(array $attributes) => [
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'renewal_count' => $count,
        ]);
    }

    public function forUser($user)
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    public function forPhysicalCopy($physicalCopy)
    {
        return $this->state(fn(array $attributes) => [
            'physical_copy_id' => $physicalCopy->id,
        ]);
    }
}
