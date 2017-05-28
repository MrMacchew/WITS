<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $table = "software";
    public $timestamps = false;

    protected $fillable = [
    // 'room_id',
    'title',
    'filename',
    'url',
    ];

    public function room()
    {
        return $this->belongsToMany('App\Room', 'room_software', 'software_id', 'room_id');
    }
}
