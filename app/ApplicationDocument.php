<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'application_id', 'document_type', 'document_name', 'file_path', 
        'file_name', 'file_type', 'file_size', 'verified', 
        'verification_notes', 'verified_by', 'verified_at'
    ];

    protected $dates = [
        'verified_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'verified' => 'boolean'
    ];

    /**
     * Document types
     */
    public static function getDocumentTypes()
    {
        return [
            'id_certificate' => 'ID or Birth Certificate',
            'school_certificate' => 'School Certificate',
            'proof_of_payment' => 'Proof of Payment',
            'other' => 'Other Document'
        ];
    }

    /**
     * Relationships
     */
    public function application()
    {
        return $this->belongsTo(OnlineApplication::class, 'application_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Helper methods
     */
    public function getDocumentTypeLabel()
    {
        $types = self::getDocumentTypes();
        return $types[$this->document_type] ?? ucwords(str_replace('_', ' ', $this->document_type));
    }

    public function getFileSizeFormatted()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getFileUrl()
    {
        return Storage::url($this->file_path);
    }

    public function exists()
    {
        return Storage::exists($this->file_path);
    }

    /**
     * Delete file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            if (Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
            }
        });
    }
}
