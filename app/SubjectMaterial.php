<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SubjectMaterial extends Model
{
    protected $fillable = [
        'module_allocation_id',
        'document_name',
        'document_description',
        'category',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'published',
        'end_date',
        'uploaded_by'
    ];

    protected $dates = [
        'end_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'published' => 'boolean',
        'end_date' => 'date'
    ];

    /**
     * Get the module allocation that owns the material
     */
    public function moduleAllocation()
    {
        return $this->belongsTo(SubjectAllocation::class, 'module_allocation_id');
    }

    /**
     * Get the user who uploaded the material
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the subject through module allocation
     */
    public function subject()
    {
        return $this->hasOneThrough(Subject::class, SubjectAllocation::class, 'id', 'id', 'module_allocation_id', 'subject_id');
    }

    /**
     * Scope for published materials
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope for active materials (not expired)
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', now()->toDateString());
        });
    }

    /**
     * Scope for specific category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) return 'Unknown';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if material is expired
     */
    public function getIsExpiredAttribute()
    {
        if (!$this->end_date) return false;
        return $this->end_date < now()->toDateString();
    }

    /**
     * Get download URL
     */
    public function getDownloadUrlAttribute()
    {
        return route('my-modules.download-material', $this->id);
    }

    /**
     * Delete file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($material) {
            if (Storage::exists($material->file_path)) {
                Storage::delete($material->file_path);
            }
        });
    }

    /**
     * Available material categories
     */
    public static function getCategories()
    {
        return [
            'Syllabus' => 'Syllabus',
            'Class Notes' => 'Class Notes',
            'General Info' => 'General Info',
            'Exam Papers' => 'Exam Papers',
            'Others' => 'Others'
        ];
    }
}
