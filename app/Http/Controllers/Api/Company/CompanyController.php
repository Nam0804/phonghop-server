<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use HttpResponses;

    /**
     * Check if the user is authorized to access this company
     */
    private function isNotAuthorized(Company $company)
    {
        if (!Auth::user()->isManager() && Auth::user()->company_id !== $company->id) {
            return $this->error('', 'You are not authorized to access this company', 403);
        }

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->can('show-all-company')){
            return CompanyResource::collection(
                Company::all());
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        if(auth()->user()->can('add-company')){
            $company = Company::create($request->validated());

            return $this->success([
                'data' => new CompanyResource($company),
                'message' => 'Company created successfully',
            ], 201);
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     */
    public function show(Company $company)
    {
        if(auth()->user()->can('show-company')){
            return new CompanyResource(
                Company::findOrFail($company->id)
            );
        }else{
            abort(403, 'You need permission to do this action.');
        }
        // return $this->isNotAuthorized($company) ? $this->isNotAuthorized($company) : new CompanyResource($company);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        if(auth()->user()->can('update-company')){
            $company->update($request->all());
            return new CompanyResource($company);
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
//        if ($this->isNotAuthorized($company)) {
//            return $this->isNotAuthorized($company);
//        }

        if(auth()->user()->can('delete-company')){
            $company->delete();
            return $this->success(null, 'Company deleted successfully', 200);
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }
}
