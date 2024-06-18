<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Category::all()->toArray();

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
                ]);
    
                $data = Category::create([
                    'name' => $request -> name,
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
            $data = Category::where('id', $id)->first();
    
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
            ]);

            $checkProses = Category::where('id', $id)-> update([
                'name' => $request -> name,
            ]);

            if ($checkProses) {
                $data = Category::find($id);
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
            $getStuff = Category::where('id' ,$id)->delete();
            
            return ApiFormatter::sendResponse(200, 'success', 'Data stuff berhasil di hapus!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request' , $err->getMessage());
        }
    }

    public function trash(){
        try {
            $data = Category::onlyTrashed() -> get();

            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err -> getMessage());
        }
    }

    public function __construct()
{
    $this->middleware('auth:api');
}
}
