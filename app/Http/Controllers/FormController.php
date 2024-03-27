<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Types\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::all();
        return ApiResponse::success(data: ['forms' => $forms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Define your validation rules here
        ]);

        if ($validator->fails()) {
            return ApiResponse::fail(errors: $validator->errors()->toArray(), statusCode: 400);
        }

        // Create the resource
        // Example: $form = Form::create($request->all());

        return ApiResponse::success(messages: ['message' => 'Resource created successfully'], statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $form = Form::find($id);

        if (!$form) {
            return ApiResponse::fail(errors: ['error' => 'Resource not found'], statusCode: 404);
        }

        return ApiResponse::success(data: ['form' => $form]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $form = Form::find($id);

        if (!$form) {
            return ApiResponse::fail(errors: ['error' => 'Resource not found'], statusCode: 404);
        }

        $validator = Validator::make($request->all(), [
            // Define your validation rules here
        ]);

        if ($validator->fails()) {
            return ApiResponse::fail(errors: $validator->errors()->toArray(), statusCode: 400);
        }

        // Update the resource
        // Example: $form->update($request->all());

        return ApiResponse::success(messages: ['message' => 'Resource updated successfully'], statusCode: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $form = Form::find($id);

        if (!$form) {
            return ApiResponse::fail(errors: ['error' => 'Resource not found'], statusCode: 404);
        }

        $form->isDeleted = true;

        if ($form->save()) {
            return ApiResponse::success(messages: ['message' => 'Resource marked as deleted successfully'], statusCode: 200);
        } else {
            return ApiResponse::fail(errors: ['error' => 'Failed to mark resource as deleted'], statusCode: 500);
        }
    }
}
