<?php

namespace Modules\Media\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Media\Models\Media::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

