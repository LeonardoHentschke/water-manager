<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyWaterManagerController extends Controller {

    public function fetchProductIds() {
        try {
            $url = 'http://177.44.248.13:8080/WaterManager/productID.jsp?FORMAT=JSON';
            $response = Http::get($url);

            if (!$response->successful()) {
                $url = 'http://177.44.248.13:8080/WaterManager/productID.jsp';
                $response = Http::get($url);
            }

            return $response->successful()
                ? $response
                : response()->json(['error' => 'Erro ao acessar o servidor remoto'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro inesperado', 'message' => $e->getMessage()], 500);
        }
    }

    public function searchData(Request $request) {
        try {

            $url = 'http://177.44.248.13:8080/WaterManager/?op=SELECT&DATEINI=2024-10-01%2000:00:00&DATAFIN=2024-10-02%2024:00:00&FORMAT=JSON';
            return Http::get($url);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro inesperado', 'message' => $e->getMessage()], 500);
        }
    }

    public function insertData(Request $request) {
        try {


            $request->validate([
                'productID' => 'required',
                'date' => 'required',
                'value' => 'required',
            ]);


            $url = 'http://177.44.248.13:8080/WaterManager/?op=INSERT&FORMAT=JSON';
            return Http::post($url, $request->all());

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro inesperado', 'message' => $e->getMessage()], 500);
        }
    }

}