<?php

namespace App\Http\Controllers;

use App\Models\BusinessTrip;
use App\Models\Employee;
use App\Models\SuratTugas;
use App\Models\TicketRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isNull;

Carbon::setLocale('id');

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
                    $viewBtn = '<a href="' . route('view-surat-tugas', $row->id) . '" class="btn btn-info btn-sm mt-3"><i class="fas fa-eye"></i></a>';
                    $printBtn = '<a href="' . route('print-surat-tugas', $row->id) . '" class="btn btn-secondary btn-sm mt-3"><i class="fas fa-print"></i></a>';

                    // Cek jika status diawali dengan kata 'Approved'
                    $isApproved = str_starts_with($row->status, 'Approved') || str_starts_with($row->status, 'Rejected');

                    if ($isApproved) {
                        // Jika sudah approved, tampilkan status sebagai teks
                        $approveBtn = '<a href="' . route('approve-surat-tugas', $row->id) . '" class="btn btn-success btn-sm mt-3 disabled"><i class="fas fa-check"></i></a>';
                        $rejectBtn = '<a href="' . route('reject-surat-tugas', $row->id) . '" class="btn btn-warning btn-sm mt-3 disabled"><i class="fas fa-times"></i></a>';
                    } else {
                        // Jika belum approved, tampilkan tombol-tombol aksi
                        $approveBtn = '<a href="' . route('approve-surat-tugas', $row->id) . '" class="btn btn-success btn-sm mt-3"><i class="fas fa-check"></i></a>';
                        $rejectBtn = '<a href="' . route('reject-surat-tugas', $row->id) . '" class="btn btn-warning btn-sm mt-3"><i class="fas fa-times"></i></a>';
                    }

                    $editBtn = '<a href="' . route('edit-surat-tugas', $row->id) . '" class="btn btn-primary btn-sm mt-3"><i class="fas fa-pencil-alt"></i></a>';
                    $deleteBtn = '
                                <form action="' . route('delete-surat-tugas', $row->id) . '" method="POST" style="display: inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm mt-3" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            ';

                    return $viewBtn . ' ' . $printBtn . ' ' . $approveBtn . ' ' . $rejectBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->addColumn('status', function ($row) {
                    if (strpos($row->status, ' at ') !== false) {
                        list($statusText, $timestamp) = explode(' at ', $row->status, 2);
                        return $statusText . '<br> <p class="text-secondary text-sm mb-0">' . $timestamp . '</p>';
                    }
                    return $row->status;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $employee = Employee::get();

        return view('tugas', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employee = Employee::get();

        return view('create-letter', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name.*' => 'required|string|max:255',
            'nik.*' => 'required|string|max:255',
            'position.*' => 'required|string|max:255',
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

        // Handle multiple NIK and names
        $names = $validatedData['name'];
        $niks = $validatedData['nik'];
        $positions = $validatedData['position'];
        $niksAndNames = [];
        foreach ($names as $index => $name) {
            $nik = $niks[$index];
            $position = $positions[$index];

            // Membuat leave request baru
            $leaveRequest = SuratTugas::create([
                'no' => $formattedNo,
                'name' => $name,
                'nik' => $nik,
                'position' => $position,
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'destination_place' => $validatedData['destination_place'],
                'activity_purpose' => $validatedData['activity_purpose'],
                'region' => $region, // Pastikan kolom region tersedia
            ]);

            $niksAndNames[] = ['nik' => $nik, 'name' => $name];
        }

        if ($request->submit_button == 'next_to_fpd') {
            // Simpan data ke dalam session
            session([
                'niks' => array_column($niksAndNames, 'nik'),
                'names' => array_column($niksAndNames, 'name'),
                'no_stpd' => $formattedNo,
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'activity_purpose' => $validatedData['activity_purpose']
            ]);
            return redirect()->route('form-perjalanan-dinas')->with('success', 'STPD successfully submitted. Proceed to Form Perjalanan Dinas.');
        } else {
            return redirect()->route('surat-tugas')->with('success', 'STPD successfully submitted.');
        }
    }

    public function formPerjalananDinas()
    {
        // Mengambil data dari session
        $niks = session('niks', []);
        $names = session('names', []);
        $no_surat = session('no_stpd', '');
        $start_date = session('start_date', '');
        $end_date = session('end_date', '');
        $activity_purpose = session('activity_purpose', '');

        $employees = Employee::whereIn('nik', $niks)->pluck('job_level')->toArray();

        // dd($niks);

        // Mengembalikan view dengan data dari session
        return view('form-perjalanan-dinas', compact('niks', 'names', 'no_surat', 'start_date', 'end_date', 'activity_purpose', 'employees'));
    }

    public function storeFPD(Request $request)
    {
        // dd($request);
        try {
            // Get the current time in Asia/Jakarta timezone
            $createdAt = Carbon::now('Asia/Jakarta');
            $createdAtWIB = $createdAt->format('d-m-Y H:i:s');

            // Simpan data perjalanan dinas
            foreach ($request['names'] as $index => $name) {
                $newNoSurat = str_replace('STPD', 'FPD', $request->no_surat);

                // Create BusinessTrip entry
                BusinessTrip::create([
                    'name' => $name,
                    'nik' => $request['niks'][$index],
                    'no_surat' => $request->no_surat,
                    'no' => $newNoSurat,
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'transportation' => json_encode($request->input('transportation.' . $index, [])),
                    'accommodation' => json_encode($request->input('accommodation.' . $index, [])),
                    'allowance' => json_encode($request->input('allowance.' . $index, [])),
                    'cash_advance_amount' => $request->input('cash_advance_amount.' . $index, 0),
                    'total_amount' => $request['total_amounts'][$index],
                ]);

                // Jika transportasi adalah Plane dan flight_date tidak null, simpan data penerbangan
                if (
                    in_array('Plane', $request->input('transportation.' . $index, [])) &&
                    !is_null($request['flight_date'][$index])
                ) {
                    // dd('halo');
                    $flightRequest = new TicketRequest([
                        'jenis_tiket' => $request['jenis_tiket'],
                        'nik' => $request['niks'][$index],
                        'poh' => $request['poh'][$index],
                        'jenis' => $request['jenis'][$index],
                        'start_date' => $request['start_date'],
                        'end_date' => $request['end_date'],
                        'flight_date' => $request['flight_date'][$index],
                        'route' => $request['route'][$index],
                        'destination' => $request['destination'][$index] ?? null,
                        'departure_airline' => $request['departure_airline'][$index],
                        'flight_time' => $request['flight_time'][$index],
                        'flight_time_end' => $request['flight_time_end'][$index],
                        'status' => $request['status'][$index],
                        'price' => $request['price'][$index],
                        'remarks' => $request['remarks'][$index] ?? '-', // Default value for remarks if not present
                        'creator' => Auth::user()->name,
                        'status_approval' => 'Waiting',
                        'created_at' => $createdAtWIB,
                    ]);

                    // Handle file upload if present
                    if (isset($request['ticket_screenshot'][$index])) {
                        $path = $request['ticket_screenshot'][$index]->store('ticket_screenshots', 'public');
                        $flightRequest->ticket_screenshot = $path;
                    }

                    // Save the TicketRequest instance
                    $flightRequest->save();
                }
            }

            // Redirect atau tampilkan pesan sukses
            return redirect()->route('surat-tugas')->with('success', 'FPD successfully submitted.');
        } catch (Exception $e) {
            // Handle the exception and display an error message
            dd($e->getMessage());
            return back()->withErrors(['error' => 'There was an error processing your request: ' . $e->getMessage()]);
        }
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
    public function show($id)
    {
        // Find the SuratTugas record by ID
        $suratTugas = SuratTugas::findOrFail($id);

        $employee = Employee::all();

        return view('view-tugas', compact('suratTugas', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);
        $employee = Employee::all(); // Pastikan untuk mendapatkan data karyawan dari model Employee
        return view('view-tugas', compact('suratTugas', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'nik' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'destination_place' => 'required|string|max:255',
            'activity_purpose' => 'required|string|max:1000',
        ]);

        // Find the SuratTugas record by ID and update it
        $suratTugas = SuratTugas::findOrFail($id);
        $suratTugas->update($request->all());

        // Redirect back with success message
        return redirect()->route('surat-tugas')->with('success', 'Assignment Letter updated successfully.');
    }

    public function approve($id)
    {
        // Temukan SuratTugas berdasarkan ID
        $suratTugas = SuratTugas::findOrFail($id);

        // Atur timezone ke Asia/Jakarta untuk mendapatkan waktu WIB
        $now = Carbon::now()->timezone('Asia/Jakarta');

        // Perbarui status menjadi 'Approved' dan simpan ID user yang mengesahkan
        $suratTugas->status = 'Approved by ' . auth()->user()->name . ' at ' . $now->format('Y-m-d H:i:s') . ' WIB';
        $suratTugas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('surat-tugas')->with('success', 'Assignment Letter approved successfully.');
    }

    public function reject($id)
    {
        // Temukan SuratTugas berdasarkan ID
        $suratTugas = SuratTugas::findOrFail($id);

        // Atur timezone ke Asia/Jakarta untuk mendapatkan waktu WIB
        $now = Carbon::now()->timezone('Asia/Jakarta');

        // Perbarui status menjadi 'Rejected' dan simpan ID user yang menolak
        $suratTugas->status = 'Rejected by ' . auth()->user()->name . ' at ' . $now->format('Y-m-d H:i:s') . ' WIB';
        $suratTugas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('surat-tugas')->with('success', 'Assignment Letter rejected successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the SuratTugas record by ID and delete it
        $suratTugas = SuratTugas::findOrFail($id);
        $suratTugas->delete();

        // Redirect back with a success message
        return redirect()->route('surat-tugas')->with('success', 'Assignment Letter deleted successfully.');
    }

    public function print($id)
    {
        // Retrieve leave request data based on $id
        $leaveRequest = SuratTugas::find($id);

        Carbon::setLocale('id');

        // Check if leave request exists
        if (!$leaveRequest) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Load your template Word document
        $templatePath = public_path('SuratTugasPerjalananDinas.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Path to the image
        $imagePath = public_path('mlp.jpeg');

        // Replace placeholders in the template with actual data
        $templateProcessor->setValue('No', $leaveRequest->no);
        $templateProcessor->setValue('Name', $leaveRequest->name);
        $templateProcessor->setValue('NIK', $leaveRequest->nik);
        $templateProcessor->setValue('Position', $leaveRequest->position);
        $startDate = Carbon::parse($leaveRequest->start_date)->translatedFormat('d F Y');
        $endDate = Carbon::parse($leaveRequest->end_date)->translatedFormat('d F Y');
        $templateProcessor->setValue('Start', $startDate);
        $templateProcessor->setValue('End', $endDate);
        $templateProcessor->setValue('Destination', htmlspecialchars($leaveRequest->destination_place));
        $templateProcessor->setValue('Purpose', htmlspecialchars($leaveRequest->activity_purpose));
        $templateProcessor->setValue('Region', $leaveRequest->region);

        if ($leaveRequest->status == 'Waiting Approval') {
            $templateProcessor->setValue('Sign', "");
            $templateProcessor->setValue('Date', "");
        } else {
            $templateProcessor->setImageValue('Sign', array('path' => $imagePath, 'width' => 70, 'height' => 70, 'ratio' => true));

            $status = $leaveRequest->status;
            $timestamp = substr($status, strpos($status, ' at ') + 4, 19);
            $date = Carbon::parse($timestamp);
            $formattedDate = $date->translatedFormat('d F Y');
            $templateProcessor->setValue('Date', $formattedDate);
        }

        $templateProcessor->setValue('Year', Carbon::now()->year);

        // Generate a filename for the output Word document
        $outputFileName = 'Surat Tugas ' . $leaveRequest->name . '.docx';
        $outputFilePath = public_path($outputFileName);
        $templateProcessor->saveAs($outputFilePath);

        // Return a response with the generated Word document for download
        return response()->download($outputFilePath, $outputFileName)->deleteFileAfterSend(true);
    }
}
