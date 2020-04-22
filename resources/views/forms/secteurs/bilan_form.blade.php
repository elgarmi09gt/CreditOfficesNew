{{-- # Form for entreprise--}}
<div class="card-body">
    @csrf
    <div class="form-group row">
        <div class="col col-md-4">
            <div class="raw" style="text-align:center">
                <label for="" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif'">
                    <strong>
                        Renseigne le Secteur Activité
                    </strong>
                </label>
            </div>
            <div class="raw">
                <input style="font-family: 'Times New Roman';font-size: 14px;" type="text"
                    class="typeahead form-control" placeholder="Selectionner un Secteur D'Activité" name="idSecteur"
                    required autocomplete="off">
                <script type="text/javascript">
                    var path = "{{ route('autocompleteSector', ['pays' => $pays]) }}";
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
        @include('forms.entreprises._exercices_same')
    </div>
    <br>
    <div class="form-group row">
        <div class="col">
            <div class="raw">
                <label for="" style="font-size: medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                    <strong>
                        Renseigne le document de l'Analyse
                    </strong>
                </label>
            </div>
            <div class="row" style="font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
                <label for="actif"><input type="radio" id="actif" name="document" value="actif" checked>&nbsp;Actif&nbsp;&nbsp;</label>
                <label for="passif"><input type="radio" id="passif" name="document" value="passif">&nbsp;Passif&nbsp;&nbsp;</label>
                <label for="charge" class="old"><input type="radio" id="charge" name="document" value="charge">&nbsp;Charge&nbsp;&nbsp;</label>
                <label for="produit" class="old"><input type="radio" id="produit" name="document" value="produit">&nbsp;Produit&nbsp;&nbsp;</label>
                <label for="compres" class="new"><input type="radio" id="compres" name="document" value="res">&nbsp;Compte Resultat</label>
            </div>
        </div>
        <div class="col">
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
                <label for="variation"><input type="radio" id="variation" name="naturep" value="variation">
                    Variation</label>
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
                </label>
                <label for="group"><input type="radio" id="group" name="localite" value="group">&nbsp; GROUPE</label>
                <label for="uemoa"> <input type="radio" id="uemoa" name="localite" value="uemoa">&nbsp; UMOA</label>
            </div>
        </div>
    </div>
</div>
<script>
    $("div#form2").hide();
    $("label.old").hide();
    $("div#form1").show();
    $("label.new").show();
</script>