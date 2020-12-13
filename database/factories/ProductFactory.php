<?php


namespace Database\Factories;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'identifier' => $this->faker->unique()->text(10),
            'description' => $this->faker->text(50),
            'categories' => json_encode([$this->faker->text(15),$this->faker->text(20)]),
            'images' => json_encode([$this->faker->text(15),$this->faker->text(20)]),
            'prices' => json_encode([
                [
                    'price'=>$this->faker->randomFloat(null,2,50),
                    'validFrom' => Carbon::now()->addDays($this->faker->numberBetween(1,30))->toDateTimeString(),
                    'validTo' => Carbon::now()->addDays($this->faker->numberBetween(1,30))->toDateTimeString()
                ]
            ]),
        ];
    }
}
