<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DrawRequestResource;
use App\Http\Resources\DrawRequestCollection;

class CompanyDrawRequestsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $drawRequests = $company
            ->requests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DrawRequestCollection($drawRequests);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', DrawRequest::class);

        $validated = $request->validate([
            'number' => [
                'required',
                'unique:requests,number',
                'max:255',
                'string',
            ],
            'object_name' => ['required', 'max:255', 'string'],
            'ship_type' => ['nullable', 'max:255', 'string'],
        ]);

        $drawRequest = $company->requests()->create($validated);

        return new DrawRequestResource($drawRequest);
    }
}
