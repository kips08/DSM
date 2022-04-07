<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Drawing;
use App\Models\DrawingLog;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DrawingDrawingLogsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Drawing $drawing;
    public DrawingLog $drawingLog;
    public $drawingLogFiles;
    public $drawingLogReviewFiles;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New DrawingLog';

    protected $rules = [
        'drawingLog.status' => ['required', 'max:255', 'string'],
        'drawingLogFiles' => ['image', 'max:1024'],
        'drawingLog.rev' => ['required', 'numeric'],
        'drawingLog.review_note' => ['required', 'max:255', 'string'],
        'drawingLogReviewFiles' => ['image', 'max:1024'],
    ];

    public function mount(Drawing $drawing)
    {
        $this->drawing = $drawing;
        $this->resetDrawingLogData();
    }

    public function resetDrawingLogData()
    {
        $this->drawingLog = new DrawingLog();

        $this->drawingLogFiles = null;
        $this->drawingLogReviewFiles = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDrawingLog()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.drawing_drawing_logs.new_title');
        $this->resetDrawingLogData();

        $this->showModal();
    }

    public function editDrawingLog(DrawingLog $drawingLog)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.drawing_drawing_logs.edit_title');
        $this->drawingLog = $drawingLog;

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

        if (!$this->drawingLog->drawing_id) {
            $this->authorize('create', DrawingLog::class);

            $this->drawingLog->drawing_id = $this->drawing->id;
        } else {
            $this->authorize('update', $this->drawingLog);
        }

        if ($this->drawingLogFiles) {
            $this->drawingLog->files = $this->drawingLogFiles->store('public');
        }

        if ($this->drawingLogReviewFiles) {
            $this->drawingLog->review_files = $this->drawingLogReviewFiles->store(
                'public'
            );
        }

        $this->drawingLog->files = json_decode($this->drawingLog->files, true);

        $this->drawingLog->review_files = json_decode(
            $this->drawingLog->review_files,
            true
        );

        $this->drawingLog->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', DrawingLog::class);

        collect($this->selected)->each(function (string $id) {
            $drawingLog = DrawingLog::findOrFail($id);

            if ($drawingLog->files) {
                Storage::delete($drawingLog->files);
            }

            if ($drawingLog->review_files) {
                Storage::delete($drawingLog->review_files);
            }

            $drawingLog->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDrawingLogData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->drawing->drawingLogs as $drawingLog) {
            array_push($this->selected, $drawingLog->id);
        }
    }

    public function render()
    {
        return view('livewire.drawing-drawing-logs-detail', [
            'drawingLogs' => $this->drawing->drawingLogs()->paginate(20),
        ]);
    }
}
