<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample brand data for e-commerce focused on Eceng Gondok products
        $brands = [
            [
                'name' => 'EcoGondok',
                'description' => 'Merek premium untuk produk ramah lingkungan dari eceng gondok berkualitas tinggi.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'GreenCraft',
                'description' => 'Spesialis kerajinan tangan dari bahan alami eceng gondok dengan desain modern.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'NaturalWeave',
                'description' => 'Produk anyaman eceng gondok dengan sentuhan tradisional Indonesia.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'EcoArt',
                'description' => 'Seni dan kerajinan berkelanjutan dari eceng gondok untuk dekorasi rumah.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'WaterHyacinth Co',
                'description' => 'Inovasi produk eceng gondok untuk keperluan rumah tangga dan komersial.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'GondokCraft',
                'description' => 'Kerajinan autentik eceng gondok dengan kualitas ekspor internasional.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'SustainableHome',
                'description' => 'Solusi rumah berkelanjutan dengan produk furniture eceng gondok.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'TropicalWave',
                'description' => 'Desain tropical modern untuk produk lifestyle dari eceng gondok.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'HandmadeHeritage',
                'description' => 'Warisan kerajinan tangan tradisional dengan bahan eceng gondok pilihan.',
                'is_active' => false,
                'is_featured' => false,
            ],
            [
                'name' => 'EcoLiving',
                'description' => 'Gaya hidup ramah lingkungan dengan produk eceng gondok berkualitas.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'ArtisanTouch',
                'description' => 'Sentuhan artisan lokal dalam setiap produk eceng gondok handmade.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'GreenStyle',
                'description' => 'Fashion dan aksesori stylish dari bahan eceng gondok yang sustainable.',
                'is_active' => false,
                'is_featured' => false,
            ],
        ];

        foreach ($brands as $index => $brandData) {
            $brand = new Brand();
            $brand->name = $brandData['name'];
            $brand->slug = Str::slug($brandData['name']);
            $brand->description = $brandData['description'];
            $brand->is_active = $brandData['is_active'];
            $brand->is_featured = $brandData['is_featured'];

            // Generate sample image filename (in real scenario, you would have actual images)
            $brand->image = 'brand-' . ($index + 1) . '.png';

            // Set random created dates within last 6 months
            $brand->created_at = Carbon::now()->subDays(rand(1, 180));
            $brand->updated_at = $brand->created_at->copy()->addDays(rand(0, 30));

            $brand->save();
        }

        $this->command->info('Brand seeder completed successfully!');
        $this->command->info('Created ' . count($brands) . ' brands');
        $this->command->info('Active brands: ' . Brand::active()->count());
        $this->command->info('Featured brands: ' . Brand::featured()->count());
    }
}

/**
 * Additional Seeder for Brand Images (Optional)
 * You can run this separately to create sample brand images
 */
class BrandImageSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::all();
        $imageColors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
            '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9',
            '#F8C471', '#82E0AA', '#F1948A', '#85C1E9'
        ];

        foreach ($brands as $index => $brand) {
            $this->createSampleBrandImage(
                $brand->name,
                $brand->image,
                $imageColors[$index % count($imageColors)]
            );
        }

        $this->command->info('Brand images created successfully!');
    }

    private function createSampleBrandImage($brandName, $filename, $backgroundColor)
    {
        $width = 300;
        $height = 300;

        // Create image
        $image = imagecreate($width, $height);

        // Colors
        $bgColor = $this->hexToRgb($backgroundColor);
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $bg = imagecolorallocate($image, $bgColor['r'], $bgColor['g'], $bgColor['b']);

        // Fill background
        imagefill($image, 0, 0, $bg);

        // Add brand name
        $fontSize = 24;
        $fontFile = public_path('fonts/arial.ttf'); // You'll need to add a font file

        // If font file doesn't exist, use built-in font
        if (!file_exists($fontFile)) {
            $fontSize = 5;
            $textBounds = imagettfbbox($fontSize, 0, $fontFile, $brandName);
            $x = ($width - $textBounds[4]) / 2;
            $y = ($height - $textBounds[5]) / 2;
            imagestring($image, $fontSize, $x, $y, $brandName, $textColor);
        } else {
            $textBounds = imagettfbbox($fontSize, 0, $fontFile, $brandName);
            $x = ($width - $textBounds[4]) / 2;
            $y = ($height - $textBounds[5]) / 2;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontFile, $brandName);
        }

        // Save image
        $uploadPath = public_path('uploads/brands');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        imagepng($image, $uploadPath . '/' . $filename);
        imagedestroy($image);
    }

    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }
}

/**
 * Factory for Brand model (if you want to use factories instead)
 * File: database/factories/BrandFactory.php
 */
class BrandFactoryExample
{
    public static function definition()
    {
        $ecoWords = [
            'Eco', 'Green', 'Natural', 'Bio', 'Organic', 'Pure', 'Fresh',
            'Clean', 'Earth', 'Leaf', 'Tree', 'Ocean', 'River', 'Garden'
        ];

        $craftWords = [
            'Craft', 'Art', 'Weave', 'Design', 'Studio', 'Works', 'Co',
            'Lab', 'House', 'Collection', 'Heritage', 'Traditional', 'Modern'
        ];

        $name = fake()->randomElement($ecoWords) . fake()->randomElement($craftWords);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(12),
            'image' => 'brand-' . fake()->numberBetween(1, 10) . '.png',
            'is_active' => fake()->boolean(85), // 85% chance of being active
            'is_featured' => fake()->boolean(30), // 30% chance of being featured
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
