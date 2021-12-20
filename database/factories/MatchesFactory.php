<?php

namespace Database\Factories;

use App\Models\Matches;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Matches::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'time_visitante_id' => rand(1,10),
            'time_casa_id' => rand(11,20),
            'gols_visitante' => rand(0,5),
            'gols_em_casa' => rand(0,5)
        ];
    }
}
