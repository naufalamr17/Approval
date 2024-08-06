<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::count();
        $employeeCountsByBranch = DB::table('employees')
        ->select('branch_name', DB::raw('count(*) as total'))
        ->groupBy('branch_name')
        ->get();
        $allEmployees = Employee::all();

        // dd($employeeCountsByBranch);
        return view('dashboard', compact('employee', 'employeeCountsByBranch', 'allEmployees'));
    }
}
