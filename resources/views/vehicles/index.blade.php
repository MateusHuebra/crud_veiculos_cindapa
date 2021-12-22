@extends('layouts.app')

@section('content')
<div class="container" style="display: grid;">

    <div>
        <a class="btn btn-secondary mb-3" href="{{ url('/vehicles/create') }}" role="button" style="float: right;">Adicionar Veículo</a>
        
        <div class="input-group mb-3">
            <input id="query_chassis_number" type="text" class="form-control" placeholder="Nº Chassi" aria-label="Nº Chassi" aria-describedby="button-addon2">
            <input id="query_plate" type="text" class="form-control" placeholder="Placa" aria-label="Placa" aria-describedby="button-addon2">
            <select id="query_characteristics" class="form-select" aria-label="Default select example">
                <option selected>Características</option>
                <option value="sport">Esporte</option>
                <option value="classic">Clássico</option>
                <option value="turbo">Turbo</option>
                <option value="economic">Econômico</option>
                <option value="city">Para cidade</option>
                <option value="distant_travels">Para longas viagens</option>
            </select>
            <button onclick="makeQuery()" class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
        </div>
    </div>

    <div class="row justify-content-center">    

        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Nº Chassi</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Ano</th>
                <th scope="col">Placa</th>
                <th scope="col">Características</th>
                <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehicles as $vehicle)
                    <tr>
                        <th scope="row">{{ $vehicle->chassis_number }}</th>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ $vehicle->plate }}</td>
                        <td>
                            @foreach ($vehicle->characteristics as $characteristic)
                                <span class="badge bg-secondary">{{$characteristic->getCharacteristicName()}}</span>
                            @endforeach
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('vehicles.edit', ['id' => $vehicle->id]) }}" role="button">Editar</a>
                            <button
                                type="button" class="btn btn-danger btn-sm"
                                onclick="deleteModal({{json_encode($vehicle)}})"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                            >
                                Deletar
                            </button>
                        </td>
                    </tr> 
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Deletar veículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="deleteModalDescription" class="modal-body">
                Tem certeza que quer deletar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="delete_button" class="btn btn-danger" href="#" role="button">Deletar</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function deleteModal(vehicle) {
    document.getElementById('delete_button').setAttribute('href', '/delete/'+vehicle.id);
    document.getElementById('deleteModalDescription').innerHTML = 'Tem certeza que quer deletar <b>'+vehicle.brand+' '+vehicle.model+'</b> de chassi número <b>'+vehicle.chassis_number+'</b>?';
}

function makeQuery() {
    console.log(document.getElementById('query_chassis_number').value);
    console.log(document.getElementById('query_plate').value);
    console.log(document.getElementById('query_characteristics').value);
    window.location.href='vehicles';
}

</script>
@endsection
