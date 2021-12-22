<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCharacteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class VehiclesController extends Controller
{
    
    public function index(Request $request) {
        $vehicles = Vehicle::get();
        $vehicles = Vehicle::where('chassis_number', 'LIKE', '%'.$request->input('query_chassis_number').'%')
            ->where('plate', 'LIKE', '%'.'%'.$request->input('query_plate').'%')
            //->hasMany(VehicleCharacteristic::class)
            //->where('characteristic', '=', $request->input('query_characteristics'))
            ->get();
        
        return view('vehicles.index', ['vehicles' => $vehicles]);
    }

    public function create() {
        return view('vehicles.create');
    }

    public function edit($id) {
        $vehicle = Vehicle::with('characteristics')->findOrFail($id);
        return view('vehicles.edit', ['vehicle' => $vehicle]);
    }

    public function save(Request $request) {
        #region validations
        $number_of_characteristics = 0; //used to validate the min of 2 characteristics by vehicle
        if($request->input('characteristicsModel') !== null) $number_of_characteristics++;
        if($request->input('characteristicsType') !== null) $number_of_characteristics++;
        if($request->input('characteristicsDistance') !== null) $number_of_characteristics++;
        $request->request->set('number_of_characteristics', $number_of_characteristics);

        //TODO validate chassis_number mask
        //TODO validate plate mask
        Validator::make($request->all(), $this->getSaveValidationRules($request), $this->getSaveValidationMessages())->validate();
        #endregion

        if ($request->has('id')) {
            $vehicle = Vehicle::findOrFail($request->input('id'));
        } else {
            $vehicle = new Vehicle();
        }
        $vehicle->chassis_number = $request->input('chassis_number');
        $vehicle->brand = $request->input('brand');
        $vehicle->model = $request->input('model');
        $vehicle->year = $request->input('year');
        $vehicle->plate = $request->input('plate');
        $vehicle->save();
        

        $vehicle->characteristics()->delete();
        //saving characteristics
        $all_characteristics = [];
        if($request->input('characteristicsModel') !== null) {
            $all_characteristics[] = $request->input('characteristicsModel');
        }
        if($request->input('characteristicsType') !== null) {
            $all_characteristics[] = $request->input('characteristicsType');
        }
        if($request->input('characteristicsDistance') !== null) {
            $all_characteristics[] = $request->input('characteristicsDistance');
        }

        foreach($all_characteristics as $characteristic) {
            $vehicle->characteristics()->saveMany([
                new VehicleCharacteristic(['characteristic' => $characteristic])
            ]);
        };

        //TODO feedback to user of successful save 
        return redirect()->route('vehicles.index');
    }

    public function delete($id) {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->characteristics()->delete();
        $vehicle->delete();
    }

    private function getSaveValidationRules(Request $request) : array {
        return [
            'chassis_number' => 'required|size:17|unique:vehicles,chassis_number,'.$request->input('id'),
            'brand' => 'required|min:3|max:32',
            'model' => 'required|min:1|max:32',
            'year' => 'required|integer|min:1769',
            'plate' => 'required|size:7|unique:vehicles,plate,'.$request->input('id'),
            'number_of_characteristics' => 'integer|min:2'
        ];
    }

    private function getSaveValidationMessages() : array {
        return [
            'chassis_number.required' => 'Campo obrigatório',
            'chassis_number.size' => 'O número do chassi deve possuir 17 caracteres',
            'chassis_number.unique' => 'O número do chassi já está em uso por outro carro',
            'brand.required' => 'Campo obrigatório',
            'brand.min' => 'A marca deve possuir pelo menos 3 caracteres',
            'brand.max' => 'A marca deve possuir no máximo 32 caracteres',
            'model.required' => 'Campo obrigatório',
            'model.min' => 'O modelo deve possuir pelo menos 3 caracteres',
            'model.max' => 'O modelo deve possuir no máximo 32 caracteres',
            'year.required' => 'Campo obrigatório',
            'year.integer' => 'O ano deve ser em números',
            'year.min' => 'O ano mínimo é de 1769',
            'plate.required' => 'Campo obrigatório',
            'plate.size' => 'A placa deve possuir 7 caracteres',
            'plate.unique' => 'A placa já está em uso por outro carro',
            'number_of_characteristics.integer' => 'Algo deu errado',
            'number_of_characteristics.min' => 'Selecione pelo menos 2 características'
        ];
    }

}
