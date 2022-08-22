<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function getAll()
    {

        $employee = Employee::orderBy('fistname')->get();
        foreach ($employee as $each) {
            $each->company;
        }
        $respond = [
            'status' => 201,
            'message' => "All Employee",
            'data' => $employee,
        ];

        return $respond;
    }

    public function get($id)
    {
        $employee = Employee::find($id);
        if (!isset($employee)) {

            $respond = [
                'status' => 404,
                'message' => "Employee of id=$id doesn't exist",
                'data' => $employee,
            ];

            return $respond;
        }

        $employee->company;

        $respond = [
            'status' => 201,
            'message' => "Employee of id $id",
            'data' => $employee,
        ];

        return $respond;
    }


    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|between:2,100',
            'lastname' => 'required|string|between:2,100',
            'email' => 'string|email|max:255',
            'phone' => 'numeric|min:8',
            'company_id' => 'string',
        ]);

        $company = Company::find($request->company_id);


        if ($validator->fails()) {
            $respond = [
                'status' => 404,
                'message' =>  $validator->errors()->first(),
                'data' => null,
            ];

            return $respond;
        }

        if (!isset($company)) {
            $respond = [
                'status' => 404,
                'message' => "Company doesn't exist",
                'data' => null,
            ];

            return $respond;
        }

        $employee = new Employee;
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;
        $employee->save();
        $employee->company;

        return $employee;
    }

    public function update(Request $request, $id)
    {

        $employee = Employee::find($id);

        if (isset($employee)) {

            $validator = Validator::make($request->all(), [
                'firstname' => 'string|between:2,100',
                'lastname' => 'string|between:2,100',
                'email' => 'string|email|max:255',
                'phone' => 'numeric|min:8',
                'company_id' => 'string',
            ]);

            $company = Company::find($request->company_id);


            if ($validator->fails()) {
                $respond = [
                    'status' => 404,
                    'message' =>  $validator->errors()->first(),
                    'data' => null,
                ];

                return $respond;
            }

            if (!isset($company)) {
                $respond = [
                    'status' => 404,
                    'message' => "Company doesn't exist",
                    'data' => null,
                ];
    
                return $respond;
            }

            $request->firstname ? $employee->firstname = $request->firstname : null;
            $request->lastname ? $employee->lastname = $request->lastname : null;
            $request->email ? $employee->email = $request->email : null;
            $request->phone ? $employee->phone = $request->phone : null;
            $request->company_id ? $employee->company_id = $request->company_id : null;
            $employee->save();
            $employee->company;

            $respond = [
                'status' => 201,
                'message' =>  "Employee updated successfully",
                'data' => $employee,
            ];

            return $respond;
        }

        $respond = [
            'status' => 404,
            'message' =>  "Employee with id=$id doesn't exist",
            'data' => null,
        ];

        return $respond;
    }

    public function delete($id)
    {

        $employee = Employee::find($id);

        if (isset($employee)) {
            $employee->delete();
            $all_employeees = Employee::all();
            foreach ($all_employeees as $each) {
                $each->company;
            }

            $respond = [
                'status' => 201,
                'message' =>  "Successfully Deleted",
                'data' => $all_employeees,
            ];
            return $respond;
        }

        $respond = [
            'status' => 404,
            'message' =>  "Employee with id=$id doesn't exist",
            'data' => null,
        ];

        return $respond;
    }
}
