<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OnboardingUser;
use App\Models\TicketRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class TicketRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TicketRequest::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $approveBtn = '<a href="' . route('approve-ticket-request', $row->id) . '" class="btn btn-success btn-sm mt-3"><i class="fas fa-check"></i></a>';
                    $rejectBtn = '<a href="' . route('reject-ticket-request', $row->id) . '" class="btn btn-warning btn-sm mt-3"><i class="fas fa-times"></i></a>';
                    $editBtn = '<a href="' . route('edit-ticket-request', $row->id) . '" class="btn btn-primary btn-sm mt-3"><i class="fas fa-pencil-alt"></i></a>';
                    $deleteBtn = '
                    <form action="' . route('delete-ticket-request', $row->id) . '" method="POST" style="display: inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm mt-3" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';

                    return $approveBtn . ' ' . $rejectBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->addColumn('ticket_screenshot', function ($row) {
                    if ($row->ticket_screenshot) {
                        $imgUrl = asset('storage/' . $row->ticket_screenshot);
                        return '<div class="text-center">
                                <a href="#" class="btn btn-dark btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="' . $imgUrl . '">
                                    <i class="fas fa-image"></i>
                                </a>
                                <p style="display: none;">' . $imgUrl . '</p>
                            </div>';
                    }
                    return 'No Image';
                })
                ->addColumn('status_approval', function ($row) {
                    if (strpos($row->status_approval, ' at ') !== false) {
                        list($statusText, $timestamp) = explode(' at ', $row->status_approval, 2);
                        return $statusText . '<br> <p class="text-secondary text-sm mb-0">' . $timestamp . '</p>';
                    }
                    return $row->status_approval;
                })
                ->rawColumns(['action', 'ticket_screenshot', 'status_approval'])
                ->make(true);
        }

        $employee = Employee::select('nik', 'nama', 'poh')->get(); // Adjust fields if needed

        return view('ticket-request', compact('employee'));
    }

    public function actual($id)
    {
        $price = TicketRequest::findOrFail($id);

        return view('actual-price', compact('price'));
    }

    public function storeActual(Request $request, $id)
    {
        // Find the TicketRequest by ID or fail if not found
        $price = TicketRequest::findOrFail($id);

        // Debug the incoming request data to ensure 'actual_price' is present
        // dd($request->all()); // You can remove this once you've confirmed the data is correct

        // Update the actual_price field
        $price->actual_price = $request->actual_price;
        $price->save(); // Save the changes

        // Redirect back with a success message
        return redirect()->route('ticket-request')->with('success', 'Actual price updated successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($validatedData);

        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'nik.*' => 'nullable|string|max:255',
                'poh.*' => 'required|string|max:255',
                'jenis.*' => 'required|string|max:255',
                'start_date.*' => 'required|date',
                'end_date.*' => 'required|date',
                'flight_date.*' => 'required|date',
                'route.*' => 'required|string|max:255',
                'destination.*' => 'nullable|string|max:255',
                'departure_airline.*' => 'required|string|max:255',
                'flight_time.*' => 'required|date_format:H:i',
                'flight_time_end.*' => 'required|date_format:H:i',
                'status.*' => 'required|string|max:255',
                'price.*' => 'required|numeric',
                'remarks.*' => 'nullable|string',
                'ticket_screenshot.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'jenis_tiket.*' => 'required|string|max:255',
                'name.*' => 'nullable|string|max:255', // Validate if onboarding
                'job_level.*' => 'nullable|string|max:255', // Validate if onboarding
                'organization.*' => 'nullable|string|max:255' // Validate if onboarding
            ]); 

            // Get the current time in Asia/Jakarta timezone
            $createdAt = Carbon::now('Asia/Jakarta');
            $createdAtWIB = $createdAt->format('d-m-Y H:i:s');

            foreach ($validatedData['poh'] as $key => $poh) {
                // Create a new TicketRequest instance
                $flightRequest = new TicketRequest([
                    'jenis_tiket' => $request->jenis_tiket,
                    'nik' => $validatedData['jenis'][$key] === 'Onboarding' ? '-' : $validatedData['nik'][$key],
                    'poh' => $validatedData['poh'][$key],
                    'jenis' => $validatedData['jenis'][$key],
                    'start_date' => $validatedData['start_date'][$key],
                    'end_date' => $validatedData['end_date'][$key],
                    'flight_date' => $validatedData['flight_date'][$key],
                    'route' => $validatedData['route'][$key],
                    'destination' => $validatedData['destination'][$key] ?? null,
                    'departure_airline' => $validatedData['departure_airline'][$key],
                    'flight_time' => $validatedData['flight_time'][$key],
                    'flight_time_end' => $validatedData['flight_time_end'][$key],
                    'status' => $validatedData['status'][$key],
                    'price' => $validatedData['price'][$key],
                    'remarks' => $validatedData['remarks'][$key],
                    'creator' => Auth::user()->name,
                    'status_approval' => 'Waiting',
                    'created_at' => $createdAtWIB,
                ]);

                // Handle file upload if present
                if (isset($validatedData['ticket_screenshot'][$key])) {
                    $path = $validatedData['ticket_screenshot'][$key]->store('ticket_screenshots', 'public');
                    $flightRequest->ticket_screenshot = $path;
                }

                // Save the TicketRequest instance
                $flightRequest->save();

                // Handle OnboardingUser if applicable
                if ($validatedData['jenis'][$key] === 'Onboarding') {
                    $onboarding = new OnboardingUser([
                        'id_ticket' => $flightRequest->id, // Use the ID from the saved TicketRequest
                        'nama' => $validatedData['name'][$key],
                        'job_level' => $validatedData['job_level'][$key],
                        'organization' => $validatedData['organization'][$key],
                    ]);

                    // Save the OnboardingUser instance
                    $onboarding->save();
                }
            }

            // Redirect with success message
            return redirect()->route('ticket-request')->with('success', 'Ticket requests have been successfully created.');
        } catch (ValidationException $e) {
            // Handle validation exceptions
            $error = $e->errors();
            $firstErrorKey = array_key_first($error);
            $firstErrorMessage = $error[$firstErrorKey];

            return redirect()->route('ticket-request')->with('error', 'Error: ' . $firstErrorMessage[0]);
        } catch (\Exception $e) {
            // Log the exception and redirect with a general error message
            Log::error($e);
            return redirect()->route('ticket-request')->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }


    public function approve($id)
    {
        // Temukan SuratTugas berdasarkan ID
        $suratTugas = TicketRequest::findOrFail($id);

        // Atur timezone ke Asia/Jakarta untuk mendapatkan waktu WIB
        $now = Carbon::now()->timezone('Asia/Jakarta');

        // Perbarui status menjadi 'Approved' dan simpan ID user yang mengesahkan
        $suratTugas->status_approval = 'Approved by ' . auth()->user()->name . ' at ' . $now->format('Y-m-d H:i:s') . ' WIB';
        $suratTugas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('ticket-request')->with('success', 'Ticket Request approved successfully.');
    }

    public function reject($id)
    {
        // Temukan SuratTugas berdasarkan ID
        $suratTugas = TicketRequest::findOrFail($id);

        // Atur timezone ke Asia/Jakarta untuk mendapatkan waktu WIB
        $now = Carbon::now()->timezone('Asia/Jakarta');

        // Perbarui status menjadi 'Rejected' dan simpan ID user yang menolak
        $suratTugas->status_approval = 'Rejected by ' . auth()->user()->name . ' at ' . $now->format('Y-m-d H:i:s') . ' WIB';
        $suratTugas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('ticket-request')->with('success', 'Ticket Request rejected successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketRequest $ticketRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menyediakan data untuk form edit
        $ticketRequest = TicketRequest::findOrFail($id);

        return view('view-ticket', compact('ticketRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi data yang diterima
            $validatedData = $request->validate([
                'nik' => 'required|string|max:255',
                'poh' => 'required|string|max:255',
                'jenis' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'flight_date' => 'required|date',
                'route' => 'required|string|max:255',
                'departure_airline' => 'required|string|max:255',
                'flight_time' => 'required',
                'status' => 'required|string|max:255',
                'price' => 'required|numeric',
                'remarks' => 'nullable|string',
                'ticket_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Mencari data berdasarkan ID
            $ticketRequest = TicketRequest::findOrFail($id);

            // Mengupdate data yang ada
            $ticketRequest->nik = $validatedData['nik'];
            $ticketRequest->poh = $validatedData['poh'];
            $ticketRequest->jenis = $validatedData['jenis'];
            $ticketRequest->start_date = $validatedData['start_date'];
            $ticketRequest->end_date = $validatedData['end_date'];
            $ticketRequest->flight_date = $validatedData['flight_date'];
            $ticketRequest->route = $validatedData['route'];
            $ticketRequest->departure_airline = $validatedData['departure_airline'];
            $ticketRequest->flight_time = $validatedData['flight_time'];
            $ticketRequest->status = $validatedData['status'];
            $ticketRequest->price = $validatedData['price'];
            $ticketRequest->remarks = $validatedData['remarks'];

            // Cek apakah ada file screenshot yang diupload
            if ($request->hasFile('ticket_screenshot')) {
                // Hapus file lama jika ada
                if ($ticketRequest->ticket_screenshot) {
                    Storage::disk('public')->delete($ticketRequest->ticket_screenshot);
                }

                // Simpan file yang baru
                $path = $request->file('ticket_screenshot')->store('ticket_screenshots', 'public');
                $ticketRequest->ticket_screenshot = $path;
            }

            $ticketRequest->save();

            return redirect()->route('ticket-request')->with('success', 'Ticket request has been successfully updated.');
        } catch (ValidationException $e) {
            $error = $e->errors();
            $firstErrorKey = array_key_first($error);
            $firstErrorMessage = $error[$firstErrorKey];

            return redirect()->route('ticket-request')->with('error', 'Error: ' . $firstErrorMessage[0]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error($e);
            return redirect()->route('ticket-request')->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the SuratTugas record by ID and delete it
        $suratTugas = TicketRequest::findOrFail($id);
        $suratTugas->delete();

        // Redirect back with a success message
        return redirect()->route('ticket-request')->with('success', 'Ticket Request deleted successfully.');
    }
}
