<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamPaper extends Model
{
    protected $fillable = [
        'paper_name',
        'paper_code',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Get the exam marks for this paper.
     */
    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }

    /**
     * Get the exam paper weights for this paper.
     */
    public function examPaperWeights()
    {
        return $this->hasMany(ExamPaperWeight::class, 'paper_code', 'paper_code');
    }

    /**
     * Scope to get only active papers.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
