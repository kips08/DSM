<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrawingLog extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'status',
        'rev',
        'files',
        'uploaded_at',
        'uploaded_by',
        'reviewed_at',
        'reviewed_by',
        'review_note',
        'review_files',
        'drawing_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'drawing_logs';

    protected $casts = [
        'files' => 'array',
        'uploaded_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'review_files' => 'array',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function drawing()
    {
        return $this->belongsTo(Drawing::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
