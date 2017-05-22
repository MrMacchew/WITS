<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Hierarchy extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    public $timestamps = false;

    protected $table = "hierarchy";


    public function divisions()
    {
    	$this->hasMany('App\Department', 'id');
        return $this->hasMany('App\Department', 'id')
        ->where('id', $this->division_id);
    }

    public function departments()
    {
    	// return $this->hasMany('App\Department', 'id');
        return $this->hasMany('App\Department', 'id')
        ->where('id', $this->department_id);
    }
    public function teams()
    {
    	// return $this->hasMany('App\Department', 'id')->teams
        return $this->hasMany('App\Department', 'id')
        ->where('id', $this->team_id);
    }
}
