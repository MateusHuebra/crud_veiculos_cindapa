@extends('layouts.app')

@section('content')
<div class="container" style="display: grid;">

    <div>
        <a class="btn btn-secondary mb-3" href="{{ url('/vehicles/create') }}" role="button" style="float: right;">Adicionar Veículo</a>
        
        <div class="input-group mb-3">
            <input id="query_chassis_number" value="{{$_GET['query_chassis_number']??''}}" type="text" class="form-control" placeholder="Nº Chassi" aria-label="Nº Chassi" aria-describedby="button-addon2">
            <input id="query_plate" type="text" value="{{$_GET['query_plate']??''}}" class="form-control" placeholder="Placa" aria-label="Placa" aria-describedby="button-addon2">
            <select id="query_characteristics" class="form-select" aria-label="Default select example">
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='null')?'selected':''}} value="null">Características</option>
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='sport')?'selected':''}} value="sport">Esporte</option>
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='classic')?'selected':''}} value="classic">Clássico</option>
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='turbo')?'selected':''}} value="turbo">Turbo</option>
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='economic')?'selected':''}} value="economic">Econômico</option>
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='city')?'selected':''}} value="city">Para cidade</option>
                <option {{(isset($_GET['query_characteristics']) && $_GET['query_characteristics']==='distant_travels')?'selected':''}} value="distant_travels">Para longas viagens</option>
            </select>
            <a class="btn btn-outline-secondary" href="{{ route('vehicles.index') }}" role="button">Limpar filtros</a>
            <button onclick="makeQuery()" class="btn btn-outline-secondary" type="button" id="button-addon2">Filtrar</button>
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
                    <tr id="tr_{{$vehicle->id}}">
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
                <button id="delete_button" value="" onclick="deleteVehicle(this.value)" type="button" class="btn btn-danger" data-bs-dismiss="modal">Deletar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function deleteModal(vehicle) {
    document.getElementById('delete_button').setAttribute('value', vehicle.id);
    document.getElementById('deleteModalDescription').innerHTML = 'Tem certeza que quer deletar <b>'+vehicle.brand+' '+vehicle.model+'</b> de chassi número <b>'+vehicle.chassis_number+'</b>?';
}

function makeQuery() {
    $query = [];    
    $query.push('query_chassis_number='+document.getElementById('query_chassis_number').value);
    $query.push('query_plate='+document.getElementById('query_plate').value);
    $query.push('query_characteristics='+document.getElementById('query_characteristics').value);
    window.location.href='vehicles?'+$query.join('&');
}

function deleteVehicle(id) {
        
    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", 'vehicles/delete/'+id);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    xhr.send();
    xhr.onload = function() {
        if (xhr.status != 200) {
            console.log('ERROR');
        } else {
            console.log('DELETED!');
            document.getElementById('tr_'+id).remove();
        }
    };
    xhr.onerror = function() {
        console.log('NO CONNECTION');
    };
}

</script>
@endsection
