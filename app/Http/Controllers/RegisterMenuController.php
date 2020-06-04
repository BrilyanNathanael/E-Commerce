<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Menu;

class RegisterMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('regisMenu');
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
        if($request->ajax())
        {
            $rules = array(
                'nama_menu.*'  => 'required',
                'deskripsi_menu.*'  => 'required',
                'harga_menu.*'  => 'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }
            $nama = auth()->user()->nama;
            $nama_dapur = 'namadapur';
            $nama_menu = $request->nama_menu;
            $deskripsi_menu = $request->deskripsi_menu;
            $harga_menu = $request->harga_menu;
            for($count = 0; $count < count($nama_menu); $count++)
            {
                $data = array(
                    'nama' => $nama,
                    'nama_dapur' => $nama_dapur,
                    'nama_menu' => $nama_menu[$count],
                    'deskripsi_menu'  => $deskripsi_menu[$count],
                    'harga_menu'  => $harga_menu[$count],
                );
                $insert_data[] = $data; 
            }

            Menu::insert($insert_data);
            return response()->json([
                'success'  => 'Berhasil ditambahkan'
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
