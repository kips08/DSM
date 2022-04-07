<?php

namespace App\Http\Controllers\Api;

use App\Models\DrawRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DrawRequestResource;
use App\Http\Resources\DrawRequestCollection;
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
            ->paginate();

        return new DrawRequestCollection($drawRequests);
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

        return new DrawRequestResource($drawRequest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DrawRequest $drawRequest)
    {
        $this->authorize('view', $drawRequest);

        return new DrawRequestResource($drawRequest);
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

        return new DrawRequestResource($drawRequest);
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

        return response()->noContent();
    }
}
