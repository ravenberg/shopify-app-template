<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shop' => $this->faker->domainWord . '.myshopify.com',
            'state' => $this->faker->uuid,
            'scope' => 'write_products,read_products',
            'access_token' => 'shpat_' . $this->faker->regexify('[a-f0-9]{32}'),
        ];
    }
}
