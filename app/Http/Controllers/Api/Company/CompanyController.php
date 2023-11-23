<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use HttpResponses;
    /**
     * Check if the user is authorized to access this company
     */
    // private function isNotAuthorized(Company $company)
    // {
    //     if (!Auth::user()->isManager() && Auth::user()->company_id !== $company->id) {
    //         return $this->error('','You are not authorized to access this company', 403);
    //     }

    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CompanyResource::collection(
            Company::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());

        return response()->json([
            'data' => new CompanyResource($company),
            'message' => 'Company created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        // return $this->isNotAuthorized($company) ? $this->isNotAuthorized($company) : new CompanyResource($company);
        return new CompanyResource(
            Company::findOrFail($company->id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->validated());
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if ($this->isNotAuthorized($company)) {
            return $this->isNotAuthorized($company);
        }

        $company->delete();
        return $this->success(null,'Company deleted successfully',200);
    }
}
