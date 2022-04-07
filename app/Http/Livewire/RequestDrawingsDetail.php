<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Drawing;
use App\Models\DrawRequest;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RequestDrawingsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public DrawRequest $drawRequest;
    public Drawing $drawing;
    public $drawingFiles;
    public $drawingReviewFiles;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Drawing';

    protected $rules = [
        'drawing.component_name' => ['required', 'max:255', 'string'],
        'drawing.drawing_name' => ['required', 'max:255', 'string'],
        'drawing.status' => ['required', 'max:255', 'string'],
        'drawingFiles' => ['image', 'max:1024'],
        'drawing.review_note' => ['required', 'max:255', 'string'],
        'drawingReviewFiles' => ['image', 'max:1024'],
    ];

    public function mount(DrawRequest $drawRequest)
    {
        $this->drawRequest = $drawRequest;
        $this->resetDrawingData();
    }

    public function resetDrawingData()
    {
        $this->drawing = new Drawing();

        $this->drawingFiles = null;
        $this->drawingReviewFiles = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDrawing()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.request_drawings.new_title');
        $this->resetDrawingData();

        $this->showModal();
    }

    public function editDrawing(Drawing $drawing)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.request_drawings.edit_title');
        $this->drawing = $drawing;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->drawing->request_id) {
            $this->authorize('create', Drawing::class);

            $this->drawing->request_id = $this->drawRequest->id;
        } else {
            $this->authorize('update', $this->drawing);
        }

        if ($this->drawingFiles) {
            $this->drawing->files = $this->drawingFiles->store('public');
        }

        if ($this->drawingReviewFiles) {
            $this->drawing->review_files = $this->drawingReviewFiles->store(
                'public'
            );
        }

        $this->drawing->files = json_decode($this->drawing->files, true);

        $this->drawing->review_files = json_decode(
            $this->drawing->review_files,
            true
        );

        $this->drawing->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Drawing::class);

        collect($this->selected)->each(function (string $id) {
            $drawing = Drawing::findOrFail($id);

            if ($drawing->files) {
                Storage::delete($drawing->files);
            }

            if ($drawing->review_files) {
                Storage::delete($drawing->review_files);
            }

            $drawing->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDrawingData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->drawRequest->drawings as $drawing) {
            array_push($this->selected, $drawing->id);
        }
    }

    public function render()
    {
        return view('livewire.request-drawings-detail', [
            'drawings' => $this->drawRequest->drawings()->paginate(20),
        ]);
    }
}
