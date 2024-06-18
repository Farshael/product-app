<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Product::all()->toArray();

            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse('400', 'bad request', $err -> getMessage());
        }
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
        {
            try {
                $this -> validate($request,[
                    'name' => 'required',
                    'category' => 'required',
                    'stock' => 'required',
                    'price' => 'required',
                ]);
    
                $data = Product::create([
                    'name' => $request -> name,
                    'category' => $request -> category,
                    'stock' => $request -> stock,
                    'price' => $request -> price,
                ]);
    
                return ApiFormatter::sendResponse(200, 'success', $data);
            } catch (\Exception $err){
                return ApiFormatter::sendResponse(400, 'bad request', $err -> getMessage());
            }
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
        try {
            $data = Product::where('id', $id)->first();
    
            if(is_null($data)) {
                return ApiFormatter::sendResponse(400, 'bad request', 'Data not found');
            } else {
                return ApiFormatter::sendResponse(200, 'success', $data);
            }
           } catch(\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
           }
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
        try {
            $this ->validate($request, [
                'name' => 'required',
                'category' => 'required',
                'stock' => 'required',
                'price' => 'required',
            ]);

            $checkProses = Product::where('id', $id)-> update([
                'name' => $request -> name,
                'category' => $request -> category,
                'stock' => $request -> stock,
                'price' => $request -> price,
            ]);

            if ($checkProses) {
                $data = Product::find($id);
                return ApiFormatter::sendResponse(200, 'success', $data);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'Gagal Mengubah data!');
            }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err ->getMessage());
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
        try {
            $getStuff = Product::where('id' ,$id)->delete();
            
            return ApiFormatter::sendResponse(200, 'success', 'Data stuff berhasil di hapus!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request' , $err->getMessage());
        }
    }

    public function trash(){
        try {
            $data = Product::onlyTrashed() -> get();

            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err -> getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $checkProses = Product::onlyTrashed() -> where('id', $id) -> restore();

            if ($checkProses) {
                $data = Product::find($id);
                return ApiFormatter::sendResponse(200, 'success', $data);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'Gagal mengembalikan data!');
            }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err -> getMessage());
        }
    }

    public function deletePermanent($id)
    {
        try {
            $checkProses = Product::onlyTrashed() -> where('id', $id)-> forceDelete();

            return ApiFormatter::sendResponse(200, 'success', 'Berhasil menghapus permanen data stuff!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function __construct()
{
    $this->middleware('auth:api');
}
}
