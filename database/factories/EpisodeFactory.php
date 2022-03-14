<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'air_date'        => $this->faker->word,
            'episode_number'  => $this->faker->randomNumber,
            'name'            => $this->faker->name,
            'overview'        => $this->faker->text,
            'production_code' => $this->faker->word,
            'season_id'       => \App\Models\Season::factory(),
            'season_number'   => $this->faker->randomNumber,
            'still'           => $this->faker->word,
            'tv_id'           => $this->faker->randomNumber,
            'type'            => $this->faker->word,
            'vote_average'    => $this->faker->word,
            'vote_count'      => $this->faker->randomNumber,
        ];
    }
}
