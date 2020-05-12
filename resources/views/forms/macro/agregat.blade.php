@extends('templates.master')
@section('title', 'poste')
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
        <form action="{{ route('macro.agregat.store', ['pays' => $pays]) }}" method="post" target="indexmacro">
            @csrf
            <div class="row" style="align-content: center">
                <div class="col col-md-5 offset-1" style="text-align: -moz-center;">
                    <div class="form-group">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif';">{{ "SECTEURS" }}</label>
                        @foreach($secteurs as $secteur)
                            <div class="form-check"
                                 style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                                <input class="form-check-input" type="radio" name="secteur"
                                       id="{{ $secteur->codeSecteur }}" value="{{ $secteur->codeSecteur }}"
                                       onclick="{{ 'show'.$loop->index.'()' }}"
                                        {{ $loop->first ? "checked" : "" }}>
                                <label class="form-check-label" for="{{ $secteur->codeSecteur }}">
                                    {{ html_entity_decode($secteur->secteur) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col col-md-5" style="text-align: -moz-center;">
                    <div class="form-group">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif';">{{ "SOUS-SECTEURS" }}</label>
                        {{--                        ############ sous-secteur secteur reel--}}
                        <div id="sr">
                            @foreach($ss_sr as $sr)
                                <div class="form-check"
                                     style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                                    <input class="form-check-input" type="radio" name="soussecteur"
                                           id="{{ $sr->codeSouSecteur }}" value="{{ $sr->codeSouSecteur }}"
                                            {{ $loop->first ? "checked" : "" }} >
                                    <label class="form-check-label" for="{{ $sr->codeSouSecteur }}">
                                        {{ html_entity_decode($sr->sousecteur) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{-- ############ Secteur monetaire et finaciers--}}
                        <div id="smf">
                            @foreach($ss_smf as $smf)
                                <div class="form-check"
                                     style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                                    <input class="form-check-input" type="radio" name="soussecteur"
                                           id="{{ $smf->codeSouSecteur }}" value="{{ $smf->codeSouSecteur }}">
                                    <label class="form-check-label" for="{{ $smf->codeSouSecteur }}">
                                        {{ html_entity_decode($smf->sousecteur) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{-- ############--}}
                        <div id="sfp">
                            @foreach($ss_sfp as $sfp)
                                <div class="form-check"
                                     style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                                    <input class="form-check-input" type="radio" name="soussecteur"
                                           id="{{ $sfp->codeSouSecteur }}" value="{{ $sfp->codeSouSecteur }}">
                                    <label class="form-check-label" for="{{ $sfp->codeSouSecteur }}">
                                        {{ html_entity_decode($sfp->sousecteur) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{-- ############--}}
                        <div id="se">
                            @foreach($ss_se as $se)
                                <div class="form-check"
                                     style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                                    <input class="form-check-input" type="radio" name="soussecteur"
                                           id="{{ $se->codeSouSecteur }}" value="{{ $se->codeSouSecteur }}">
                                    <label class="form-check-label" for="{{ $se->codeSouSecteur }}">
                                        {{ html_entity_decode($se->sousecteur) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{-- ############--}}
                        <div id="ss">
                            @foreach($ss_ss as $ss)
                                <div class="form-check"
                                     style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                                    <input class="form-check-input" type="radio" name="soussecteur"
                                           id="{{ $ss->codeSouSecteur }}" value="{{ $ss->codeSouSecteur }}">
                                    <label class="form-check-label" for="{{ $ss->codeSouSecteur }}">
                                        {{ html_entity_decode($ss->sousecteur) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col col-md-4 offset-1">
                    <div class="row" style="text-align:center">
                        <label for="" style="font-size: medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                            <strong>
                                Renseigne la Période de l'Analyse
                            </strong>
                        </label>
                    </div>
                    <div class="row"
                         style=" text-align:center; font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                        <div id='form1' style="text-align:center">
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
                </div>
                <div class="col col-md-3">
                    <div class="row" style="text-align:center">
                        <label for="" style="font-size:medium;color: #0355AF;
                                  font-weight: bold;font-family: 'Times New Roman, Times'">
                            <strong>
                                Renseigne la nature de la pr&eacute;riodicit&eacute;
                            </strong>
                        </label>
                    </div>
                    <div class="row"
                         style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'; text-align:center">
                        <label for="paran"><input type="radio" id="paran" name="naturep" value="paran" checked>Par
                            année</label>&nbsp;&nbsp;
                        <label for="variation"><input type="radio" id="variation" name="naturep" value="variation">Par Variation</label>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                            <strong>
                                Renseigne l'espace communautaire de l'analyse
                            </strong>
                        </label>
                    </div>
                    <div class="row"
                         style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                        <label for="pays"><input type="radio" id="pays" name="localite" value="pays" checked>
                            @if($pays == 24) {{'BENIN'}} @endif
                            @if($pays == 34) {{'BURKINA'}} @endif
                            @if($pays == 48) {{'COTE D\'IVOIR'}} @endif
                            @if($pays == 81) {{'GUINNE BISSAU'}} @endif
                            @if($pays == 134) {{'MALI'}} @endif
                            @if($pays == 154) {{'NIGER'}} @endif
                            @if($pays == 201) {{'SENEGAL'}} @endif
                            @if($pays == 223) {{'TOGO'}} @endif
                        </label>&nbsp;&nbsp;
                        <label for="uemoa"> <input type="radio" id="uemoa" name="localite" value="uemoa">&nbspUEMOA</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col col-md-5"></div>
                <div class="col col-md-2">
                    <button type="submit" class="btn btn-primary" name="ajouter"
                            style="font-family: 'Times New Roman, Times, serif';font-size: 17px">
                        <i class="fa fa-check"></i>Trouver</button>
                </div>
            </div>
        </form>
    </div>
@stop
@section('content')
    <iframe src="" name="indexmacro" style="width: 100%; height: 300px; border-width: 2px"></iframe>
@stop
<script>
    function show0() {
        $("div#smf").hide();
        $("div#sfp").hide();
        $("div#se").hide();
        $("div#ss").hide();
        $("div#sr").show();
    }
    function show1() {
        $("div#sr").hide();
        $("div#sfp").hide();
        $("div#se").hide();
        $("div#ss").hide();
        $("div#smf").show();
    }
    function show2() {
        $("div#smf").hide();
        $("div#sr").hide();
        $("div#se").hide();
        $("div#ss").hide();
        $("div#sfp").show();
    }
    function show3() {
        $("div#smf").hide();
        $("div#sfp").hide();
        $("div#sr").hide();
        $("div#ss").hide();
        $("div#se").show();
    }
    function show4() {
        $("div#smf").hide();
        $("div#sfp").hide();
        $("div#se").hide();
        $("div#sr").hide();
        $("div#ss").show();
    }
</script>