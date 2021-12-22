<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCharacteristic extends Model
{
    use HasFactory;

    //TODO create Many to Many relationship
    const CHARACTERISTIC_NAMES = [
        'sport' => 'Esporte',
        'classic' => 'Clássico',
        'turbo' => 'Turbo',
        'economic' => 'Econômico',
        'city' => 'Para cidade',
        'distant_travels' => 'Para longas viagens'
    ];

    protected $fillable = [
        'vehicle_id',
        'characteristic'
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'id');
    }

    function getCharacteristicName() {
        return self::CHARACTERISTIC_NAMES[$this->characteristic];
    }

}
