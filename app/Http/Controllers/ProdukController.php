<?php

namespace App\Http\Controllers;

use App\Produk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["count"] = Produk::count();
        $produk = array();

        foreach (Produk::all() as $p) {
            $item = [
                "id"                => $p->id,
                "tipe"              => $p->tipe,
                "nama"              => $p->nama,
                "gambar"            => $p->gambar,
                "deskripsi"         => $p->deskripsi,
                "harga"             => $p->harga,
                "stok"              => $p->stok,
                "berat"    	        => $p->berat . " Kg",
                "tanggal" 			=> date('j F Y', strtotime($p->created_at)),
            ];

            array_push($produk, $item);
        }
        $data["produk"] = $produk;
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
        try{
            
            $validator = Validator::make($request->all(), [
                'tipe'            => 'required|string',
                'nama'            => 'required|string|max:255',
                'gambar'          => 'required|string',
                'deskripsi'       => 'required|string|max:255',
                'harga'           => 'required|integer',
                'stok'            => 'required|integer',
                'berat'           => 'required|integer',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'status'	=> 0,
                    'message'	=> $validator->errors()
                ]);
            }
    
            $produk = new Produk();
            $produk->tipe 	    = $request->tipe;
            $produk->nama 	    = $request->nama;
            $produk->gambar 	= $request->gambar;
            $produk->deskripsi  = $request->deskripsi;
            $produk->harga 	    = $request->harga;
            $produk->stok       = $request->stok;
            $produk->berat      = $request->berat;
            $produk->save();
    
            return response()->json([
                'status'	=> '1',
                'message'	=> 'Selamat produk anda berhasil ditambah',
            ], 201);

        } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
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
        try{
    		$validator = Validator::make($request->all(), [
                'tipe'            => 'required|string',
                'nama'            => 'required|string|max:255',
                'gambar'          => 'required|string',
                'deskripsi'       => 'required|string|max:255',
                'harga'           => 'required|integer',
                'stok'            => 'required|integer',
                'berat'           => 'required|integer',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}
  
            $produk = Produk::where('id', $id)->first();
	        $produk->tipe 	    = $request->tipe;
            $produk->nama 	    = $request->nama;
            $produk->gambar 	= $request->gambar;
            $produk->deskripsi  = $request->deskripsi;
            $produk->harga 	    = $request->harga;
            $produk->stok       = $request->stok;
            $produk->berat      = $request->berat;
            $produk->save();
  
            return response()->json([
                'status'	=> '1',
                'message'	=> 'Data produk berhasil diubah'
            ]);
          
        } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            $delete = Produk::where("id", $id)->delete();

            if($delete){
              return response([
                "status"  => 1,
                  "message"   => "Data produk berhasil dihapus."
              ]);

            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data produk gagal dihapus."
              ]);
            }

        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}