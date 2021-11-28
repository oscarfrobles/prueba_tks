<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\Helpers;

class Planificaciones extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'status',
        'dt_job',
        'user_id',
        'valoracion_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

  



    public function getDtJobAttribute($value)
    {
        //echo Helpers::getUserTimeZone(). "<h1> ".Carbon::parse($value)->timezone(Helpers::getUserTimeZone())."</h1>";
        //echo "Europe/Madrid" . "<h1>".Carbon::parse($value)->timezone("Europe/Madrid")."</h1>";
        //echo "America/Mexico_City" . "<h1>".Carbon::parse($value)->timezone("America/Mexico_City")."</h1>";
        //echo "Europe/London" . "<h1>".Carbon::parse($value)->timezone("Europe/London")."</h1>";
        if(is_null($value)){
            return '';
        }
           
        return Carbon::parse($value)->timezone(Helpers::getUserTimeZone());
    }
}
