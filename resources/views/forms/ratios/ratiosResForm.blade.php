@extends('templates.master')
@section('title', '(+/-)')
@section("header")
    @php
        if (!$pays)
            $pays = 201;
    @endphp
@stop
@section("forms")
    <div class="card-body">
        <form action="{{ route('ratios_res.store', ['pays' => $pays]) }}" method="post" target="index">
            <div class="card-body">
                @csrf
                <div class="form-group row">
                    <div class="col col-md-5 col-sm-4">
                        <div class="row">
                            <label for="" style="font-size:medium;color: #0355AF;
                            font-weight: bold;font-family: 'Times New Roman, Times, serif'; align-content: center;">
                                <strong>
                                    Renseigne L'Entreprise d'Analyse
                                </strong>
                            </label>
                        </div>
                        <div class="row">
                            <input  style="font-family: 'Times New Roman';font-size: 17px;height: 50%; width: 80%;" type="text" class="typeahead form-control" placeholder="Commencer à écrire le nom de l'entreprise ..." name="idEntreprise" required autocomplete="off">
                            <script type="text/javascript">
                                var path = "{{ route('autocompleteEntreprise', ['pays' => $pays]) }}";
                                $('input.typeahead').typeahead({
                                    source:  function (query, process) {
                                        return $.get(path, { query: query }, function (data) {
                                            return process(data);
                                        });
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col col-md-3 col-sm-2">
                        <div class="row">
                            <label for="" style="font-size:medium;color: #0355AF;
                            font-weight: bold;font-family: 'Times New Roman, Times'">
                                <strong>
                                    Pr&eacute;riodicit&eacute;
                                </strong>
                            </label>
                        </div>
                        <div class="row py-1" style="font-family: 'Times New Roman, Times, serif';font-size: 17px; align-items: center;">
                            <label for=""><input type="radio" name="naturep" value="paran" checked> Par année</label>&nbsp;&nbsp;
                            <label for=""><input type="radio" name="naturep" value="variation">Variation</label>
                        </div>
                    </div>
                    
                    <div class="col col-md-4 col-sm-3 ">
                        <div class="row" style="alignment: right">
                            <label for="" style="font-size:medium;color: #0355AF;
                            font-weight: bold;font-family: 'Times New Roman, Times, serif'; text-align: center; ">
                                <strong>
                                    Renseigne la Période
                                </strong>
                            </label>
                        </div>
                        <div class="row " style="font-family: 'Times New Roman, Times, serif';font-size: 17px;">
                            <div class="form-inline">
                                <div class="form-group mb-2">
                                    <label for="exercice1" >Exercice 1</label>
                                    <select name="exercice1" class="form-control" style="font-family: 'Times New Roman, Times, serif';font-size: 17px;">
                                        @if($lignebilans->count() > 0)
                                            @foreach($lignebilans as $lignebilan)
                                                <option value="{{$lignebilan->exercice}}">{{$lignebilan->exercice}}</option>
                                            @endForeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="inputPassword2" >Exercice 2</label>
                                    <select name="exercice2" class="form-control" style="font-family: 'Times New Roman, Times, serif';font-size: 17px;">
                                        @if($lignebilans->count() > 0)
                                            @foreach($lignebilans as $lignebilan)
                                                <option value="{{$lignebilan->exercice}}">{{$lignebilan->exercice}}</option>
                                            @endForeach
                                        @else
                                            No Record Found
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col col-md-5"></div>
                <div class="col">
                    <button type="submit" class="btn btn-primary" name="ajouter" style="font-family: 'Times New Roman, Times, serif';font-size: 17px">
                        <i class="icon-ok "></i>Trouver</button>
                </div>
            </div>
        </form>

    </div>
@stop
@section('content')
    <iframe src="" name="index" style="width: 100%; height: 555px; border-width: 0"></iframe>
@stop
