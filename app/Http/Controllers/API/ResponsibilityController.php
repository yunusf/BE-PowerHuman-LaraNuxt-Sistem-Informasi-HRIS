<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use App\Models\Responsibility;
use Exception;
use Illuminate\Http\Request;

class ResponsibilityController extends Controller
{
    //
    public function fetch(Request $request)
    {
        # code...
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $responsibilityQuery = Responsibility::query();

        if ($id) {
            # code...
            $responsibility = $responsibilityQuery->find($id);

            if ($responsibility) {
                # code...
                return ResponseFormatter::success($responsibility, 'Responsibility Found');
            }

            return ResponseFormatter::error('Responsibility Not Found!', 404);
        }

        $responsibilities = $responsibilityQuery->where('role_id', $request->role_id);

        // filter data
        if ($name) {
            # code...
            $responsibilities->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $responsibilities->paginate($limit),
            'Responsibilities Found'
        );
    }

    public function create(CreateResponsibilityRequest $request)
    {
        # code...
        try {
            //code...
            $responsibility = Responsibility::create([
                'name' => $request->name,
                'role_id' => $request->role_id,
            ]);

            return ResponseFormatter::success($responsibility, 'Responsibility Found');
        } catch (Exception $e) {
            //throw $th;
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // public function update(UpdateResponsibilityRequest $request, $id)
    // {
    //     # code...
    //     try {
    //         //code...
    //         $responsibility = Responsibility::find($id);

    //         if (!$responsibility) {
    //             # code...
    //             throw new Exception('Responsibility Not Found!');
    //         }

    //         $responsibility->update([
    //             'name' => $request->name,
    //             'role' => $request->role,
    //         ]);

    //         return ResponseFormatter::success($responsibility, 'Responsibility Update');
    //     } catch (Exception $e) {
    //         //throw $th;
    //         return ResponseFormatter::error($e->getMessage(), 500);
    //     }
    // }

    public function destroy($id)
    {
        # code...
        try {
            //code...
            $responsibility = Responsibility::find($id);

            // TODO: check if responsibility is owned by user

            // check if responsibility exists
            if (!$responsibility) {
                # code...
                throw new Exception('Responsibility Not Found!');
            }

            // Delete Responsibility
            $responsibility->delete();

            return ResponseFormatter::success('Responsibility Deleted');
        } catch (Exception $e) {
            //throw $th;
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
