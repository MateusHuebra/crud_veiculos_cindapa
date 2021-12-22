@extends('layouts.app')

@section('content')
<div class="container" style="display: grid;">

    <div>
        <a class="btn btn-secondary" href="{{ url('/vehicles') }}" role="button">Cancelar e voltar</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar veículo') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('vehicles.save') }}">
                        <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id', $vehicle->id??null) }}" required>
                        @include('vehicles.form')
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
