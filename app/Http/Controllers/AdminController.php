<?php

namespace App\Http\Controllers;

use App\Constants\PaymentStatus;
use App\Constants\PaymentType;
use App\Constants\SaleType;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UserInfoRequest;
use App\Models\Customer;
use App\Models\InsuranceType;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(Request $request): Factory|View|Application
    {
        $payments = Payment::query()->where(function ($query) {
            return $query->where('created_at', '<', now()->format('Y/m/d'))->where('status', 'unpaid');
        });
        return view('admin.dashboard', [
            'customersCount' => Customer::filter($request->all())->count(),
            'insurancesCount' => Sale::filter($request->all())->count(),
            'saleAmount' => Sale::filter($request->all())->sum('price'),
            'cashSaleAmount' => Sale::filter($request->all())->where('pay_type',SaleType::CASH)->sum('price'),
            'installmentSaleAmount' => Sale::filter($request->all())->where('pay_type',SaleType::INSTALLMENT)->sum('price'),
            'paidInstallment' => Payment::filter($request->all())->where('status',PaymentStatus::PAID)->sum('amount'),
            'lateInstallment' => Payment::filter($request->all())->where('status',PaymentStatus::UNPAID)
                ->where('due_date','<',now())->sum('amount'),
            ]);
    }

    /**
     * @return Factory|View|Application
     */
    public function showProfile(): Factory|View|Application
    {
        return view('admin.pages.profile.index');
    }

    public function udpdateUserInfo(UserInfoRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
        ]);
        return redirect()->back()->with('success', __('messages.success.profile.update'));
    }

    /**
     * @param UpdateUserPasswordRequest $request
     *
     * @return RedirectResponse
     */
    public function updateUserPassword(UpdateUserPasswordRequest $request): RedirectResponse
    {
        auth()->user()->update([
            'password' => $request->getPassword()
        ]);
        return redirect()->back()->with('success', __('messages.success.profile.update'));

    }
}
