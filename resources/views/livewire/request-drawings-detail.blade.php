<div>
    <div class="mb-4">
        @can('create', App\Models\Drawing::class)
        <button class="btn btn-primary" wire:click="newDrawing">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Drawing::class)
        <button
            class="btn btn-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="icon ion-md-trash"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal id="request-drawings-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="drawing.component_name"
                            label="Component Name"
                            wire:model="drawing.component_name"
                            maxlength="255"
                            placeholder="Component Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="drawing.drawing_name"
                            label="Drawing Name"
                            wire:model="drawing.drawing_name"
                            maxlength="255"
                            placeholder="Drawing Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="drawing.status"
                            label="Status"
                            wire:model="drawing.status"
                            maxlength="255"
                            placeholder="Status"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <div
                            image-url="{{ $editing && $drawing->files ? \Storage::url($drawing->files) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="drawingFiles"
                                label="Files"
                            ></x-inputs.partials.label
                            ><br />

                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="drawingFiles"
                                    id="drawingFiles{{ $uploadIteration }}"
                                    wire:model="drawingFiles"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('drawingFiles')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="drawing.review_note"
                            label="Review Note"
                            wire:model="drawing.review_note"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <div
                            image-url="{{ $editing && $drawing->review_files ? \Storage::url($drawing->review_files) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="drawingReviewFiles"
                                label="Review Files"
                            ></x-inputs.partials.label
                            ><br />

                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="drawingReviewFiles"
                                    id="drawingReviewFiles{{ $uploadIteration }}"
                                    wire:model="drawingReviewFiles"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('drawingReviewFiles')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @can('view-any', App\Models\DrawingLog::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">Drawing Logs</h6>

                    <livewire:drawing-drawing-logs-detail :drawing="$drawing" />
                </div>
            </div>
            @endcan @endif

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light float-left"
                    wire:click="$toggle('showingModal')"
                >
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="text-left">
                        @lang('crud.request_drawings.inputs.component_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.request_drawings.inputs.drawing_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.request_drawings.inputs.status')
                    </th>
                    <th class="text-left">
                        @lang('crud.request_drawings.inputs.files')
                    </th>
                    <th class="text-left">
                        @lang('crud.request_drawings.inputs.review_note')
                    </th>
                    <th class="text-left">
                        @lang('crud.request_drawings.inputs.review_files')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($drawings as $drawing)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $drawing->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $drawing->component_name ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $drawing->drawing_name ?? '-' }}
                    </td>
                    <td class="text-left">{{ $drawing->status ?? '-' }}</td>
                    <td class="text-left">
                        <x-partials.thumbnail
                            src="{{ $drawing->files ? \Storage::url($drawing->files) : '' }}"
                        />
                    </td>
                    <td class="text-left">
                        {{ $drawing->review_note ?? '-' }}
                    </td>
                    <td class="text-left">
                        <x-partials.thumbnail
                            src="{{ $drawing->review_files ? \Storage::url($drawing->review_files) : '' }}"
                        />
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $drawing)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editDrawing({{ $drawing->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">{{ $drawings->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
