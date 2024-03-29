<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Form;
use App\Models\Panel;
use App\Models\Text;
use App\Types\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\toJSON;

class FormController extends Controller
{
    /**
     * Retrieve aggregated statistics for all forms.
     *
     * This method retrieves aggregated statistics for all forms in the system,
     * including total visits, total submissions, submissions rate, and bounce rate.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats(Request $request)
    {
        try {
            // Retrieve aggregated statistics for all forms
            $stats = Form::selectRaw('SUM(visit) as total_visits, SUM(submission) as total_submissions')->first();

            // Extract aggregated values
            $visits = $stats->total_visits ?? 0;
            $submissions = $stats->total_submissions ?? 0;

            $submissionsRate = $visits > 0 ? ($submissions / $visits) * 100 : 0;
            $bounceRate = 100 - $submissionsRate;
            // Return success response
            return ApiResponse::success([
                'visits' => $visits,
                'submissions' => $submissions,
                'submissionsRate' => $submissionsRate,
                'bounceRate' => $bounceRate
            ]);
        } catch (\Exception $e) {
            // Return failure response
            return ApiResponse::fail([['title' => 'Error occurred', 'description' => 'An unexpected error occurred']], 500);
        }
    }

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
    public function create(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);
            // Create a new form record
            $form = Form::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);
            // Check if form creation was successful
            if ($form) {
                // Return success response
                return ApiResponse::success(['id' => $form->id], [
                    [
                        "title" => 'Form created successfully',
                        "description" => "doen nicly"
                    ]
                ], 201);
            } else {
                // Return failure response
                return ApiResponse::fail(['Form creation failed'], 500);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            // Return failure response with error message
            return ApiResponse::fail(['An error occurred while creating the form'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $form = Form::where('id', $id)->with(['components.panel', 'components.text'])->first();

        if (!$form) {
            return ApiResponse::fail(errors: ['error' => 'Resource not found'], statusCode: 404);
        }
        $form->components = $form->components->map(function ($component) {
            $component['extraAttributes'] = $component[$component->type];
            return collect($component)->reject(function ($value, $key) use ($component) {
                return $value == null || $key == $component['type'];
            });
        });
        return ApiResponse::success(data: ['form' => $form]);
    }

    /**
     * Update the specified resource in storage.
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        // Find the form
        $form = Form::find($id);

        if (!$form) {
            return ApiResponse::fail(errors: ['error' => 'Resource not found'], statusCode: 404);
        }

        $requestData = $request->json()->all();

// Validate request data
        $validator = Validator::make($requestData, []);
        if ($validator->fails()) {
            return ApiResponse::fail(errors: $validator->errors()->toArray(), statusCode: 400);
        }

        try {
            // Begin the transaction
            DB::beginTransaction();

            foreach ($requestData as $requestDataItem) {
                $componentData = collect($requestDataItem)->except(['extraAttributes', 'pivot'])->toArray();

                // Update or create component
                $createdComponent = Component::updateOrCreate(['id' => $componentData['id']], $componentData);

                // Update or create specific type (Panel or Text)
                $extraAttributes = $requestDataItem['extraAttributes'] ?? [];
                switch ($createdComponent->type) {
                    case "panel":
                        Panel::updateOrCreate(['component_id' => $createdComponent->id], $extraAttributes);
                        break;
                    case "text":
                        Text::updateOrCreate(['component_id' => $createdComponent->id], $extraAttributes);
                        break;
                }

                // Attach component to form
                $form->components()->syncWithoutDetaching([$createdComponent->id]);
            }

            // Commit the transaction
            DB::commit();

            return ApiResponse::success(messages: ['message' => 'Resource updated successfully'], statusCode: 200);
        } catch (Exception $e) {
            // Rollback the transaction on exception
            DB::rollback();
            throw $e; // Re-throw the caught exception
        }
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
