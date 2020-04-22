@extends('templates.master')
@section('title', 'poste')
@section("header")
@php
if (!$pays)
$pays = 201;
@endphp
<div class="card-header">
  <div class="form-group row ">
    <span class="title_icon">
      <img src={{asset("images/bullet.jpg")}} alt="" title="" />
    </span>
    <span class="title_icon" style="font-family: 'Times New Roman, Times, serif';
                                    font-size: 15px">
      <label>L'INFORMATION L'EGAL SUR LES ENTREPRISES</label>
    </span>
    <div class=" title_icon" style="background-color: powderblue;height: 5%;font-family: 'Times New Roman, Times, serif';
                                    font-size:large">
      <label for="">Analyse Financ&egrave;re</label> :&nbsp;&nbsp;
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 24]) }}">
        <img src={{asset("images/Benin.jpg")}} title="Benin" alt="Benin" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 34]) }}">
        <img src={{asset("images/Burkina.jpg")}} title="Burkina" alt="Burkina" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 48]) }}">
        <img src={{asset("images/Cotedivoire.jpg")}} title="Cotedivoire" alt="Cote d'ivoire" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 81]) }}">
        <img src={{asset("images/Guinneabissao.jpg")}} title="GuineeBissau" alt="Guinnee Bissau" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 134]) }}">
        <img src={{asset("images/Mali.jpg")}} title="Mali" alt="Mali" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 154]) }}">
        <img src={{asset("images/Niger.jpg")}} title="Niger" alt="Niger" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 201]) }}">
        <img src={{asset("images/Senegal.jpg")}} title="Senegal" alt="Senegal" style="" /></a>
    </div>
    <div class="col-sm title_icon"><a href="{{ route('syscoa.poste.bilan.create', ['pays' => 223]) }}">
        <img src={{asset("images/Togo.jpg")}} title="Togo" alt="Togo" style="" /></a>
    </div>
  </div>
</div>
@stop
@section("forms")

<div class="card-body">

  <form action="{{ route('entreprise.poste.bilan.store', ['pays' => $pays]) }}" method="post" target="index">
    @csrf
    <div class="form-group row">
      <div class="col col-md-5">
        <div class="row" style="text-align:center">
          <label for="idEntreprise" style="font-size:medium;color: #0355AF;
                                  font-weight: bold;font-family: 'Times New Roman, Times, serif';">
            <strong>
              Renseigner l'Entreprise 
            </strong>
          </label>
        </div>
        <div class="row">
          <input id="idEntreprise" style="font-family: 'Times New Roman';font-size: 14px;" type="text"
            class="typeahead form-control" placeholder="Selectionner une Entreprise" name="idEntreprise" required
            autocomplete="off">
          <script type="text/javascript">
            var path = "{{ route('autocompleteSyscoa', ['pays' => $pays]) }}";
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
      <div class="col col-md-2"></div>

      <div class="col col-md-5">
        <div class="row" style="text-align:center">
          <label for="poste" style="font-size:medium;color: #0355AF;
                                        font-weight: bold;font-family: 'Times New Roman, Times, serif';">
            <strong>
              Renseigner le Poste 
            </strong>
          </label>
        </div>
        <div class="row">
          <input type="text" name="poste" id="poste" class="form-control" placeholder="Entrez un poste" />
            <div id="posteListe"></div>
          </div>
        </div>
      </div>
      <div class="col col-md-5">
        <div class="form-input">
          
      </div>
      {{-- @include('forms.entreprises._exercices_same') --}}
    </div> <br>
    <div class="form-group row">
      <div class="col col-md-4">
        <div class="row">
          <label for="" style="font-size:medium;color: #0355AF;
                                        font-weight: bold;font-family: 'Times New Roman, Times'">
            <strong>
              Renseigne la nature de la pr&eacute;riodicit&eacute;
            </strong>
          </label>
        </div>
        <div class="row" style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
          <label for="paran"><input type="radio" id="paran" name="naturep" value="paran" checked> Par année</label>
          <label for="variation"><input type="radio" id="variation" name="naturep" value="variation"> Variation</label>
        </div>
      </div>
      <div class="col col-md-4">
        <div class="row" style="text-align:center">
          <label for="poste" style="font-size:medium;color: #0355AF;
                                              font-weight: bold;font-family: 'Times New Roman, Times, serif';">
            <strong>
              Renseigner la Période
            </strong>
          </label>
        </div>
        <div class="row">
          <div class="col" style="font-family: 'Times New Roman, Times, serif';
                                                    font-size: 17px">
            <label for=""> Exercice 1
              <select name="exercice1" class="form-control"
                style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                @if($lignebilans->count() > 0)
                @foreach($lignebilans as $lignebilanNew)
                <option value="{{$lignebilanNew->exercice}}">{{$lignebilanNew->exercice}}</option>
                @endForeach
                @endif
              </select>
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for=""> Exercice 2
              <select name="exercice2" class="form-control"
                style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                @if($lignebilans->count() > 0)
                @foreach($lignebilans as $lignebilanNew)
                <option value="{{$lignebilanNew->exercice}}">{{$lignebilanNew->exercice}}</option>
                @endForeach
                @else
                No Record Found
                @endif
              </select>
            </label>
          </div>
        </div>
      </div>
      <div class="col col-md-4">
        <div class="row">
          <label for="" style="font-size:medium;color: #0355AF;
                                    font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
            <strong>
              Renseigne l'espace communautaire de l'analyse
            </strong>
          </label>
        </div>
        <div class="row" style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
          <label for="pays"><input type="radio" id="pays" name="localite" value="pays" checked>
            @if($pays == 24) {{'BENIN'}} @endif
            @if($pays == 34) {{'BURKINA'}} @endif
            @if($pays == 48) {{'COTE D\'IVOIR'}} @endif
            @if($pays == 81) {{'GUINNE BISSAU'}} @endif
            @if($pays == 134) {{'MALI'}} @endif
            @if($pays == 154) {{'NIGER'}} @endif
            @if($pays == 201) {{'SENEGAL'}} @endif
            @if($pays == 223) {{'TOGO'}} @endif
          </label>&nbsp;&nbsp;&nbsp;
          <label for="group"><input type="radio" id="group" name="localite" value="group">GROUPE</label>&nbsp;&nbsp;&nbsp;
          <label for="uemoa"> <input type="radio" id="uemoa" name="localite" value="uemoa">UMOA</label>
        </div>
      </div>
    </div>
    {{-- @include('forms.syscoas._post_syscoa_form') --}}
    
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

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function(){
    $('#poste').keyup(function(){
      var query = $(this).val();
      if(query != '')
      {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          type: 'POST',
          dataType: 'json',
          data: {query:query, _token:_token},
          url: '/autocomplete-postes-syscoa',
          success:function(data)
          {
            rows = '<ul class="nav nav-bar" style="display:block;position:relative;">';
            $.each(data, function(key, value){
              rows += '<li class="nav-item" ><a class="nav-link" style="color: #000;" href="#">'+ value.rubrique + '</a></li>';
            });
            rows += '</ul>';

            $('#posteListe').fadeIn();
            $('#posteListe').html(rows);
          }
        })
      }
    });

    $(document).on('click', 'li', function(){
      $('#poste').val($(this).text());
      $('#posteListe').fadeOut();
    });
  });

</script>
@stop
@section('content')
<iframe src="" name="index" style="width: 100%; height: 300px; border-width: 0"></iframe>
@stop