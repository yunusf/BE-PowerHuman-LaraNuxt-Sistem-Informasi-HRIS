<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Exception;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $age = $request->input('age');
        $phone = $request->input('phone');
        $team_id = $request->input('team_id');
        $role_id = $request->input('role_id');
        $limit = $request->input('limit', 10);

        $employeeQuery = Employee::query();

        // Get Single Data
        if ($id) {
            # code...
            $employee = $employeeQuery->with(['team', 'role'])->find($id);

            if ($employee) {
                # code...
                return ResponseFormatter::success($employee, 'Employee Found');
            }
            return ResponseFormatter::error('Employee Not Found', 404);
        }

        // Get Multiple Data
        $employees = $employeeQuery;

        if ($name) {
            # code...
            $employees->where('name', 'like', '%' . $name . '%');
        }

        if ($email) {
            $employees->where('email', $email);
        }

        if ($age) {
            $employees->where('age', $age);
        }

        if ($phone) {
            $employees->where('phone', 'like', '%' . $phone . '%');
        }

        if ($team_id) {
            $employees->where('team_id', $team_id);
        }

        if ($role_id) {
            $employees->where('role_id', $role_id);
        }

        return ResponseFormatter::success(
            $employees->paginate($limit),
            'Employees Found'
        );
    }
    public function Create(CreateEmployeeRequest $request)
    {
        try {
            //code...
            if ($request->hasFile('photo')) {
                # code...
                $path = $request->file('photo')->store('public/photos');
            }

            $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'age' => $request->age,
                'phone' => $request->phone,
                'photo' => $path,
                'team_id' => $request->team_id,
                'role_id' => $request->role_id,
                // 'is_verified' => 'required',
                // 'verified_at' => 'nullable|timezone',
            ]);

            if (!$employee) {
                # code...
                throw new Exception('Employee Not Created');
            }

            return ResponseFormatter::success($employee, 'Employee Created');
        } catch (Exception $e) {
            //throw $th;
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // TODO: Make Update
    public function Update(UpdateEmployeeRequest $request, $id)
    {
        try {
            //code...
            $employee = Employee::find($id);

            if (!$employee) {
                # code...
                throw new Exception('Employee Not Found!');
            }

            // upload photo
            if ($request->hasFile('photo')) {
                # code...
                $path = $request->file('photo')->store('public/photos');
            }

            // update employee
            $employee->Update([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'age' => $request->age,
                'phone' => $request->phone,
                'photo' => isset($path) ? $path : $employee->photo,
                'team_id' => $request->team_id,
                'role_id' => $request->role_id,
                // 'is_verified' => 'required',
                // 'verified_at' => 'nullable|timezone',
            ]);

            return ResponseFormatter::success($employee, 'Employee Update');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // TODO: Make building
    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);

            // TODO: Check if team is owned by user!

            // check if employee exists
            if (!$employee) {
                throw new Exception('Employee Not Found!');
            }

            // delete employee
            $employee->delete();
            return ResponseFormatter::success('Employee Deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
