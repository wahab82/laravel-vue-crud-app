<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeValidatorRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // all employees
    public function index()
    {
        $employees = Employee::latest()->paginate(5);
        return response()->json($employees, 200);
    }

    // add employee
    public function store(EmployeeValidatorRequest $request)
    {
        if (!$request->validated()) {
            return $request->errors();
        }

        $employee = new Employee([
            'company_id' => $request->company_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        $employee->save();

        return response()->json('The employee successfully added');
    }

    // show employee
    public function show($id)
    {
        $employee = Employee::find($id); 
        return response()->json($employee);
    }

    // edit employee
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    // update employee
    public function update($id, EmployeeValidatorRequest $request)
    {
        if (!$request->validated()) {
            return $request->errors();
        }

        $employee = Employee::find($id);
        $employee->update($request->all());

        return response()->json('The employee successfully updated');
    }

    // delete employee
    public function delete($id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        return response()->json('The employee successfully deleted');
    }
}
