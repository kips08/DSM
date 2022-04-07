@php $editing = isset($drawRequest) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="number"
            label="Number"
            value="{{ old('number', ($editing ? $drawRequest->number : '')) }}"
            maxlength="255"
            placeholder="Number"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="object_name"
            label="Object Name"
            value="{{ old('object_name', ($editing ? $drawRequest->object_name : '')) }}"
            maxlength="255"
            placeholder="Object Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="ship_type"
            label="Ship Type"
            value="{{ old('ship_type', ($editing ? $drawRequest->ship_type : '')) }}"
            maxlength="255"
            placeholder="Ship Type"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="company_id" label="Company" required>
            @php $selected = old('company_id', ($editing ? $drawRequest->company_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Company</option>
            @foreach($companies as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
