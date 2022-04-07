<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drawing extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'component_name',
        'drawing_name',
        'status',
        'rev',
        'files',
        'uploaded_at',
        'uploaded_by',
        'reviewed_at',
        'reviewed_by',
        'review_note',
        'review_files',
        'request_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'files' => 'array',
        'uploaded_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'review_files' => 'array',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function drawingLogs()
    {
        return $this->hasMany(DrawingLog::class);
    }

    public function request()
    {
        return $this->belongsTo(DrawRequest::class, 'request_id');
    }
}
