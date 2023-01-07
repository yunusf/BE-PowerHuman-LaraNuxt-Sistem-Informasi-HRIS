<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    //
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $companyQuery = Company::with(['users'])->wherehas('users', function ($query) {
            $query->where('user_id', Auth::id());
        });

        // ex: powerhuman.com/api/company?id=1 | untuk data satuan seperti di bawah ini
        // get singgle data
        if ($id) {
            $company = $companyQuery->find($id);

            if ($company) {
                return ResponseFormatter::success($company, 'Company Found');
            }

            return ResponseFormatter::error('Company Not Found!', 404);
        }

        // ex: powerhuman.com/api/company | mengambil list company
        // mengambil model companies dengan relasi user (menampilkan data companies dengan user di dlmnya ada siapa aja)
        // $companies = Company::with(['users']);
        // get multiple data
        $companies = $companyQuery;

        // membuat filtering data
        if ($name) {
            $companies->where('name', 'like', '%' . $name . '%');
        }

        // ex jika di jadikan 1 baris
        // Company::with(['users'])->where('name', 'like', '%' . $name . '%')->paginate(10);
        return ResponseFormatter::success(
            $companies->paginate($limit),
            'Companies Found'
        );
    }

    public function create(CreateCompanyRequest $request)
    {
        try {
            // Upload Logo
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('public/logos');
            }

            // Create Company
            $company = Company::create([
                'name' => $request->name,
                'logo' => $path,
            ]);

            if (!$company) {
                throw new Exception('Company Not Created');
            }

            // Attach company to user
            $user = User::find(Auth::id());
            $user->companies()->attach($company->id);

            // load users to company
            $company->load('users');

            return ResponseFormatter::success($company, 'Company Created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            // get company
            $company = Company::find($id);

            // if company not found
            if (!$company) {
                throw new Exception('Company Not Found!');
            }

            //upload logo
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('public/logos');
            }

            // Update Company
            $company = Company::updated([
                'name' => $request->name,
                // 'logo' => $path,
                'logo' => isset($path) ? $path : $company->logo,
            ]);

            return ResponseFormatter::success($company, 'Company Update');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
