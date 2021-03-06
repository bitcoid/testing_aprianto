<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaksi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
		return [  
			'tgl_request' => $this->faker->dateTime,
			'karyawan_id' => \App\Models\Karyawan::inRandomOrder()->first()->karyawan_id
        ];
    }
} 
