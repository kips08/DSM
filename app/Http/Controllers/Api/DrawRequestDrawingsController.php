<?php

namespace App\Http\Controllers\Api;

use App\Models\DrawRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DrawingResource;
use App\Http\Resources\DrawingCollection;

class DrawRequestDrawingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DrawRequest $drawRequest)
    {
        $this->authorize('view', $drawRequest);

        $search = $request->get('search', '');

        $drawings = $drawRequest
            ->drawings()
            ->search($search)
            ->latest()
            ->paginate();

        return new DrawingCollection($drawings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DrawRequest $drawRequest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DrawRequest $drawRequest)
    {
        $this->authorize('create', Drawing::class);

        $validated = $request->validate([
            'component_name' => ['required', 'max:255', 'string'],
            'drawing_name' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'files' => ['image', 'max:1024'],
            'review_note' => ['required', 'max:255', 'string'],
            'review_files' => ['image', 'max:1024'],
        ]);

        if ($request->hasFile('files')) {
            $validated['files'] = $request->file('files')->store('public');
        }

        if ($request->hasFile('review_files')) {
            $validated['review_files'] = $request
                ->file('review_files')
                ->store('public');
        }

        $drawing = $drawRequest->drawings()->create($validated);

        return new DrawingResource($drawing);
    }
}
