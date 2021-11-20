<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arrayValues = ['pak', 'box'];
	     
		return [
            'kode' => $this->faker->numerify('###.###.####'),
            'nama_brg' => $this->faker->text(20),
			'lokasi' => $this->faker->state,
			'stok' => $this->faker->randomDigit,
			'satuan' => $arrayValues[rand(0,1)]
        ];
    }
} 
