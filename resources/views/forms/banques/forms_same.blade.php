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
      <label for="bilan"><input type="radio" id="bilan" name="document" value="bilan" checked>&nbsp; Bilan</label>
      <label for="compres"><input type="radio" id="compres" name="document" value="compres">&nbsp;Compte Resultat</label>
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
      <label for="variation"><input type="radio" id="variation" name="naturep" value="variation"> Variation</label>
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