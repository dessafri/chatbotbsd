<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBuktiFakturController extends Controller
{
    public function index(Request $request)
    {
        $nofaktur  = $request->nofaktur;
        $handphone = $request->handphone;
        $getData   = Penagihan::where('nomorfaktur', $nofaktur)
            ->where('nomor_handphone', $handphone)
            ->first();
        if (! $getData) {
            return response()->json(['message' => 'Data tidak ditemukan'], 200);
        }
        $token = base64_encode(env('API_TOKEN'));
        return response()->json([
            'status' => 'success',
            'data'   => [
                'message' => url('bukti_faktur/' . base64_encode($getData->bukti_faktur)) . '/' . $token,
            ],
        ]);

    }
    public function getCustomer()
    {
        try {
            // Fetch customers with the related cabangs data
            $customers = DB::select("
                SELECT
                    penagihans.nama_customer AS name,
                    penagihans.kode_order,
                    penagihans.nomor_handphone,
                    penagihans.dear_text,
                    cabangs.kode_cabang,
                    cabangs.nomor_rekening,
                    cabangs.nama_rekening,
                    cabangs.kode_bank,
                    cabangs.nama_cabang,
                    SUM(penagihans.piutang) AS total_faktur,
                    CONCAT(
                        '[',
                        GROUP_CONCAT(
                            JSON_OBJECT(
                                'No Faktur', penagihans.nomorfaktur,
                                'nilai_faktur', penagihans.piutang,
                                'tgl_faktur', penagihans.tgl_faktur
                            )
                        ),
                        ']'
                    ) AS faktur
                FROM penagihans
                JOIN cabangs ON penagihans.kode_cabang = cabangs.kode_cabang
                WHERE penagihans.status = 0
                GROUP BY
                    penagihans.nama_customer,
                    penagihans.kode_order,
                    penagihans.nomor_handphone,
                    penagihans.dear_text,
                    penagihans.kode_cabang,
                    cabangs.kode_cabang,
                    cabangs.nomor_rekening,
                    cabangs.nama_rekening,
                    cabangs.kode_bank,
                    cabangs.nama_cabang 
            ");

            $customers = collect($customers)->map(function ($customer) {
                                                                          // Decode the 'faktur' JSON string into an array
                $customer->faktur = json_decode($customer->faktur, true); // true returns an associative array
                return $customer;
            });

            // Return the response with customers and their cabang data
            return response()->json([
                'status'     => 'success',
                'statusCode' => 200,
                'data'       => $customers, // Send the customers data
            ]);

        } catch (\Exception $e) {
            // Log the error if any exception occurs
            \Log::error('Error fetching customer data: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch customer data.',
            ], 500);
        }
    }
}
