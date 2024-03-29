<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyName extends Model
{
    //
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $table = "property_name";
    public $timestamps  = false;

    public function properties(){
        return $this->belongsTo('App\Properties','name_id');
    }
}
