<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'video',
        'pdf_notes',
        'order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function isVideoUrl(): bool
    {
        return $this->video && filter_var($this->video, FILTER_VALIDATE_URL);
    }

    public function videoEmbedUrl(): ?string
    {
        if (! $this->video) {
            return null;
        }

        if (! $this->isVideoUrl()) {
            return asset('storage/'.$this->video);
        }

        $url = $this->video;

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return $url;
    }

    public function pdfUrl(): ?string
    {
        return $this->pdf_notes ? asset('storage/'.$this->pdf_notes) : null;
    }
}
