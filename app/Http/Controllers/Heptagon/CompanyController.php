<?php

namespace App\Http\Controllers\Heptagon;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Imports\CompaniesImport;
use App\Models\Heptagon\Company;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Heptagon\StoreCompanyRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::withCount('employees')->paginate(5);
        return view('heptagon.admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('heptagon.admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('logo')) {
            $validatedData = $this->uploadCompanyLogo($request, $validatedData);
        }
        $company = Company::create($validatedData);
        if($company)
            return redirect()->back()->with('success', 'Company created successfully');

        return redirect()->back()->with('error', 'Something went wromg!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = $this->getCompanyData($id);
        $employees = NULL;
        if($company)
            $employees = $company->employees()->paginate(5);
        return view('heptagon.admin.company.show', compact('company', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = $this->getCompanyData($id);
        return view('heptagon.admin.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = $this->getCompanyData($id);
        if($company) {
            $data = $request->all();
            if ($request->hasFile('logo')) {
                $this->deleteCompanyLogo($company->logo);
                $data = $this->uploadCompanyLogo($request, $data);
            }
            $companyUpdated = $company->update($data);
            if ($companyUpdated) {
                return redirect('companies')->with('success', 'Company is updated successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = $this->getCompanyData($id);
        if($company) {
            $this->deleteCompanyLogo($company->logo);
            $companyDeleted = $company->forceDelete();
            if ($companyDeleted) {
                return redirect('companies')->with('success', 'Company is deleted permanently.');
            }
        }
    }

    public function getCompanyData($id){
        $hashids = new Hashids('', 10);
        $companyId = $hashids->decodeHex($id);
        $company = Company::findOrFail($companyId);
        if($company)
            return $company;
        return NULL;
    }


    public function uploadCompanyLogo($request, $data) {
        $extension = $request->logo->extension();
        $logoName = 'logo_'.now()->format('Ymdhis').'.'.$extension;
        $path = $request->logo->storeAs('public/images', $logoName);
        if($path)
            $data['logo'] = $logoName;
        return $data;
    }

    public function deleteCompanyLogo($logo){
        $isExists = file_exists(public_path() . $logo);
        if($logo && $isExists)
            unlink(public_path() . $logo);
    }

    public function import(Request $request){
    	//validate the xls file
		$this->validate($request, array(
			'excel_file'      => 'required'
		));

		if($request->hasFile('excel_file')){
            try {
                Excel::import(new CompaniesImport, request()->file('excel_file'));
            } catch (ValidationException $e) {
                 $failures = $e->failures();

                 foreach ($failures as $failure) {
                     $failure->row(); // row that went wrong
                     $failure->attribute(); // either heading key (if using heading row concern) or column index
                     $failure->errors(); // Actual error messages from Laravel validator
                     $failure->values(); // The values of the row that has failed.
                 }
            }
            // (new CompaniesImport)->queue(request()->file('excel_file'));
            return redirect('companies')->with('success', 'Data is imported successfully.');
		}
	}

    public function downloadTemplate() {
        return response()->download(storage_path('app/public/'.config('heptagon.company_bulk_upload_template_file')));
    }
}
