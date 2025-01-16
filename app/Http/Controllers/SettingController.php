<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
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
        $setting        = new Setting();
        $setting->key   = $request->key;
        $setting->value = $request->value;
        $setting->save();
        return redirect()->route('settings.index')->with('success', 'Success Create Setting');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }
    public function statusChatbot()
    {
        $setting = Setting::where('key', 'status_connection_app')->first();

        // Check if the setting exists
        if (! $setting) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'Setting not found',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'status'     => $setting->value,
            'message'    => 'Status retrieved successfully',
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            // Find the Cabang by ID and delete it
            $setting = Setting::findOrFail($id);
            return view('settings.edit', compact('setting'));
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
        $setting = Setting::findOrFail(decrypt($id));
        $data    = $request->all();
        $setting->update($data);

        return redirect()->route('settings.index')->with('success', 'Setting Updated Successfully');
    }
    public function updateStatus(Request $request)
    {
        try {
            $setting = Setting::where('key', 'status_connection_app')->first();
            $data    = $request->all();
            $setting->update($data);

            return response()->json([
                'statusCode' => 200,
                'Message'    => 'Success Update Status Chatbot Connection',
            ]);
        } catch (\Exception $e) {
            $setting = Setting::where('key', 'status_connection_app')->first();
            $data    = $request->all();
            $setting->update($data);

            return response()->json([
                'statusCode' => 500,
                'Message'    => $e,
            ]);

        }
    }
    public function updateQr(Request $request, $id)
    {
        try {
            $setting = Setting::where('key', 'qrcode')->first();
            $data    = $request->all();
            $setting->update($data);

            return response()->json([
                'statusCode' => 200,
                'Message'    => 'Success Update Qr Chatbot',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'Message'    => $e,
            ]);

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
            $setting = Setting::findOrFail($id);
            $setting->delete();

            return redirect()->route('settings.index')->with('success', 'Setting deleted successfully!');
        } catch (\Exception $e) {
            // Handle decryption or deletion failure
            return redirect()->route('settings.index')->with('error', 'Invalid or corrupted ID!');
        }

    }
}
