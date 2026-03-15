<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'Active')->count();
        $inactiveEmployees = Employee::where('status', 'Inactive')->count();

        $totalDonations = Donation::count();
        $completedDonations = Donation::where('status', 'Completed')->count();
        $pendingDonations = Donation::where('status', 'Pending')->count();
        $totalDonationAmount = Donation::sum('amount');

        $recentEmployees = Employee::latest()->take(10)->get();
        $recentDonations = Donation::with('employee')->latest()->take(10)->get();

        return view('dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'totalDonations',
            'completedDonations',
            'pendingDonations',
            'totalDonationAmount',
            'recentEmployees',
            'recentDonations'
        ));
    }
}
