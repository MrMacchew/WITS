<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildDepartRoom extends Model
{
    protected $table = "build_depart_room";

    public function building()
    {
        return $this->belongsTo('App\Building');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

}
