<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyValidatorRequest;
use App\Models\Company;
use Mail;

class CompanyController extends Controller
{
    // all companies
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return response()->json($companies, 200);
    }

    // add company
    public function store(CompanyValidatorRequest $request)
    {
        if (!$request->validated()) {
            return $request->errors();
        }

        $logo = '';
        if ($request->logo && $request->logo->isValid()) {
            $file_name = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images'), $file_name);
            $logo = $file_name;
        }

        $company = new Company([
            'name' => $request->name,
            'email' => $request->email,
            'logo' => $logo,
            'website' => $request->website,
        ]);
        $company->save();

        Mail::send('mails.company_added_mail', [], function($message) {
            $message->to('admin@admin.com')
                    ->from('noreply@sender.com')
                    ->subject('New Company Created');
        });

        return response()->json('The company successfully added');
    }

    // view company
    public function show($id)
    {
        $company = Company::find($id);
        return response()->json($company);
    }

    // edit company
    public function edit($id)
    {
        $company = Company::find($id);
        return response()->json($company);
    }

    // update company
    public function update($id, CompanyValidatorRequest $request)
    {
        if (!$request->validated()) {
            return $request->errors();
        }

        $input = $request->all();

        $logo = '';
        if ($request->logo && $request->logo->isValid()) {
            $file_name = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images'), $file_name);
            $path = "/images/$file_name";
            $input['logo'] = $file_name;
        }

        $company = Company::find($id);
        $company->update($input);

        return response()->json('The company successfully updated');
    }

    // delete company
    public function delete($id)
    {
        $company = Company::find($id);
        $company->delete();

        return response()->json('The company successfully deleted');
    }

    // get all companies
    public function allCompanies()
    {
        $companies = Company::latest()->get();
        return response()->json($companies, 200);
    }
}
