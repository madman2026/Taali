<?php

namespace Modules\Content\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Content\Enums\ContentStatusEnum;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Content\Models\Content::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(5),
            'excerpt' => $this->faker->paragraph(1),
            'published_at' => $this->faker->date(),
            'status' => $this->faker->randomElement([
                ContentStatusEnum::REJECTED,
                ContentStatusEnum::PENDING,
                ContentStatusEnum::APPROVED,
            ]),

        ];
    }
}
