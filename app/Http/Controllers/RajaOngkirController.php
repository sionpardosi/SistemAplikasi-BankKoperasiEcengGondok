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
    protected $originCity = 78; // ID Kota Palembang di RajaOngkir
    protected $defaultWeight = 500;

    public function __construct()
    {
        $this->apiKey = '7ff8406f12c653758df1a5fa6d6bf474';
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
            $address = UserAddress::findOrFail($id);
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
        $request->validate([
            'city_id' => 'required|numeric',
            'courier' => 'required|in:jne,pos,tiki'
        ]);

        try {
            $weight = 0;
            foreach (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content() as $item) {

                $weight += ($this->defaultWeight * $item->qty);
            }

            if ($weight <= 0) {
                $weight = $this->defaultWeight;
            }

            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $this->originCity,
                'destination' => $request->city_id,
                'weight' => $weight,
                'courier' => $request->courier
            ]);

            $shippingCosts = $response->json()['rajaongkir']['results'][0]['costs'];
            return response()->json([
                'status' => 'success',
                'data' => $shippingCosts
            ]);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Cost Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghitung ongkos kirim: ' . $e->getMessage()
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
