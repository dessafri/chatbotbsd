<?php
namespace App\Http\Controllers;

use App\Models\Penagihan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPenagihan      = Penagihan::getTotalNilaiPenagihan();
        $penagihanDeliver    = Penagihan::getCountDeliverPenagihan();
        $penagihanNotDeliver = Penagihan::getCountNotDeliverPenagihan();
        $penagihanCount      = Penagihan::getCountPenagihan();

        // Pass data directly to the view without using session
        return view('dashboard.dashboard', compact('totalPenagihan', 'penagihanDeliver', 'penagihanNotDeliver', 'penagihanCount'));

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
