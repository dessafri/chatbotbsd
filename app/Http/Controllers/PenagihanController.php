<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenagihanRequest;
use App\Models\Penagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    /**
     * Display the specified resource.
     */
    public function show(Penagihan $penagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            // Find the Cabang by ID and delete it
            $penagihan = Penagihan::findOrFail($id);
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
        $data = $request->all();

        if (isset($data['nilai_faktur'])) {
            $data['nilai_faktur'] = cleanCurrency($data['nilai_faktur']);
        }

        if (isset($data['piutang'])) {
            $data['piutang'] = cleanCurrency($data['piutang']);
        }

        if (isset($data['pembayaran'])) {
            $data['pembayaran'] = cleanCurrency($data['pembayaran']);
        }

        if ($request->hasFile('bukti_faktur')) {
            // Get the uploaded file
            $img = request()->file('bukti_faktur');
            $img_ext = $img->getClientOriginalExtension();
            $encryptedContent = file_get_contents($img->getRealPath());
            $encryptedContent = encrypt($encryptedContent);
            $img_name_new = uniqid() . Str::random(60) . rand(12345678999999, 9999999998888) . uniqid() . "." . $img_ext;
            $dest_path = public_path('bukti_faktur');
            $img->move($dest_path, $img_name_new);

            // Store the image path in the database
            $data['bukti_faktur'] = $img_name_new;

        }

        $penagihan->update($data);

        return redirect()->route('penagihan.index')->with('success', 'Faktur updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penagihan $penagihan)
    {
        //
    }
}
