<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('poh', function ($row) {
                    return empty($row->poh) ? '-' : $row->poh;
                })
                ->make(true);
        }

        $organizations = Employee::select('organization')
            ->distinct()
            ->pluck('organization')
            ->sort()
            ->values();

        return view('employee', compact('organizations'));
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
        // Validasi input
        $validatedData = $request->validate([
            'nik.*' => 'required|string',
            'nama.*' => 'required|string',
            'organization.*' => 'required|string',
            'job_position.*' => 'required|string',
            'job_level.*' => 'required|string',
            'branch_name.*' => 'required|string',
            'poh.*' => 'nullable|string',
        ]);

        // dd($validatedData);

        // Loop melalui data dan simpan ke database
        for ($i = 0; $i < count($validatedData['nik']); $i++) {
            Employee::create([
                'nik' => $validatedData['nik'][$i],
                'nama' => $validatedData['nama'][$i],
                'organization' => $validatedData['organization'][$i],
                'job_position' => $validatedData['job_position'][$i],
                'job_level' => $validatedData['job_level'][$i],
                'branch_name' => $validatedData['branch_name'][$i],
                'poh' => $validatedData['poh'][$i] ?? null,
            ]);
        }

        return redirect()->route('employees')->with('success', 'Employee data have been successfully saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
