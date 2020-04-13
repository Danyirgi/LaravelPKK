<?php

namespace App\Http\Controllers;

use App\Barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["count"] = Barang::count();
        $barang = array();

        foreach (Barang::all() as $p) {
            $item = [
                "id"                => $p->id,
                "nama"              => $p->nama,
                "harga"             => $p->harga,
                "keterangan"    	=> $p->keterangan,
                "created_at"        => $p->created_at,
                "updated_at"        => $p->updated_at
            ];

            array_push($barang, $item);
        }
        $data["barang"] = $barang;
        $data["status"] = 1;
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'nama'            => 'required|string|max:255',
			'harga'           => 'required|string|max:255',
			'keterangan'      => 'required|string|max:255',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> 0,
				'message'	=> $validator->errors()
			]);
		}

		$barang = new barang();
		$barang->nama 	    = $request->nama;
		$barang->harga 	    = $request->harga;
		$barang->keterangan = $request->keterangan;
		$barang->save();

		return response()->json([
			'status'	=> '1',
            'message'	=> 'Selamat anda barang berhasil ditambah',
		], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
