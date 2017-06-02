<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $table = 'campus';
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'campus_code', 'latlong'
    ];

    public function buildings()
    {
        return $this->hasMany('App\Building', 'campus_id', 'id')->orderBy('name');
    }

}
