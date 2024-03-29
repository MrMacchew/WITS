<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }
    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    public $timestamps = false;

    protected $table = "departments";

    protected $fillable = [
        'name',
        'primary_orgcode_id',
        'parent_department_id',
        'primary_contact_name',
        'phone',
        'email'
    ];


    public function org(){
    	return $this->hasMany('App\Org', 'department_id', 'id');
    }

    // public function buildings()
    // {
    //     return $this->belongsToMany('App\Building', 'building_department', 'department_id', 'building_id');
    // }

    public function rooms(){
        return $this->belongsToMany('App\Room');
    }

    // public function buildings(){
    //     return $this->belongsToMany('App\Building');
    // }


    public function users(){
        return $this->hasMany('App\User', 'id');
    }

    public function parent(){
        return $this->hasOne('App\Department', 'id', 'parent_department_id');
    }

    public function children(){
        return $this->hasMany('App\Department', 'parent_department_id', $this->id);
    }

    public function assets()
    {
        return $this->hasMany('App\Asset');
    }
    public function room()
    {
        return $this->hasOne('App\Room');
    }


}
