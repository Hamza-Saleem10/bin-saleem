<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassesRequest;
use App\Http\Requests\UpdateClassesRequest;
use App\Models\Classes;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $classes = Classes::select('id', 'name')->active()->get();
    //     return $this->sendResponse(true, __('messages.classes_fetched'), $classes);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreClassesRequest $request)
    // {
    //     $classData = $request->validated();

    //     $classData['is_active'] = 1;

    //     $class = Classes::create($classData);

    //     return $this->sendResponse(true, __('messages.class_created'), $class);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $class = Classes::select('id', 'name', 'is_active')->find($id);
    //     if($class) {
    //         return $this->sendResponse(true, __('messages.class_fetched'), $class);
    //     }
    //     return $this->sendResponse(false, __('messages.class_not_found'), [], 404);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(StoreClassesRequest $request, Classes $class)
    // {
    //     $classData = $request->validated();

    //     $class->update($classData);

    //     return $this->sendResponse(true, __('messages.class_updated'), $class);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     return $this->sendResponse(false, __('messages.cannot_deleted'));
    // }
}
