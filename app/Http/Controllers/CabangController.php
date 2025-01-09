<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabangs = Cabang::all();
        return view('cabang.cabang', compact('cabangs'));
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
    public function store(Request $request)
    {

        try {
            $data = Cabang::create([
                'kode_cabang' => $request['kode_cabang'],
                'nama_cabang' => $request['nama_cabang'],
                'nama_rekening' => $request['nama_rekening'],
                'nomor_rekening' => $request['nomor_rekening'],
            ]);

            // Check if data was successfully created and redirect accordingly
            if ($data) {
                return redirect()->route('cabang.index')->with('success', 'Data saved successfully!');
            } else {
                return redirect()->route('cabang.index')->with('error', 'Failed to save data.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle the validation error
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
            $cabang = Cabang::findOrFail($id);
            return view('cabang.edit', compact('cabang'));
        } catch (\Exception $e) {
            // Handle decryption or deletion failure
            return redirect()->route('cabang.index')->with('error', 'Invalid or corrupted ID!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $id = decrypt($id);

            // Find the Cabang by ID
            $cabang = Cabang::findOrFail($id);

            // Update the Cabang model directly with request data
            $cabang->kode_cabang = $request->input('kode_cabang');
            $cabang->nama_cabang = $request->input('nama_cabang');
            $cabang->nama_rekening = $request->input('nama_rekening');
            $cabang->nomor_rekening = $request->input('nomor_rekening');

            // Save the updated data
            $cabang->save();

            // Redirect to the index with a success message
            return redirect()->route('cabang.index')->with('success', 'Cabang updated successfully!');
        } catch (\Exception $e) {
            // Handle errors (e.g., decryption, model not found)
            return redirect()->route('cabang.index')->with('error', 'Invalid or corrupted ID!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        // Decrypt the ID
        try {
            $id = decrypt($encryptedId);
            // Find the Cabang by ID and delete it
            $cabang = Cabang::findOrFail($id);
            $cabang->delete();

            return redirect()->route('cabang.index')->with('success', 'Cabang deleted successfully!');
        } catch (\Exception $e) {
            // Handle decryption or deletion failure
            return redirect()->route('cabang.index')->with('error', 'Invalid or corrupted ID!');
        }

    }
}
