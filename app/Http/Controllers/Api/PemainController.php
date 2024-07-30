<?php

namespace App\Http\Controllers\Api;
use App\Models\Pemain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class PemainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemain = Pemain::latest()->get();
            return response()->json([
                'success' =>true,
                'message' => 'Daftar Pemain',
                'data' => $pemain,
            ], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_pemain' => 'required',
            'foto' => 'nullable|image|mimes:png,jpg',
            'tgl_lahir' => 'required',
            'harga_pasar' => 'required|numeric',
            'posisi' => 'required|in:gk,df, mf, fw',
            'negara' => 'required',
            'id_klub' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // upload image
            $path = $request->file('foto')->store('public/foto');
            $pemain = new Pemain;
            $pemain->nama_pemain = $request->nama_pemain;
            $pemain->foto = $path;
            $pemain->tgl_lahir = $request->tgl_lahir;
            $pemain->harga_pasar = $request->harga_pasar;
            $pemain->posisi = $request->posisi;
            $pemain->negara = $request->negara;
            $pemain->id_klub = $request->id_klub;
            $pemain->save();
            return response()->json([
                'success' => true,
                'message' => 'data berhasil dibuat',
                'data' => $pemain,
            ], 201);
        } catch (\Exception $e){
            return response()->json([
                'succes' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pemain = Pemain::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail Pemain',
                'data' => $pemain,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ada',
                'errors' => $e->getMessage(),
            ], 404);
}
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
        $validator = Validator::make($request->all(),[
            'nama_pemain' => 'required',
            'foto' => 'nullable|image|mimes:png,jpg',
            'tgl_lahir' => 'required',
            'harga_pasar' => 'required|numeric',
            'posisi' => 'required|in:gk,df, mf, fw',
            'negara' => 'required',
            'id_klub' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // upload image
            $path = $request->file('foto')->store('public/foto');
            $pemain = Pemain::finOrfail($id);
            $pemain->nama_pemain = $request->nama_pemain;
            $pemain->foto = $path;
            $pemain->tgl_lahir = $request->tgl_lahir;
            $pemain->harga_pasar = $request->harga_pasar;
            $pemain->posisi = $request->posisi;
            $pemain->negara = $request->negara;
            $pemain->id_klub = $request->id_klub;
            $pemain->save();
            return response()->json([
                'success' => true,
                'message' => 'data berhasil dibuat',
                'data' => $pemain,
            ], 201);
        } catch (\Exception $e){
            return response()->json([
                'succes' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $pemain = Pemain::findOrFail($id);
            Storage::delete($pemain->logo);
            $pemain->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data '. $pemain->nama_pemain . 'berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ada',
                'errors' => $e->getMessage(),
            ], 404);
}
    }
}
