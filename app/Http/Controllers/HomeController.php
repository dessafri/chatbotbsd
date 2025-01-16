<?php
namespace App\Http\Controllers;

use App\Models\Penagihan;

class HomeController extends Controller
{
    public function home()
    {
        $totalPenagihan      = Penagihan::getTotalNilaiPenagihan();
        $penagihanDeliver    = Penagihan::getCountDeliverPenagihan();
        $penagihanNotDeliver = Penagihan::getCountNotDeliverPenagihan();
        $penagihanCount      = Penagihan::getCountPenagihan();

        // Pass data directly to the view without using session
        return view('dashboard', compact('totalPenagihan', 'penagihanDeliver', 'penagihanNotDeliver', 'penagihanCount'));
    }

}
