@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('companies.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.companies.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.companies.inputs.name')</h5>
                    <span>{{ $company->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.companies.inputs.location')</h5>
                    <span>{{ $company->location ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.companies.inputs.email')</h5>
                    <span>{{ $company->email ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.companies.inputs.telephone')</h5>
                    <span>{{ $company->telephone ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('companies.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Company::class)
                <a href="{{ route('companies.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
