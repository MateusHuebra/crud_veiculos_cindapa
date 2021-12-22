@csrf

<div class="row mb-3">
    <label for="chassis_number" class="col-md-4 col-form-label text-md-right">{{ __('Número do Chassi') }}</label>

    <div class="col-md-6">
        <input id="chassis_number" type="text" maxlength="17" class="form-control @error('chassis_number') is-invalid @enderror" name="chassis_number" value="{{ old('chassis_number', $vehicle->chassis_number??null) }}" autocomplete="off" required autofocus>

        @error('chassis_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="brand" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

    <div class="col-md-6">
        <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand', $vehicle->brand??null) }}" required>

        @error('brand')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="model" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }}</label>

    <div class="col-md-6">
        <input id="model" type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model', $vehicle->model??null) }}" required>

        @error('model')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="year" class="col-md-4 col-form-label text-md-right">{{ __('Ano') }}</label>

    <div class="col-md-6">
        <input id="year" type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', $vehicle->year??null) }}" required>

        @error('year')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="plate" class="col-md-4 col-form-label text-md-right">{{ __('Placa') }}</label>

    <div class="col-md-6">
        <input id="plate" type="text" class="form-control @error('plate') is-invalid @enderror" name="plate" value="{{ old('plate', $vehicle->plate??null) }}" required>

        @error('plate')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Características') }}</label>
   

    <div class="col-md-6">
        <a href="#" onclick="clearCharacteristics()">Limpar Características</a>
        <input id="number_of_characteristics" type="hidden" class="form-control @error('number_of_characteristics') is-invalid @enderror" name="number_of_characteristics" value="1" required>
        @error('number_of_characteristics')
            <span class="invalid-feedback" style="display: block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="characteristicsModel" id="sport" value="sport" {{ ($vehicle->hasCharacteristic('sport')||old('characteristicsModel')==='sport')?'checked':'' }}>
            <label class="form-check-label" for="sport">
                Esporte
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="characteristicsModel" id="classic" value="classic" {{ ($vehicle->hasCharacteristic('classic')||old('characteristicsModel')==='classic')?'checked':'' }}>
            <label class="form-check-label" for="classic">
                Clássico
            </label>
        </div>

        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="characteristicsType" id="turbo" value="turbo" {{ ($vehicle->hasCharacteristic('turbo')||old('characteristicsType')==='turbo')?'checked':'' }}>
            <label class="form-check-label" for="turbo">
                Turbo
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="characteristicsType" id="economic" value="economic" {{ ($vehicle->hasCharacteristic('economic')||old('characteristicsType')==='economic')?'checked':'' }}>
            <label class="form-check-label" for="economic">
                Econômico
            </label>
        </div>

        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="characteristicsDistance" id="city" value="city" {{ ($vehicle->hasCharacteristic('city')||old('characteristicsDistance')==='city')?'checked':'' }}>
            <label class="form-check-label" for="city">
                Para cidade
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="characteristicsDistance" id="distant_travels" value="distant_travels" {{ ($vehicle->hasCharacteristic('distant_travels')||old('characteristicsDistance')==='distant_travels')?'checked':'' }}>
            <label class="form-check-label" for="distant_travels">
                Para longas viagens
            </label>
        </div>
    </div>
</div>

<div class="row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Cadastrar') }}
        </button>
    </div>
</div>

<script type="text/javascript">
    function clearCharacteristics() {
        document.getElementById("sport").checked = false;
        document.getElementById("classic").checked = false;
        document.getElementById("turbo").checked = false;
        document.getElementById("economic").checked = false;
        document.getElementById("city").checked = false;
        document.getElementById("distant_travels").checked = false;
        
    }
</script>