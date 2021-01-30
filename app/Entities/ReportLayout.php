<?php

namespace Serbinario\Entities;

use Illuminate\Database\Eloquent\Model;

class ReportLayout extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reports_layouts';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'nome',
                  'grupo'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the projeto for this model.
     */


}
