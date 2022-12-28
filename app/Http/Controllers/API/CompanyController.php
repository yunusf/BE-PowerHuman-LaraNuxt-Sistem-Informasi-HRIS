<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    public function all(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // ex: powerhuman.com/api/company?id=1 | untuk data satuan seperti di bawah ini
        if ($id) {
            $company = Company::with(['users'])->find($id);

            if ($company) {
                return ResponseFormatter::success($company, 'Company Found');
            }

            return ResponseFormatter::error('Company Not Found!', 404);
        }

        // ex: powerhuman.com/api/company | mengambil list company
        // mengambil model companies dengan relasi user (menampilkan data companies dengan user di dlmnya ada siapa aja)
        $companies = Company::with(['users']);

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
}
