<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Email extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $casts = [
        'favorite' => 'boolean',
        'has_html' => 'boolean',
        'has_text' => 'boolean',
        'size_in_bytes' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'read'
    ];

    use Uuids;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($email) {
            if ($email->isForceDeleting()) {
                Storage::delete($email->path());
                $email->attachments()->delete();
            }
        });
    }

    public function sender()
    {
        return $this->belongsTo('App\Sender');
    }

    public function inbox()
    {
        return $this->belongsTo('App\Inbox');
    }

    public function attachments()
    {
        return $this->hasMany('App\Attachment');
    }

    public function path()
    {
        return 'emails/' . $this->created_at->format('Y/m/d/') . $this->id;
    }

    public function fullPath()
    {
        return storage_path('app/'.$this->path());
    }

    public function isUnread()
    {
        return empty($this->read);
    }

    public function read()
    {
        $this->read = Carbon::now();
        $this->save();
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
