<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirController extends Controller
{
    protected $apiKey;
    protected $originCity = 389; // ID Kabupaten Samosir di RajaOngkir
    protected $defaultWeight = 500;

    public function __construct()
    {
        $this->apiKey = '7ff8406f12c653758df1a5fa6d6bf474';
    }

    /**
     * Method baru untuk mendapatkan informasi kota asal (untuk verifikasi)
     */
    public function getOriginCityInfo()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get('https://api.rajaongkir.com/starter/city', [
                'id' => $this->originCity
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Origin city information retrieved successfully',
                    'data' => [
                        'origin_city_id' => $this->originCity,
                        'city_info' => $data['rajaongkir']['results']
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get origin city info'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Origin City Info Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get('https://api.rajaongkir.com/starter/province');

            $provinces = $response->json()['rajaongkir']['results'];
            return response()->json([
                'status' => 'success',
                'data' => $provinces
            ]);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Province Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat data provinsi'
            ], 500);
        }
    }

    public function userAddressGetAddress($id)
    {
        try {
            $address = Address::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $address
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Alamat tidak ditemukan'
            ], 404);
        }
    }

    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get('https://api.rajaongkir.com/starter/city', [
                'province' => $provinceId
            ]);

            $cities = $response->json()['rajaongkir']['results'];
            return response()->json([
                'status' => 'success',
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            Log::error('RajaOngkir City Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat data kota'
            ], 500);
        }
    }

    public function calculateShipping(Request $request)
    {
        // Enhanced validation dengan custom messages
        $request->validate([
            'city_id' => 'required|numeric',
            'courier' => 'required|in:jne,pos,tiki,jnt'
        ], [
            'city_id.required' => 'ID Kota harus diisi',
            'city_id.numeric' => 'ID Kota harus berupa angka',
            'courier.required' => 'Kurir harus dipilih',
            'courier.in' => 'Kurir yang dipilih tidak valid'
        ]);

        try {
            // Calculate weight from cart
            $weight = 0;
            $cartItems = \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content();

            Log::info('Cart contents for shipping calculation', [
                'cart_count' => $cartItems->count(),
                'cart_items' => $cartItems->toArray()
            ]);

            foreach ($cartItems as $item) {
                $weight += ($this->defaultWeight * $item->qty);
            }

            if ($weight <= 0) {
                $weight = $this->defaultWeight;
            }

            // Log request parameters
            Log::info('Shipping calculation request', [
                'origin_city_id' => $this->originCity,
                'destination_city_id' => $request->city_id,
                'weight' => $weight,
                'courier' => $request->courier,
                'api_key_length' => strlen($this->apiKey)
            ]);

            // Make API request to RajaOngkir
            $response = Http::timeout(30)->withHeaders([
                'key' => $this->apiKey
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $this->originCity,
                'destination' => $request->city_id,
                'weight' => $weight,
                'courier' => $request->courier
            ]);

            // Log raw response
            Log::info('RajaOngkir API Response', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'response_successful' => $response->successful()
            ]);

            // Check if request was successful
            if (!$response->successful()) {
                Log::error('RajaOngkir API request failed', [
                    'status_code' => $response->status(),
                    'response_body' => $response->body()
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'API RajaOngkir tidak dapat diakses. Status: ' . $response->status()
                ], 500);
            }

            $result = $response->json();

            // Check response structure
            if (!isset($result['rajaongkir'])) {
                Log::error('Invalid RajaOngkir response structure', ['response' => $result]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Format response API tidak valid'
                ], 500);
            }

            // Check for API errors
            if (isset($result['rajaongkir']['status']['code']) && $result['rajaongkir']['status']['code'] != 200) {
                Log::error('RajaOngkir API error', [
                    'error_code' => $result['rajaongkir']['status']['code'],
                    'error_description' => $result['rajaongkir']['status']['description']
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Error API: ' . $result['rajaongkir']['status']['description']
                ], 500);
            }

            // Check if results exist
            if (!isset($result['rajaongkir']['results']) || empty($result['rajaongkir']['results'])) {
                Log::error('No shipping results found', [
                    'courier' => $request->courier,
                    'origin' => $this->originCity,
                    'destination' => $request->city_id
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada layanan pengiriman tersedia untuk rute ini'
                ], 500);
            }

            // Check if costs exist
            if (!isset($result['rajaongkir']['results'][0]['costs']) || empty($result['rajaongkir']['results'][0]['costs'])) {
                Log::error('No shipping costs found', [
                    'courier' => $request->courier,
                    'results' => $result['rajaongkir']['results'][0]
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan pengiriman tidak tersedia untuk kurir ' . strtoupper($request->courier)
                ], 500);
            }

            $shippingCosts = $result['rajaongkir']['results'][0]['costs'];

            Log::info('Shipping calculation successful', [
                'services_found' => count($shippingCosts),
                'courier' => $request->courier
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $shippingCosts,
                'meta' => [
                    'origin_info' => 'Kabupaten Samosir, Sumatera Utara',
                    'origin_city_id' => $this->originCity,
                    'destination_city_id' => $request->city_id,
                    'weight' => $weight . ' gram',
                    'courier' => strtoupper($request->courier)
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in shipping calculation', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Exception in shipping calculation', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveShippingCost(Request $request)
    {
        $request->validate([
            'shipping_cost' => 'required|numeric',
            'shipping_service' => 'required|string'
        ]);

        session()->put('shipping', [
            'cost' => $request->shipping_cost,
            'service' => $request->shipping_service
        ]);

        $checkout = session()->get('checkout');
        if ($checkout) {
            $total = $checkout['total'] + $request->shipping_cost;
            session()->put('checkout.shipping', $request->shipping_cost);
            session()->put('checkout.total', $total);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Ongkos kirim berhasil disimpan',
            'data' => session()->get('checkout')
        ]);
    }
}
