@extends('templates.master')
@section('title', 'agregat')
@section("header")
    @php
        if (!$pays)
            $pays = 201;
    @endphp
    <div class="card-header">
        <div class="form-group row" style="margin-bottom: 4px;">
                      <span class="title_icon">
                        <img src={{asset("images/bullet.jpg")}} alt="" title=""/>
                    </span>
            <span class="title_icon" style="font-family: 'Times New Roman, Times, serif';
                                    font-size: 15px">
                        <label>L'INFORMATION L'EGAL SUR LES ENTREPRISES</label>
                    </span>
            <div class=" title_icon" style="background-color: powderblue;height: 5%;font-family: 'Times New Roman, Times, serif';
                                    font-size:large">
                <label for="">Analyse Financ&egrave;re</label> :&nbsp;&nbsp;
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 24]) }}">
                    <img src={{asset("images/Benin.jpg")}} title="Benin" alt="Benin" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 34]) }}">
                    <img src={{asset("images/Burkina.jpg")}} title="Burkina" alt="Burkina" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 48]) }}">
                    <img src={{asset("images/Cotedivoire.jpg")}} title="Cotedivoire" alt="Cote d'ivoire" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 81]) }}">
                    <img src={{asset("images/Guinneabissao.jpg")}} title="GuineeBissau" alt="Guinnee Bissau" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 134]) }}">
                    <img src={{asset("images/Mali.jpg")}} title="Mali" alt="Mali" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 154]) }}">
                    <img src={{asset("images/Niger.jpg")}} title="Niger" alt="Niger" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 201]) }}">
                    <img src={{asset("images/Senegal.jpg")}} title="Senegal" alt="Senegal" style=""/></a>
            </div>
            <div class="col-sm title_icon"><a href="{{ route('macro.agregat.create', ['pays' => 223]) }}">
                    <img src={{asset("images/Togo.jpg")}} title="Togo" alt="Togo" style=""/></a>
            </div>
        </div>
    </div>
@stop
@section("forms")

    <div class="card-body">
        <form action="{{ route('macro.agregat_df.store', ['pays' => $pays]) }}" method="post" target="indexmacro_df">
            @csrf
            <div class="form-group row">
                <div class="col col-md-3 col-sm-3"></div>
                <div class="col col-md-8 col-sm-6">
                    <div class="row">
                        <label for="" style="font-size:medium;color: #0355AF;
                            font-weight: bold;font-family: 'Times New Roman, Times, serif'; text-align: center;">
                            <strong>
                                Renseigne l'Agragat À Analyser
                            </strong>
                        </label>
                    </div>
                    <div class="row">
                        <input style="font-family: 'Times New Roman';font-size: 17px;height: 50%; width: 80%;"
                               type="text" class="typeahead form-control" placeholder="Commencer à taper ..."
                               name="agregat" required autocomplete="off">
                        <script type="text/javascript">
                            var path = "{{ route('autocompleteAgragat', ['pays' => $pays]) }}";
                            $('input.typeahead').typeahead({
                                source: function (query, process) {
                                    return $.get(path, {query: query}, function (data) {
                                        return process(data);
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
                <br>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="row col-md-8 offset-2">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                            <strong>
                                Renseigne le Pays de Référence
                            </strong>
                        </label>
                    </div>
                    <div class="row col-md-8 offset-2"
                         style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                        <select name="ref" id="ref" class="form-control">
                            @foreach($countries as $p)
                                <option value="{{ $p->id }}">{{ strtoupper($p->pays)}}</option>&nbsp;&nbsp;
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="row col-md-10">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                            <strong>
                                Renseigne l'espace communautaire de l'analyse
                            </strong>
                        </label>
                    </div>
                    <div class="row col-md-10 form-check"
                         style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                        @foreach($countries as $p)
                            <label for="{{ strtolower( $p->codePays )}}">
                                <input type="checkbox" id="{{ strtolower( $p->codePays )}}" name="localite[]"
                                       value="{{ $p->id }}" >{{ $p->pays }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="row col-md-8 offset-2">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                            <strong>
                                Renseigne la Période de l'Analyse
                            </strong>
                        </label>
                    </div>
                    <div class="row col-md-8 offset-2"
                         style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                        <label for=""> Exercice 1
                            <select name="exercice1" class="form-control"
                                    style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                                @if($exercices->count() > 0)
                                    @foreach($exercices as $exercice)
                                        <option value="{{$exercice->exercice}}">{{$exercice->exercice}}</option>
                                    @endForeach
                                @endif
                            </select>
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <label for=""> Exercice 2
                            <select name="exercice2" class="form-control"
                                    style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                                @if($exercices->count() > 0)
                                    @foreach($exercices as $exercice)
                                        <option value="{{$exercice->exercice}}">{{$exercice->exercice}}</option>
                                    @endForeach
                                @else
                                    No Record Found
                                @endif
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="row col-md-8">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                            <strong>
                                Renseigne la nature de la pr&eacute;riodicit&eacute;
                            </strong>
                        </label>
                    </div>
                    <div class="row col-md-10 form-check"
                         style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                        <label for="paran"><input type="radio" id="paran" name="naturep" value="paran" checked>Par
                            année</label>&nbsp;&nbsp;
                        <label for="variation"><input type="radio" id="variation" name="naturep" value="variation">Par
                            Variation</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col col-md-5">
                </div>
                <div class="col col-md-2">
                    <button type="submit" class="btn btn-primary" name="ajouter"
                            style="font-family: 'Times New Roman, Times, serif';font-size: 17px">
                        <i class="fa fa-check"></i>Trouver
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop
@section('content')
    <iframe src="" name="indexmacro_df" style="width: 100%; height: 300px; border-width: 2px"></iframe>
@stop
<script>
    function hide_curnt(s) {
        alert(s)
    }
</script>