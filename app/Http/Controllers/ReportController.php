<?php

namespace App\Http\Controllers;

use App\Constants\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Jalalian::fromFormat('Y/m/d',$request->startDate)->toCarbon()->format('Y/m/d');
        $endDate = Jalalian::fromFormat('Y/m/d',$request->endDate)->toCarbon()->format('Y/m/d');
        $unpaidPayments = Payment::latest()->where('status',PaymentStatus::UNPAID)->whereBetween('created_at',[$startDate,$endDate])->get();
        $paidPayments = Payment::latest()->where('status',PaymentStatus::PAID)->whereBetween('created_at',[$startDate,$endDate])->get();
        $penndingPayments = Payment::latest()->where('status',PaymentStatus::PENDING)->whereBetween('created_at',[$startDate,$endDate])->get();
        return view('admin.pages.report.search-result',[
            'unpaidPayments' => $unpaidPayments,
            'paidPayments' => $paidPayments,
            'penndingPayments' => $penndingPayments,
        ]);
    }
}
