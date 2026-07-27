<?php

namespace App\Http\Controllers;

use App\Models\CampAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.report_view');
    }//index

    public function salesDetailReport()
    {
        $user_id = Auth::id();

        $user_camps = CampAccess::where('user_id', $user_id)->get();

        return view('reports.sales_detail_view', compact('user_camps'));
    }//sales detail view
}//class
