<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
            'number',
            'name',
            'building_id',
            'style_id',
            'capacity',
            'support_id',
            'latlong',
    ];

    protected $table = "room";
    public function media()
    {
    	return $this->morphMany('App\Media', 'mediable');
    }

    public function software()
    {
        return $this->belongsToMany('App\Software', 'room_software', 'room_id', 'software_id');
    }
    public function building(){
        return $this->belongsTo('App\Building');
    }

}
