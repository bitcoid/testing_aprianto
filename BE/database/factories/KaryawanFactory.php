<?php

namespace Database\Factories;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Karyawan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
		return [ 
            'nik' => $this->faker->numerify('###.###'),
			'nama' => $this->faker->name,
			'departement_id' => \App\Models\Departement::inRandomOrder()->first()->departement_id
        ];
    }
} 
