<?php

namespace App\Http\Controllers;

use App\Models\BusinessTrip;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BusinessTripController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BusinessTrip::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $viewBtn = '<a href="' . route('view-fpd', $row->id) . '" class="btn btn-info btn-sm mt-3"><i class="fas fa-eye"></i></a>';
                    $printBtn = '<a href="' . route('print-surat-tugas', $row->id) . '" class="btn btn-secondary btn-sm mt-3"><i class="fas fa-print"></i></a>';

                    // Cek jika status diawali dengan kata 'Approved'
                    $isApproved = str_starts_with($row->status, 'Approved') || str_starts_with($row->status, 'Rejected');

                    if ($isApproved) {
                        // Jika sudah approved, tampilkan status sebagai teks
                        $approveBtn = '<a href="' . route('approve-surat-tugas', $row->id) . '" class="btn btn-success btn-sm mt-3 disabled"><i class="fas fa-check"></i></a>';
                        $rejectBtn = '<a href="' . route('reject-surat-tugas', $row->id) . '" class="btn btn-warning btn-sm mt-3 disabled"><i class="fas fa-times"></i></a>';
                    } else {
                        // Jika belum approved, tampilkan tombol-tombol aksi
                        $approveBtn = '<a href="' . route('approve-fpd', $row->id) . '" class="btn btn-success btn-sm mt-3"><i class="fas fa-check"></i></a>';
                        $rejectBtn = '<a href="' . route('reject-fpd', $row->id) . '" class="btn btn-warning btn-sm mt-3"><i class="fas fa-times"></i></a>';
                    }

                    // $editBtn = '<a href="' . route('edit-surat-tugas', $row->id) . '" class="btn btn-primary btn-sm mt-3"><i class="fas fa-pencil-alt"></i></a>';
                    $deleteBtn = '
                                <form action="' . route('delete-fpd', $row->id) . '" method="POST" style="display: inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm mt-3" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            ';

                    // return $viewBtn . ' ' . $printBtn . ' ' . $approveBtn . ' ' . $rejectBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                    return $printBtn . ' ' . $approveBtn . ' ' . $rejectBtn . ' ' . $deleteBtn;
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

        return view('fpd');
    }

    public function approve($id)
    {
        // Temukan SuratTugas berdasarkan ID
        $suratTugas = BusinessTrip::findOrFail($id);

        // Atur timezone ke Asia/Jakarta untuk mendapatkan waktu WIB
        $now = Carbon::now()->timezone('Asia/Jakarta');

        // Perbarui status menjadi 'Approved' dan simpan ID user yang mengesahkan
        $suratTugas->status = 'Approved by ' . auth()->user()->name . ' at ' . $now->format('Y-m-d H:i:s') . ' WIB';
        $suratTugas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('perjalanan-dinas')->with('success', 'Form Perjalanan Dinas approved successfully.');
    }

    public function reject($id)
    {
        // Temukan SuratTugas berdasarkan ID
        $suratTugas = BusinessTrip::findOrFail($id);

        // Atur timezone ke Asia/Jakarta untuk mendapatkan waktu WIB
        $now = Carbon::now()->timezone('Asia/Jakarta');

        // Perbarui status menjadi 'Rejected' dan simpan ID user yang menolak
        $suratTugas->status = 'Rejected by ' . auth()->user()->name . ' at ' . $now->format('Y-m-d H:i:s') . ' WIB';
        $suratTugas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('perjalanan-dinas')->with('success', 'Form Perjalanan Dinas rejected successfully.');
    }

    public function destroy($id)
    {
        // Find the SuratTugas record by ID and delete it
        $suratTugas = BusinessTrip::findOrFail($id);
        $suratTugas->delete();

        // Redirect back with a success message
        return redirect()->route('perjalanan-dinas')->with('success', 'Form Perjalanan Dinas deleted successfully.');
    }

    public function show($id)
    {
        // Find the SuratTugas record by ID
        $formPerdin = BusinessTrip::findOrFail($id);

        // dd($formPerdin);

        return view('view-fpd', compact('formPerdin'));
    }
}
