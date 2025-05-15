<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplierRequest>
 */
class SupplierRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'nama' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'no_hp' => $this->faker->phoneNumber(),
            'no_wa' => $this->faker->phoneNumber(),
            'lokasi' => 'Samosir',
            'estimasi_kg' => $this->faker->numberBetween(5, 50),
            'insentif' => $this->faker->randomElement(['diskon', 'uang_tunai']),
            'foto' => 'storage/foto_request/example.jpg',
            'catatan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'disetujui', 'ditolak']),
            'kupon_id' => null,
            'catatan_admin' => null,
        ];
    }
}
