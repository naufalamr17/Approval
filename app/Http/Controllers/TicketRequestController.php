<?php

namespace App\Http\Controllers;

use App\Models\TicketRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                    $approveBtn = '<a href="' . route('approve-surat-tugas', $row->id) . '" class="btn btn-success btn-sm mt-3""><i class="fas fa-check"></i></a>';
                    $rejectBtn = '<a href="' . route('reject-surat-tugas', $row->id) . '" class="btn btn-warning btn-sm mt-3""><i class="fas fa-times"></i></a>';
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
                ->addColumn('status', function ($row) {
                    if (strpos($row->status, ' at ') !== false) {
                        list($statusText, $timestamp) = explode(' at ', $row->status, 2);
                        return $statusText . '<br> <p class="text-secondary text-sm mb-0">' . $timestamp . '</p>';
                    }
                    return $row->status;
                })
                ->rawColumns(['action', 'ticket_screenshot', 'status'])
                ->make(true);
        }

        return view('ticket-request');
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
        try {
            $validatedData = $request->validate([
                'nik.*' => 'required|string|max:255',
                'poh.*' => 'required|string|max:255',
                'jenis.*' => 'required|string|max:255',
                'start_date.*' => 'required|date',
                'end_date.*' => 'required|date',
                'flight_date.*' => 'required|date',
                'route.*' => 'required|string|max:255',
                'departure_airline.*' => 'required|string|max:255',
                'flight_time.*' => 'required|date_format:H:i',
                'status.*' => 'required|string|max:255',
                'price.*' => 'required|numeric',
                'remarks.*' => 'nullable|string',
                'ticket_screenshot.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Mengambil waktu sekarang dalam zona waktu Asia/Jakarta
            $createdAt = Carbon::now('Asia/Jakarta');

            // Memformat ulang menjadi string dengan format yang diinginkan (misal: d-m-Y H:i:s)
            $createdAtWIB = $createdAt->format('d-m-Y H:i:s');

            foreach ($validatedData['nik'] as $key => $nik) {
                $flightRequest = new TicketRequest([
                    'nik' => $validatedData['nik'][$key],
                    'poh' => $validatedData['poh'][$key],
                    'jenis' => $validatedData['jenis'][$key],
                    'start_date' => $validatedData['start_date'][$key],
                    'end_date' => $validatedData['end_date'][$key],
                    'flight_date' => $validatedData['flight_date'][$key],
                    'route' => $validatedData['route'][$key],
                    'departure_airline' => $validatedData['departure_airline'][$key],
                    'flight_time' => $validatedData['flight_time'][$key],
                    'status' => $validatedData['status'][$key],
                    'price' => $validatedData['price'][$key],
                    'remarks' => $validatedData['remarks'][$key],
                    'creator' => Auth::user()->name,
                    'status_approval' => 'Waiting',
                    'created_at' => $createdAtWIB,
                ]);

                if (isset($validatedData['ticket_screenshot'][$key])) {
                    $path = $validatedData['ticket_screenshot'][$key]->store('ticket_screenshots', 'public');
                    $flightRequest->ticket_screenshot = $path;
                }

                $flightRequest->save();
            }

            return redirect()->route('ticket-request')->with('success', 'Ticket requests have been successfully created.');
        } catch (ValidationException $e) {
            $error = $e->errors();
            $firstErrorKey = array_key_first($error);
            $firstErrorMessage = $error[$firstErrorKey];

            return redirect()->route('ticket-request')->with('error', 'Error : ' . $firstErrorMessage[0]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error($e);
            return redirect()->route('ticket-request')->with('error', 'An error occurred while processing your request. Please try again later.');
        }
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
    public function edit(TicketRequest $ticketRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketRequest $ticketRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketRequest $ticketRequest)
    {
        //
    }
}
