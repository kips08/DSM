@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('draw-requests.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.draw_requests.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('draw-requests.update', $drawRequest) }}"
                class="mt-4"
            >
                @include('app.draw_requests.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('draw-requests.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('draw-requests.create') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
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
