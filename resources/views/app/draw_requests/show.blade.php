@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('draw-requests.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.draw_requests.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.draw_requests.inputs.number')</h5>
                    <span>{{ $drawRequest->number ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.draw_requests.inputs.object_name')</h5>
                    <span>{{ $drawRequest->object_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.draw_requests.inputs.ship_type')</h5>
                    <span>{{ $drawRequest->ship_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.draw_requests.inputs.company_id')</h5>
                    <span
                        >{{ optional($drawRequest->company)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('draw-requests.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DrawRequest::class)
                <a
                    href="{{ route('draw-requests.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    @can('view-any', App\Models\Drawing::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Drawings</h4>

            <livewire:request-drawings-detail :drawRequest="$drawRequest" />
        </div>
    </div>
    @endcan
</div>
@endsection
