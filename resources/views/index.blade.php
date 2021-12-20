@include('imports.header')
@section('header')
@endsection

<div class="container pt-2">
    <div class="d-flex flex-row justify-content-between align-items-center">
        <h1 class="table-title">TABELA BRASILEIRÃO</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#insert-modal">
            Inserir confronto
        </button>
    </div>
    
    <table id="championship-table" class="table">
        <thead>
        <tr>
            <th class="col-md-1"><small>Posição</small></th>
            <th class="col-md-4"></th>
            <th class="col"><small>PTS</small></th>
            <th class="col"><small>J</small></th>
            <th class="col"><small>V</small></th>
            <th class="col"><small>E</small></th>
            <th class="col"><small>D</small></th>
            <th class="col"><small>GP</small></th>
            <th class="col"><small>GC</small></th>
            <th class="col"><small>SG</small></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div class="modal fade" id="insert-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confronto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modal-form">
                        @csrf
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-row gap-1">
                                <div class="d-flex flex-column">
                                    <label>Time da casa</label>
                                    <div class="d-flex flex-row gap-2">
                                        <select id="select_time_casa" style="min-width:300px;" class="form-select" aria-label="Default select example">
                                            <option selected>Time da casa</option>
                                        </select>
                                        <input id="gols_time_casa" oninput="onlyNumbers(this)" class="form-control" type="text" placeholder="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-3 px-3">
                                x
                            </div>
                            <div>
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column">
                                        <label>Visitante</label>
                                        <div class="d-flex flex-row gap-2">
                                            <input id="gols_time_visitante" required oninput="onlyNumbers(this)" class="form-control" type="text" placeholder="0"/>
                                            <select required id="select_time_visitante" style="min-width:300px;" class="form-select" aria-label="Default select example">
                                                <option selected>Visitante</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" onclick="createMatch()" class="btn btn-primary">Salvar confronto</button>
        </div>
            </div>
        </div>
    </div>
</div>

@include('imports.footer')
@section('footer')
@endsection