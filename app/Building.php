<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $table = 'building';
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "campus_id", "name", "latlong"
    ];

    public function campus()
    {
        return $this->belongsTo('App\Campus');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room', 'building_id', 'id')->orderBy('number');
    }

}
