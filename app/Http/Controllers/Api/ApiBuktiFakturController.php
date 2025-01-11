<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penagihan;
use Illuminate\Http\Request;

class ApiBuktiFakturController extends Controller
{
    public function index(Request $request)
    {
        $nofaktur = $request->nofaktur;
        $handphone = $request->handphone;
        $getData = Penagihan::where('nomorfaktur', $nofaktur)
            ->where('nomor_handphone', $handphone)
            ->first();
        if (!$getData) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $token = base64_encode(env('API_TOKEN'));
        return response()->json([
            'status' => 'success',
            'data' => [
                'image' => url('bukti_faktur/' . base64_encode($getData->bukti_faktur)) . '/' . $token,
            ],
        ]);

    }
}
