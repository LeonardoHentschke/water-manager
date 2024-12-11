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
            // Captura as datas dos parâmetros ou usa o padrão (início e fim do dia atual)
            $dateIni = $request->query('DATEINI', now()->startOfDay()->format('Y-m-d H:i:s'));
            $dateFin = $request->query('DATAFIN', now()->endOfDay()->format('Y-m-d H:i:s'));
    
            // Formata o URL com as datas
            $url = "http://177.44.248.13:8080/WaterManager/?op=SELECT&DATEINI=" 
                 . urlencode($dateIni) 
                 . "&DATAFIN=" 
                 . urlencode($dateFin) 
                 . "&FORMAT=JSON";

            return Http::get($url);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro inesperado', 'message' => $e->getMessage()], 500);
        }
    }    

}