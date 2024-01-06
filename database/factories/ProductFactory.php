<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition(): array
    {
        // Generate a random storage path
        $storagePath = 'public/images/' . Str::random(10);

        // Create a temporary file in the storage path
        $tempFile = tmpfile();
        $tempPath = stream_get_meta_data($tempFile)['uri'];
        file_put_contents($tempPath, $this->faker->image());

        // Move the temporary file to the storage path
        $file = new \Illuminate\Http\File($tempPath);
        Storage::put($storagePath, $file);

        return [
            'name' => $this->faker->unique()->word,
            'category' => $this->faker->randomElement(['Electronics', 'Clothing', 'Home', 'Books']),
            'description' => $this->faker->sentence,
            'date_time' => $this->faker->dateTime,
            'images' => $storagePath,
        ];
    }
}
