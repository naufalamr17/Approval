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

        // Count flight data for each branch in the last 12 months
        $currentDate = now(); // Current date
        $last12MonthsDate = $currentDate->subMonths(12); // Date 12 months ago

        // Assuming 'flights' table with 'branch_name' and 'flight_date' columns
        $flightsPerMonth = DB::table('ticket_requests')
            ->select(
                DB::raw('DATE_FORMAT(flight_date, "%Y-%m") as month'), // Format date to YYYY-MM
                DB::raw('COUNT(*) as total_flights') // Count flights
            )
            ->where('flight_date', '>=', $last12MonthsDate) // Filter flights from the last 12 months
            ->groupBy(DB::raw('DATE_FORMAT(flight_date, "%Y-%m")')) // Group by month
            ->orderBy(DB::raw('DATE_FORMAT(flight_date, "%Y-%m")')) // Order by month
            ->get();

        $totalFlights = $flightsPerMonth->sum('total_flights');

        // Count flights per month based on each type
        $flightsPerMonthByType = DB::table('ticket_requests')
            ->select(
                DB::raw('DATE_FORMAT(flight_date, "%Y-%m") as month'), // Format date to YYYY-MM
                'jenis', // Flight type
                DB::raw('COUNT(*) as total_flights') // Count flights
            )
            ->where('flight_date', '>=', $last12MonthsDate) // Filter flights from the last 12 months
            ->groupBy(DB::raw('DATE_FORMAT(flight_date, "%Y-%m")'), 'jenis') // Group by month and type
            ->orderBy(DB::raw('DATE_FORMAT(flight_date, "%Y-%m")')) // Order by month
            ->get();

        $totalFlightsByType = $flightsPerMonthByType->groupBy('jenis')->map(function ($group) {
            return $group->sum('total_flights');
        });

        // dd($totalFlights);
        return view('dashboard', compact('employee', 'employeeCountsByBranch', 'allEmployees', 'flightsPerMonth', 'totalFlights', 'flightsPerMonthByType', 'totalFlightsByType'));
    }
}
