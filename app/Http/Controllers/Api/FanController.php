<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fan;

use Illuminate\Http\Request;
use Validator;
use Storage;

class FanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fan = Fan::with('klub')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'daftar fans',
            'data' => $fan,
        ], 200);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_fan' => 'required',
            'klub' => 'required|array',
        ]);

        if ($validate->fails()) {
             return response()->json([
                'success' => 'false',
                'message' => 'Validasi Gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $fan = new Fan();
            $fan->nama_fan = $request->nama_fan;
            $fan->save();
            // lampirkan banyak klub
            $fan->klub()->attach($request->klub);

            return response()->json([
                'success' => true,
                'message' => 'data berhasil di buat',
                'data' => $fan,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_fan' => 'required',
            'klub' => 'required|array',
        ]);

        if ($validate->fails()) {
             return response()->json([
                'success' => 'false',
                'message' => 'Validasi Gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $fan = Fan::findOrFail($id);
            $fan->nama_fan = $request->nama_fan;
            $fan->save();
            // lampirkan banyak klub
            $fan->klub()->sync($request->klub);

            return response()->json([
                'success' => true,
                'message' => 'data berhasil di rubah',
                'data' => $fan,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
    }
    }


    public function destroy(string $id)
    {
        try {
            $fan = Fan::findOrFail($id);
            $fan->klub()->detach();
            $fan->delete();
            // lampirkan banyak klub

            return response()->json([
                'success' => true,
                'message' => 'data berhasil di hapus',
                'data' => $fan,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
    }
    }
}
