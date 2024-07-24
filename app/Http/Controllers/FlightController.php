<?php

namespace App\Http\Controllers;

use App\Models\flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('flight');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, flight $flight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(flight $flight)
    {
        //
    }
}
