<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hi index';
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
        ]);

        $image_path = Str::random(32).'.'.$request->file('image')->getClientOriginalExtension();

        $image_path = store('image', 'public');

        return $image_path;
        // return $image_path;
        $data = Service::create([
            'image' => $image_path,
        ]);

        // return response($data, Response::HTTP_CREATED);

        // $service = new Service();
        // $request->validate([
        //     'title' => 'required',
        //     'image' => 'required|max:1024',
        // ]);

        // $filename = '';
        // if ($request->hasFile('image')) {
        //     $filename = $request->file('image');
        // } else {
        //     $filename = null;
        // }

        // $images->title = $request->title;
        // $images->title = $request->image;
        // $result = $images->save();
        // if ($result) {
        //     return response()->json(['success' => true]);
        // } else {
        //     return response()->json(['success' => false]);
        // }

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'hi show';

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 'hi update';

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
        return 'hi destroy';

        //
    }
}
