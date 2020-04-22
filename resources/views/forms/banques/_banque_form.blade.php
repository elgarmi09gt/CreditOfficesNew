{{-- # Form for entreprise--}}
<div class="card-body">
  @csrf
  <div class="form-group row">
    <div class="col col-md-4">
      <div class="row" style="text-align:center">
        <label for="idEntreprise" style="font-size:medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif';">
          <strong>
            Renseigne la Raison Sociale l'Entreprise 
          </strong>
        </label>
      </div>
      <div class="row">
        <input id="idEntreprise" style="font-family: 'Times New Roman';font-size: 14px;" type="text" class="typeahead form-control"
          placeholder="Selectionner une entreprise" name="idEntreprise" required autocomplete="off">
        <script type="text/javascript">
          var path = "{{ route('autocompleteBanque', ['pays' => $pays]) }}";
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
  @include('forms.entreprises.forms_same')
</div>
<script>
  $("div#form2").hide();
  $("div#form1").show();
</script>