<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'chassis_number',
        'brand',
        'model',
        'year',
        'plate'
    ];

    public function characteristics() {
        return $this->hasMany(VehicleCharacteristic::class, 'vehicle_id');
    }

    function hasCharacteristic(string $characteristic) : bool {
        foreach ($this->characteristics as $vehicle_characteristic) {
            if($characteristic===$vehicle_characteristic->characteristic) {
                return true;
            }
        }
        return false;
    }

}
