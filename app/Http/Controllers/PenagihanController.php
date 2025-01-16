<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePenagihanRequest;
use App\Models\Cabang;
use App\Models\Penagihan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penagihans = Penagihan::all();
        return view('penagihan.penagihan', compact('penagihans'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function importExcel(Request $request)
    {
        try {
            $data = [];
            // Validate file
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            // Get the uploaded file
            $file          = $request->file('file');
            $inputFileType = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $filePath      = $file->getRealPath();

            // Create reader and load the file
            $reader      = IOFactory::createReader(ucfirst($inputFileType));
            $spreadsheet = $reader->load($filePath);

            // Loop through the worksheet data
            $worksheet = $spreadsheet->getActiveSheet();
            $rows      = $worksheet->toArray();
            $startRow  = 5; // Assuming data starts from row 5

            foreach ($rows as $index => $row) {
                if ($index < $startRow) {
                    continue;
                }
                // Skip rows before data starts

                // Extract data from the row
                $nama_customer = $row[7];
                $no_faktur     = $row[1];
                $nilai_faktur  = intval(str_replace(',', '', $row[11]));
                $pembayaran    = intval(str_replace(',', '', $row[13]));
                $kode_pesan    = $row[5];
                $nilai_piutang = intval(str_replace(',', '', $row[15]));
                $kode_cabang   = $row[17];
                $tgl_faktur    = Carbon::parse($row[4])->format('Y-m-d');
                $nohp_customer = str_replace("08", "628", $this->clean($row[9]));

                if (empty($nohp_customer)) {
                    continue;
                }

                // Prepare data for insertion
                $dearText   = $this->getDearText($nama_customer);
                $dataCabang = Cabang::where('kode_cabang', $kode_cabang)->first();
                $message    = "Yth $dearText $nama_customer, Selamat Siang kami dari $dataCabang->nama_cabang menginformasikan Tagihan Faktur sbb:
                            \n\nNo Faktur : $no_faktur
                            \n\nNilai Faktur : Rp " . number_format($nilai_faktur) . "
                            \n\nNilai Terbayar : Rp " . number_format($pembayaran) . "
                            \n\nSisa Tagihan : Rp " . number_format($nilai_piutang) . "
                            \n\nJatuh Tempo : " . Carbon::parse($tgl_faktur)->addDays(30)->format('d M Y') . "
                            \n\nPembayaran bisa melalui transfer rekening $dataCabang->kode_bank $dataCabang->nomor_rekening a/n. $dataCabang->nama_rekening. Mohon diinformasikan setelah transfer.";

                // Prepare the data array
                $data[] = [
                    'tgl_faktur'      => $tgl_faktur,
                    'nomorfaktur'     => $no_faktur,
                    'nama_customer'   => $nama_customer,
                    'piutang'         => $nilai_piutang,
                    'pembayaran'      => $pembayaran,
                    'nilai_faktur'    => $nilai_faktur,
                    'nomor_handphone' => $nohp_customer,
                    'kode_order'      => $kode_pesan,
                    'message'         => $message,
                    'dear_text'       => $dearText,
                    'kode_cabang'     => $kode_cabang,
                    'waktu_upload'    => now(),
                ];
            }

            // Insert the data into the 'penagihan' table
            Penagihan::insert($data);

            // Success message
            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (Exception $e) {
            // Handle errors
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function clean($input)
    {
        return trim($input);
    }

    private function getDearText($nama_customer)
    {
        $dearText = "";
        if (substr($nama_customer, 0, 4) == "Dr." || substr($nama_customer, 0, 4) == "Bpk" || substr($nama_customer, 0, 4) == "Ibu") {
            $dearText = "Bpk/Ibu ";
        }
        return $dearText;
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenagihanRequest $request)
    {
        //
    }
    public function bukti_faktur($image, $token)
    {
        // Decode the token and image
        $decodeToken = base64_decode($token);
        $decodeImage = base64_decode($image);

        if ($decodeToken === env('API_TOKEN')) {
            $imagePath = public_path('bukti_faktur/' . $decodeImage);

            // Check if the file exists
            if (file_exists($imagePath)) {
                // Return the file for download
                return response()->download($imagePath, $decodeImage, [
                    'Content-Type' => mime_content_type($imagePath),
                ]);
            } else {
                // File not found, return 404 response
                return response()->json(['error' => 'File not found'], 404);
            }
        }

        // If token does not match, return unauthorized response
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('penagihan.uploadfaktur');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            // Find the Cabang by ID and delete it
            $penagihan   = Penagihan::findOrFail($id);
            $name_faktur = $penagihan->nomorfaktur;
            return view('penagihan.edit', compact('penagihan', 'name_faktur'));
        } catch (\Exception $e) {
            // Handle decryption or deletion failure
            return redirect()->route('penagihan.index')->with('error', 'Invalid or corrupted ID!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $penagihan = Penagihan::findOrFail(decrypt($id));
        $data      = $request->all();

        if (isset($data['nilai_faktur'])) {
            $data['nilai_faktur'] = cleanCurrency($data['nilai_faktur']);
        }

        if (isset($data['piutang'])) {
            $data['piutang'] = cleanCurrency($data['piutang']);
        }

        if (isset($data['pembayaran'])) {
            $data['pembayaran'] = cleanCurrency($data['pembayaran']);
        }

        // if ($request->hasFile('bukti_faktur')) {
        //     // Get the uploaded file
        //     $img              = request()->file('bukti_faktur');
        //     $img_ext          = $img->getClientOriginalExtension();
        //     $encryptedContent = file_get_contents($img->getRealPath());
        //     $encryptedContent = encrypt($encryptedContent);
        //     $img_name_new     = uniqid() . Str::random(60) . rand(12345678999999, 9999999998888) . uniqid() . "." . $img_ext;
        //     $dest_path        = public_path('bukti_faktur');
        //     $img->move($dest_path, $img_name_new);

        //     // Store the image path in the database
        //     $data['bukti_faktur'] = $img_name_new;

        // }

        $penagihan->update($data);

        return redirect()->route('penagihan.index')->with('success', 'Faktur updated successfully');
    }
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Retrieve the records based on the kode_order
            $penagihans = Penagihan::where('kode_order', $id)->get();

            foreach ($penagihans as $penagihan) {
                $data                = $request->all();
                $data['waktu_kirim'] = Carbon::now()->toDateTimeString();
                $penagihan->update($data);
            }

            // Commit the transaction if all updates are successful
            DB::commit();
            // Redirect with a success message
            return response()->json(['statusCode' => 200, 'Message' => 'Success Update Penagihan']);
        } catch (\Exception $e) {
            // If any error occurs, roll back the transaction
            DB::rollBack();

            // Optionally, log the exception or return an error response
            return response()->json(['statusCode' => 500, 'Message' => $e]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penagihan $penagihan)
    {
        //
    }

    public function uploadBuktiFaktur(Request $request)
    {
        // Check if files exist
        if ($request->hasFile('bukti_faktur')) {
            $uploadedFiles  = $request->file('bukti_faktur');
            $savedImages    = [];
            $notFoundFaktur = [];

            foreach ($uploadedFiles as $file) {
                // Process each file
                $img                = $file;
                $img_ext            = $img->getClientOriginalExtension();
                $originalFilename   = $img->getClientOriginalName();
                $filenameWithoutExt = pathinfo($originalFilename, PATHINFO_FILENAME);
                $encryptedContent   = file_get_contents($img->getRealPath());
                $encryptedContent   = encrypt($encryptedContent);

                // Find Penagihan by faktur number
                $penagihan = Penagihan::where('nomorfaktur', $filenameWithoutExt)->first();

                if ($penagihan) {
                    // Check if bukti_faktur already exists
                    if ($penagihan->bukti_faktur) {
                        // If bukti_faktur already exists, delete the old file
                        $oldFilePath = public_path('bukti_faktur/' . $penagihan->bukti_faktur);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    // Check if the status is 1 (already sent)
                    if ($penagihan->status == 1) {
                        // If status is 1, return an alert and skip the update
                        $notFoundFaktur[] = $filenameWithoutExt . ' - Data sudah terkirim dan tidak bisa diupdate.';
                        continue;
                    }

                    // Proceed with the file upload and update the database
                    $img_name_new = uniqid() . Str::random(60) . rand(12345678999999, 9999999998888) . uniqid() . "." . $img_ext;
                    $dest_path    = public_path('bukti_faktur');
                    $img->move($dest_path, $img_name_new);

                    // Save the new image name in the database
                    $penagihan->bukti_faktur = $img_name_new;
                    $penagihan->save();
                } else {
                    // If faktur not found, skip the upload and add to notFoundFaktur array
                    $notFoundFaktur[] = $filenameWithoutExt;
                }
            }

            // After all files have been processed, return a success message
            if (! empty($notFoundFaktur)) {
                $notFoundMessage = 'Faktur No : ' . implode(', ', $notFoundFaktur) . ' Tidak Ditemukan Atau Sudah Terkirim';
                return redirect()->route('penagihan.faktur')->with('error', $notFoundMessage);
            }

            return redirect()->route('penagihan.faktur')->with('success', 'Bukti Faktur uploaded successfully.');

        }

        return redirect()->route('penagihan.faktur')->with('error', 'Tidak Ada File Yang Di Upload');
    }

}
