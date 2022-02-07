<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();

        return response()->json([
            "data" => $sections
        ]);
    }

    /**
     * Store a newly created sections in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|unique:sections,name"
        ]);

        $section = Section::create($validatedData);

        return response()->json([
            "data" => $section,
            "message" => __("messages.success.create", ["name" => "section"])
        ]);
    }

    /**
     * Display the specified section.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = $this->findOrfailObject(Section::class, $id);

        return response()->json([
            "data" => $section,
        ]);
    }

    /**
     * Update the specified section in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "name" => "unique:sections,name"
        ]);

        $section = $this->findOrfailObject(Section::class, $id);
        $section->update($validatedData);

        return response()->json([
            "data" => $section,
            "message" => __("messages.success.update", ["name" => "section"])
        ]);
    }

    /**
     * Remove the specified section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $section = $this->findOrfailObject(Section::class, $id);
        $section->delete();

        return response()->json([
            "message" => __("messages.success.delete", ["name" => "section"])
        ]);
    }
}
