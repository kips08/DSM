<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DrawRequest;
use Illuminate\Http\Request;
use App\Http\Requests\DrawRequestStoreRequest;
use App\Http\Requests\DrawRequestUpdateRequest;

class DrawRequestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DrawRequest::class);

        $search = $request->get('search', '');

        $drawRequests = DrawRequest::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.draw_requests.index',
            compact('drawRequests', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DrawRequest::class);

        $companies = Company::pluck('name', 'id');

        return view('app.draw_requests.create', compact('companies'));
    }

    /**
     * @param \App\Http\Requests\DrawRequestStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DrawRequestStoreRequest $request)
    {
        $this->authorize('create', DrawRequest::class);

        $validated = $request->validated();

        $drawRequest = DrawRequest::create($validated);

        return redirect()
            ->route('draw-requests.edit', $drawRequest)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DrawRequest $drawRequest)
    {
        $this->authorize('view', $drawRequest);

        return view('app.draw_requests.show', compact('drawRequest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DrawRequest $drawRequest)
    {
        $this->authorize('update', $drawRequest);

        $companies = Company::pluck('name', 'id');

        return view(
            'app.draw_requests.edit',
            compact('drawRequest', 'companies')
        );
    }

    /**
     * @param \App\Http\Requests\DrawRequestUpdateRequest $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function update(
        DrawRequestUpdateRequest $request,
        DrawRequest $drawRequest
    ) {
        $this->authorize('update', $drawRequest);

        $validated = $request->validated();

        $drawRequest->update($validated);

        return redirect()
            ->route('draw-requests.edit', $drawRequest)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DrawRequest $drawRequest)
    {
        $this->authorize('delete', $drawRequest);

        $drawRequest->delete();

        return redirect()
            ->route('draw-requests.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
