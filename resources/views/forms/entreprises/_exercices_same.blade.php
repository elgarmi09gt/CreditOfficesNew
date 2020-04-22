<div class="col col-md-6">
    <div class="row" style="text-align:center">
        <label for="" style="font-size: medium;color: #0355AF;
                              font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
            <strong>
                Renseigne la Période de l'Analyse
            </strong>
        </label>
    </div>
    <div class="row"
         style="text-align:center; font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
        <label for="new">
            <input type="radio" id="new" name="annee" onclick="ShowForm1()" value="new" checked>
            Nouveau Systeme (2017 et +)
        </label>&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="old">
            <input type="radio" id="old" name="annee" onclick="ShowForm2()" value="old">
            Ancien Systeme ( < à 2017)
        </label>
    </div>
    <div class="row"
         style="margin-left:50px; text-align:center; font-size: medium; font-weight: bold;font-family: 'Times New Roman, Times, serif;'">
        <div id='form1' style="text-align:center">
            <label for=""> Exercice 1
                <select name="exercice1" class="form-control"
                        style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                    @if($lignebilansNew->count() > 0)
                        @foreach($lignebilansNew as $lignebilanNew)
                            <option value="{{$lignebilanNew->exercice}}">{{$lignebilanNew->exercice}}</option>
                        @endForeach
                    @endif
                </select>
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for=""> Exercice 2
                <select name="exercice2" class="form-control"
                        style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                    @if($lignebilansNew->count() > 0)
                        @foreach($lignebilansNew as $lignebilanNew)
                            <option value="{{$lignebilanNew->exercice}}">{{$lignebilanNew->exercice}}</option>
                        @endForeach
                    @else
                        No Record Found
                    @endif
                </select>
            </label>
        </div>
        <div id='form2' style="text-align:center">
            <label for=""> Exercice 1
                <select name="exercice3" class="form-control"
                        style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                    @if($lignebilans->count() > 0)
                        @foreach($lignebilans as $lignebilan)
                            <option value="{{$lignebilan->exercice}}">{{$lignebilan->exercice}}</option>
                        @endForeach
                    @endif
                </select>
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for=""> Exercice 2
                <select name="exercice4" class="form-control"
                        style="font-family: 'Times New Roman, Times, serif';font-size: 17px;height: 8%">
                    @if($lignebilans->count() > 0)
                        @foreach($lignebilans as $lignebilan)
                            <option value="{{$lignebilan->exercice}}">{{$lignebilan->exercice}}</option>
                        @endForeach
                    @else
                        No Record Found
                    @endif
                </select>
            </label>
            <script type="text/javascript">
                function ShowForm1() {
                    $("label.old").hide();
                    $("div#form2").hide();
                    $("div#form1").show();
                    $("label.new").show();
                }
                function ShowForm2() {
                    $("div#form1").hide();
                    $("label.new").hide();
                    $("div#form2").show();
                    $("label.old").show();
                }
            </script>
        </div>
    </div>
</div>