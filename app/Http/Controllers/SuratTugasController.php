<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratTugas::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tugas');
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
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'destination_place' => 'required|string|max:255',
            'activity_purpose' => 'required|string',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Mendapatkan tahun, bulan, dan region
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $region = 'jakarta'; // Sesuaikan dengan input atau logic region

        // Mendapatkan nomor terakhir untuk tahun dan region saat ini
        $lastLeaveRequest = SuratTugas::whereYear('created_at', $currentYear)
            ->where('region', $region) // Pastikan Anda memiliki kolom 'region' di tabel LeaveRequest
            ->latest('id')
            ->first();

        // Mengenerate nomor baru
        $lastNumber = $lastLeaveRequest ? intval(substr($lastLeaveRequest->no, 0, 3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $monthRoman = $this->getRomanMonth($currentMonth);
        $regionCode = $this->getRegionCode($region);

        // Format nomor surat
        $formattedNo = "$newNumber/$regionCode/$monthRoman/$currentYear";

        // Membuat leave request baru
        $leaveRequest = SuratTugas::create([
            'no' => $formattedNo,
            'name' => $validatedData['name'],
            'nik' => $validatedData['nik'],
            'position' => $validatedData['position'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'destination_place' => $validatedData['destination_place'],
            'activity_purpose' => $validatedData['activity_purpose'],
            'region' => $region, // Pastikan kolom region tersedia
        ]);

        $leaveRequestId = $leaveRequest->id;
        // $routing = route('detail-tugas', ['id' => $leaveRequestId]);

        // Reset form fields
        // $this->reset(); // Not needed in controller

        // Redirect to a specific route
        return redirect()->route('surat-tugas')->with('success', 'Leave request successfully submitted.');
    }

    private function getRomanMonth($month)
    {
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $romanMonths[$month];
    }

    private function getRegionCode($region)
    {
        $regionCodes = [
            'jakarta' => 'MLP.STPD-J',
            'kendari' => 'MLP.STPD-KDI',
            'molore' => 'MLP.STPD-SITE'
        ];

        return $regionCodes[$region] ?? 'UNKNOWN';
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratTugas $suratTugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratTugas $suratTugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratTugas $suratTugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratTugas $suratTugas)
    {
        //
    }
}
