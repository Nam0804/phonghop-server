<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyManager;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Repository\interface\BaseCompanyRepository;
use App\Repository\interface\BaseUserRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    use HttpResponses;
    protected $company,$user;
    public function __construct(BaseCompanyRepository $company,BaseUserRepository $user)
    {
        $this->company = $company;
        $this->user = $user;
    }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());

        return $this->success([
            'data' => new CompanyResource($company),
            'message' => 'Company created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
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
        $company->update($request->all());
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return $this->success(null,'Company deleted successfully',200);
    }

    public function registerNewCompany(CreateCompanyManager $request)
    {
        dd($request->validated($request->all()));
        $request->validated($request->all());
        DB::beginTransaction();
        try {
            $company = $this->company->create([
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_domain' => $request->company_domain,
                'company_tax_code' => $request->company_taxcode,
            ]);
            if ($company) {
                $user = $this->user->create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 1,
                    'phone' => $request->phone,
                    'title' => $request->title,
                    'company_id' => $company->id,
                    'is_first_login' => 0,
                ]);
                if ($user) {
                    DB::commit();
                    return $this->success([
                        'data' => [new CompanyResource($company),new UserResource($user)],
                        'message' => 'Company and Manager created successfully',
                    ], 200);
                }
            }

        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();
            dd($e);
            return $this->error(null,'Company and Manager not created', 404);
        }
    }
}
