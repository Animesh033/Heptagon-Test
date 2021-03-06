<?php

namespace App\Http\Controllers\Heptagon;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\Heptagon\Employee;
use App\Http\Controllers\Controller;
use App\Models\Heptagon\Company;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(5);
        $companies = $this->getAllCompanies();
        return view('heptagon.admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = $this->getAllCompanies();
        return view('heptagon.admin.employee.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'designation', 'status']);
        // return response()->json($data);
        $rules = ['first_name' => 'required', 'last_name' => 'required', 'email' => 'present',
        'phone' => 'present', 'designation' => 'present', 'status' => 'present'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
            return response()->json(['error'=> 'Something went wrong! Employee couldn\'t created successfully.', 'errors' => $validator->errors()]);

        $hashids = new Hashids('', 10);
        $companyId = $hashids->decodeHex($request->company_id);
        $data['company_id'] = $companyId;
        $employee = new Employee($data);
        $employee->save();
        return response()->json(['success'=>'Employee created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->getEmployeeData($id);
        return view('heptagon.admin.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->getEmployeeData($id);
        $companies = $this->getAllCompanies();
        return view('heptagon.admin.employee.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $employee = $this->getEmployeeData($id);
        if($employee) {
            $data = $request->all();
            $hashids = new Hashids('', 10);
            $companyId = $hashids->decodeHex($request->company_id);
            $employeeId = $hashids->decodeHex($id);
            $data['company_id'] = $companyId;
            $employee = Employee::findOrFail($employeeId);
            $companyUpdated = $employee->update($data);
            if ($companyUpdated) {
                return response()->json(['success'=>'Employee updated successfully.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = $this->getEmployeeData($id);
        if($employee) {
            $employeeDeleted = $employee->forceDelete();
            if ($employeeDeleted) {
                return response()->json(['success'=>'Employee deleted successfully.']);
            }
        }
    }

    public function getEmployeeData($id){
        $hashids = new Hashids('', 10);
        $employeeId = $hashids->decodeHex($id);
        $employee = Employee::findOrFail($employeeId);
        if($employee)
            return $employee;
        return NULL;
    }


    public function getAllCompanies(){
        return Company::select('id', 'name')->get();
    }
}
