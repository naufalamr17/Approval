<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        if ($request->jenis == 'PerDin') {
            return redirect('create-surat-tugas');
        } else {
            $jenis = $request->jenis;
            return redirect()->route('create-ticket-req')->with('jenis', $jenis);
        }
    }

    public function ticket()
    {
        $employee = Employee::select('nik', 'nama', 'poh')->get(); // Adjust fields if needed
        $jenis = session('jenis'); // Get 'jenis' from session if it exists

        return view('create-ticket-req', compact('employee', 'jenis'));
    }
}
