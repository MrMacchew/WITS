<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "room_id",
        "name",
        "manufacturer",
        "model",
        "replacement_id",
        "description",
        "weber_inventory_tag",
        "acquisition_date",
        "cost",
        "serial_number",
        "po_number",
        "category_id",
        "checkoutable",
    ];

    protected $hidden = [];

    public function media()
    {
        return $this->morphMany('App\Media', 'mediable');
    }

    public function property()
    {
        return $this->belongsToMany('App\Properties', 'asset_property', 'asset_id', 'property_id');
    }

}
