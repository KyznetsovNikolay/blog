<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        static $counter = 0;
        $idx = $counter++;

        return [
            'name' => $this->getCategories()[$idx],
        ];
    }

    private function getCategories(): array
    {
        return [
            'Музыка',
            'Спорт',
            'IT',
            'Книги',
            'Фильмы',
        ];
    }
}
