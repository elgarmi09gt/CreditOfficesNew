@include('templates._assets') {{-- Include cdn link --}}
@if($input['exercice1'] > $input['exercice2'])
    @php
        $exercice1 = $input['exercice2'];
        $exercice2 = $input['exercice1'];
    @endphp
@else
    @php($exercice1 = $input['exercice1'])
    @php($exercice2 = $input['exercice2'])
@endif
<div class="">
    <div class="card">
        <div class="card-body">
            <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium">
                <div class="col-md-6">
                    SECTEUR D'ACTIVITÉ : <span> {{ $input['secteur'] }}</span>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    POSTE D'ANALYSE: <span> {{ strtoupper($poste->nomRubrique) }}</span>
                </div>
            </div>
            <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium">
                <div class="col-md-6">
                    PERIODE D'ANALYSE :
                    {{  $input['naturep'] == 'variation' ?
                    'VARIATION ENTRE '.$exercice1 .' ET '. $exercice2 :
                    'DE '.$exercice1 .' À '.$exercice2}}
                </div>
                <div class="col-md-6" style="text-align: right;">
                    ETENDU DE L'ANALYSE: {{  $input['localite'] == 'pays' ? strtoupper($Countries->nomPays)  : 'UEMOA'}}
                </div>
            </div>
        </div>
        <table class="table table-condensed" style="font-size: 12px">
            <thead>
            @if($input['naturep'] == 'variation')
                <tr>
                    <th style="text-align: right;"> Exrecices :</th>
                    <th style="text-align: center;background-color: #2bbbad" colspan="6">Premier Exercice : {{ $exercice1 }}</th>
                    <th style="text-align: center;background-color: #8ec5fc" colspan="6"> Dernier Exercice
                        : {{ $exercice2 }}</th>
                    <th style="text-align: center;background-color: #4abde8" colspan="2"> Variation</th>
{{--                    <th style="text-align: center;background-color: #4abde8" colspan="6"> Variation</th>--}}
                </tr>
            @else
                <tr style="font-size: 14px">
                    <th style="text-align: right;">Exrecices :</th>
                    @for ($exo = $exercice1; $exo<=$exercice2; $exo++ )
                        <th colspan="8" style="background-color: #66CCFF; text-align: center; ">{{ $exo }}</th>
{{--                        <th colspan="12" style="background-color: #66CCFF; text-align: center; ">{{ $exo }}</th>--}}
                    @endfor
                </tr>
            @endif
            @if($input['localite'] != 'uemoa')
                <tr style="font-style: italic; font-weight: bolder; font-size: 14px; color: #0000F0; text-align: center;">
                    @if($exercices->count() <= 2)
                        <th style="background-color: #e2ebf0">
                            <ul style="text-align: left;">
                                {{'Legende'}}
                                <li>{!! '<u style="color: #000;">M. (CFA)</u> :  Valeur Du Poste (Entreprise)' !!} </li>
                                <li>{!! '<u style="color: #000;">% / T.E.S.N</u> : / Total Poste De Même Nature (Entreprise)' !!}</li>
                                <li>{!! '<u style="color: #000;">% / T.P</u> : / Valeur Du Poste (Pays)' !!}</li>
                                <li>{!! '<u style="color: #000;">% / T.P.S.N</u> : / Total Poste De Même Naturee (Pays)' !!}</li>
                                <li>{!! '<u style="color: #000;">% / T.P :</u> / Valeur Du Poste (UEMOA)' !!}</li>
                                <li>{!! '<u style="color: #000;">% / T.U.S.N</u> : / Total Poste De Même Nature (UEMOA)' !!}</li>
                            </ul>
                        </th>
                    @else
                        <th></th>
                    @endif
                    {{-- ############################################# --}}
                    @foreach($exercices as $exercice)
                        @foreach($collectCountries as $collectCountrie)
                            @if($exercice->exercice != $collectCountrie->exercice)
                                @continue
                            @else
                                @foreach($collectSameNatureCountries as $collectSameNatureCountrie)
                                    @if($collectSameNatureCountrie->exercice != $collectCountrie->exercice)
                                        @continue
                                    @else
                                        @foreach($collectUEMOA as $cUEMOA)
                                            @if($cUEMOA->exercice != $exercice->exercice)
                                                @continue
                                            @else
                                                @foreach($collectSameNatureUEMOA as $csnUEMOA)
                                                    @if($csnUEMOA->exercice != $cUEMOA->exercice)
                                                        @continue
                                                    @else
                                                        <th colspan="{{ $input['naturep'] == 'variation' ? 6 : 8 }}">
{{--                                                        <th colspan="{{ $input['naturep'] == 'variation' ? 6 : 12 }}">--}}

                                                            <div class="form-group row">
                                                                <div
                                                                    class="col">{{ strtoupper($poste->nomRubrique) .' '. $Countries->nomPays.' : '}}
                                                                    <p style="color: #000000">
                                                                        {{ (int)$collectCountrie->total }}
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col">{{ strtoupper($input['nature']) .' '. $Countries->nomPays.' : '}}
                                                                    <p style="color: #000000">
                                                                        {{ (int)$collectSameNatureCountrie->total }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col">
                                                                    {{ strtoupper($poste->nomRubrique) .' UEMOA : '}}
                                                                    <p style="color: #000000">
                                                                        {{ (int)$cUEMOA->total }}
                                                                    </p>
                                                                </div>
                                                                <div class="col">
                                                                    {{ strtoupper($input['nature']) .' UEMOA : ' }}
                                                                    <p style="color: #000000">
                                                                        {{ (int)$csnUEMOA->total }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                    {{-- ############################################--}}
                    @if($input['naturep'] == 'variation')
                        @foreach($collectCountries as $collectCountrie)
                            @foreach($collectCountries as $collectCountrieP)
                                @if($collectCountrie->exercice <= $collectCountrieP->exercice  )
                                    @continue
                                @else
                                    @foreach($collectUEMOA as $cu)
                                        @foreach($collectUEMOA as $cuP)
                                            @if($cu->exercice <= $cuP->exercice)
                                                @continue
                                            @else
                                                <th colspan="6">
                                                    <div class="form-group row">
                                                        <div
                                                            class="col">{{ 'VARIATION '.strtoupper($input['nature']) .' '. $Countries->nomPays.' : '}}
                                                            <p style="color: {{ $collectCountrie->total < $collectCountrieP->total ? 'red' :(( $collectCountrie->total == $collectCountrieP->total) ? 'black' : 'green') }}">
                                                                {{ (int)($collectCountrie->total - $collectCountrieP->total)}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col ">
                                                            {{ 'VARIATION '.strtoupper($input['nature']) .' UEMOA :'}}
                                                            <p style="color: {{ $cu->total < $cuP->total ? 'red' :(( $cu->total == $cuP->total) ? 'black' : 'green') }}">
                                                                {{ (int)($cu->total - $cuP->total) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </th>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tr>
                <tr style="text-align: center;">
                    <th></th>
                    @foreach($exercices as $exercice)
                        <th style="background-color: #e2ebf0">{{'Poste Val' }}</th>
                        <th colspan="5" style="background-color: #ede7f6">Indicateurs</th>
                        @if($input['naturep'] != 'variation')
                            <th colspan="2">Variarions</th>
{{--                            <th colspan="6">Variarions</th>--}}
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                        <th colspan="2">Variation</th>
{{--                        <th colspan="6">Variation</th>--}}
                    @endif
                </tr>
                <tr>
                    <th></th>
                    @foreach($exercices as $exercice )
                        @if($exercice->exercice < $exercice1 ||$exercice->exercice > $exercice2 )
                            @continue
                        @else
                            <th style="background-color: #e2ebf0">M. (CFA)</th>
                            <th style="background-color: #ede7f6">% / T.E.S.N</th>
                            <th style="background-color: #ede7f6">% / T.P</th>
                            <th style="background-color: #ede7f6">% / T.P.S.N</th>
                            <th style="background-color: #ede7f6">% / T.U</th>
                            <th style="background-color: #ede7f6">% / T.U.S.N</th>
                            @if($input['naturep'] == 'paran')
                                <th>B - B-1</th>
                                <th>/ B-1</th>
                                {{--<th>P- P-1</th>
                                <th>/ P-1</th>
                                <th>U - U-1</th>
                                <th>/ U-1</th>--}}
                            @endif
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                        <th>D.B</th>
                        <th>% E % A.P</th>
                        {{--<th>P- P-1</th>
                        <th>/ P-1</th>
                        <th>U - U-1</th>
                        <th>/ U-1</th>
                    --}}
                    @endif
                </tr>
            @endif
            </thead>
            <tbody>
            {{-- In the UEMOA Display All Entreprise For Either Country And Calculated Results --}}
            @if($input['localite'] == 'uemoa')
                @foreach($Countries as $pay)
                    <tr style="text-align: center; background-color: #3f9ae5" id="{{$pay->nomPays}}">
                        <th colspan="{{ $input['naturep'] == 'variation' ? 14 : ((($exercice2 - $exercice1)+1)*8)+1 }}">
{{--                        <th colspan="{{ $input['naturep'] == 'variation' ? 18 : ((($exercice2 - $exercice1)+1)*12)+1 }}">--}}
                            {{ $pay->nomPays }}
                        </th>
                    </tr>
                    {{-- ENTETE FOR EITHER COUNTRY : DISPLAY COMPLEMENT INFO LIKE POSTE COUNTRY OR UEMOA ... --}}
                    <tr style="font-style: italic; font-weight: bolder; font-size: 14px; color: #0000F0; text-align: center; background-color: #e2ebf0">
                        <th></th>

                        @foreach($exercices as $exercice)
                            @foreach($collectCountries as $collectCountrie)
                                @if($exercice->exercice != $collectCountrie->exercice || $collectCountrie->idPays != $pay->idPays)
                                    @continue
                                @else
                                    @foreach($collectSameNatureCountries as $collectSameNatureCountrie )
                                        @if($collectSameNatureCountrie->exercice != $collectCountrie->exercice || $collectSameNatureCountrie->idPays != $pay->idPays)
                                            @continue
                                        @else
                                            @foreach($collectUEMOA as $cUEMOA)
                                                @if($cUEMOA->exercice != $exercice->exercice)
                                                    @continue
                                                @else
                                                    @foreach($collectSameNatureUEMOA as $csnUEMOA)
                                                        @if($csnUEMOA->exercice != $cUEMOA->exercice)
                                                            @continue
                                                        @else
                                                            <th colspan="{{ $input['naturep'] == 'variation' ? 6 : 8 }}">
{{--                                                            <th colspan="{{ $input['naturep'] == 'variation' ? 6 : 12 }}">--}}
                                                                <div class="form-group row">
                                                                    <div
                                                                        class="col">{{ strtoupper($poste->nomRubrique) .' '. $pay->nomPays.' '.$exercice->exercice.' : '}}
                                                                        <p style="color: #000000">
                                                                            {{ (int)$collectCountrie->total }}
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        class="col">{{ strtoupper($input['nature']) .' '. $pay->nomPays.' '.$exercice->exercice.' : '}}
                                                                        <p style="color: #000000">
                                                                            {{ (int)$collectSameNatureCountrie->total }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col">
                                                                        {{ strtoupper($poste->nomRubrique) .' UEMOA '.$exercice->exercice.' : '}}
                                                                        <p style="color: #000000">
                                                                            {{ (int)$cUEMOA->total }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col">
                                                                        {{ strtoupper($input['nature']) .' UEMOA '.$exercice->exercice.' : ' }}
                                                                        <p style="color: #000000">
                                                                            {{ (int)$csnUEMOA->total }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                        {{-- IF BY VARIATION ADD LAST COLUMN FOR DISPLAYING CALCULATE DIFFERENCE--}}
                        @if($input['naturep'] == 'variation')
                            @foreach($collectCountries as $collectCountrie)
                                @foreach($collectCountries as $collectCountrieP)
                                    @if($collectCountrie->exercice <= $collectCountrieP->exercice || $collectCountrie->idPays != $pay->idPays
                                    || $collectCountrieP->idPays != $pay->idPays)
                                        @continue
                                    @else
                                        @foreach($collectUEMOA as $cu)
                                            @foreach($collectUEMOA as $cuP)
                                                @if($cu->exercice <= $cuP->exercice)
                                                    @continue
                                                @else
                                                    <th colspan="6">
                                                        <div class="form-group row">
                                                            <div
                                                                class="col">{{ 'VARIATION '.strtoupper($input['nature']) .' '. $pay->nomPays.' : '}}
                                                                <p style="color: {{ $collectCountrie->total < $collectCountrieP->total ? 'red' :(( $collectCountrie->total == $collectCountrieP->total) ? 'black' : 'green') }}">
                                                                    {{ (int)($collectCountrie->total - $collectCountrieP->total)}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col ">
                                                                {{ 'VARIATION '.strtoupper($input['nature']) .' UEMOA :'}}
                                                                <p style="color: {{ $cu->total < $cuP->total ? 'red' :(( $cu->total == $cuP->total) ? 'black' : 'green') }}">
                                                                    {{ (int)($cu->total - $cuP->total) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </th>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                    </tr>
                    {{-- DISPLAY SUPLEMENT HEAD FOR ETHEIR COUNTRY --}}
                    <tr style="text-align: center;">
                        <th></th>
                        @foreach($exercices as $exercice)
                            <th style="background-color: #e2ebf0">{{'Poste Val' }}</th>
                            <th colspan="5" style="background-color: #ede7f6; ">Indicateurs</th>
                            @if($input['naturep'] != 'variation')
                                <th colspan="2">Variarions</th>
                                {{--<th colspan="6">Variarions</th>--}}
                            @endif
                        @endforeach
                        @if($input['naturep'] == 'variation')
                            <th colspan="2">Variation</th>
{{--                            <th colspan="6">Variation</th>--}}
                        @endif
                    </tr>
                    <tr>
                        <th>{{ 'Entreprises '.$pay->nomPays }}</th>
                        @foreach($exercices as $exercice )
                            @if($exercice->exercice < $exercice1 ||$exercice->exercice > $exercice2 )
                                @continue
                            @else
                                <th style="background-color: #e2ebf0">M. (CFA)</th>
                                <th style="background-color: #ede7f6">% / T.E.S.N</th>
                                <th style="background-color: #ede7f6">% / T.P</th>
                                <th style="background-color: #ede7f6">% / T.P.S.N</th>
                                <th style="background-color: #ede7f6">% / T.U</th>
                                <th style="background-color: #ede7f6">% / T.U.S.N</th>
                                @if($input['naturep'] == 'paran')
                                    <th>D.B</th>
                                    <th>% E % A.P</th>
                                    {{--<th>P- P-1</th>
                                    <th>/ P-1</th>
                                    <th>U - U-1</th>
                                    <th>/ U-1</th>--}}
                                @endif
                            @endif
                        @endforeach
                        @if($input['naturep'] == 'variation')
                            <th>D.B</th>
                            <th>% E % A.P</th>
                            {{--<th>P- P-1</th>
                            <th>/ P-1</th>
                            <th>U - U-1</th>
                            <th>/ U-1</th>--}}
                        @endif
                    </tr>
                    @foreach($entreprises as $entreprise)
                        @if($entreprise->idPays != $pay->idPays)
                            @continue
                        @else
                            <tr>
                                <th>{{ $exercices->count() > 2 ? $entreprise->Sigle : $entreprise->nomEntreprise }}</th>
                                {{-- ########################################################## --}}
                                @foreach($exercices as $exercice)
                                    @foreach($collectEntreprises as $collectEntreprise)
                                        @if($exercice->exercice != $collectEntreprise->exercice ||
                                        $entreprise->idEntreprise != $collectEntreprise->idEntreprise ||
                                        $entreprise->idPays != $collectEntreprise->idPays)
                                            @continue
                                        @else
                                            @foreach($collectSameNatureEntreprises as $collectSameNatureEntreprise)
                                                @if($collectSameNatureEntreprise->idEntreprise != $collectEntreprise->idEntreprise ||
                                                $collectSameNatureEntreprise->exercice != $exercice->exercice ||
                                                $collectSameNatureEntreprise->idPays != $collectEntreprise->idPays)
                                                    @continue
                                                @else
                                                    @foreach($collectCountries  as $collectCountrie)
                                                        @if($collectCountrie->exercice != $exercice->exercice ||
                                                        $collectCountrie->idPays != $pay->idPays)
                                                            @continue
                                                        @else
                                                            @foreach($collectSameNatureCountries  as $collectSameNatureCountrie)
                                                                @if($collectSameNatureCountrie->exercice != $exercice->exercice
                                                                || $collectSameNatureCountrie->idPays != $collectCountrie->idPays)
                                                                    @continue
                                                                @else
                                                                    @foreach($collectUEMOA  as $cUEMOA)
                                                                        @if($cUEMOA->exercice != $exercice->exercice)
                                                                            @continue
                                                                        @else
                                                                            @foreach($collectSameNatureUEMOA  as $csnUEMOA)
                                                                                @if($csnUEMOA->exercice != $exercice->exercice)
                                                                                    @continue
                                                                                @else
                                                                                    <th style="background-color: #e2ebf0">{{ (int) $collectEntreprise->total }}</th>
                                                                                    <th style="background-color: #ede7f6">
                                                                                        @if($collectSameNatureEntreprise->total != 0)
                                                                                            {{ round(($collectEntreprise->total/$collectSameNatureEntreprise->total)*100,2) }}
                                                                                        @else
                                                                                            {{ 0 }}
                                                                                        @endif
                                                                                    </th>
                                                                                    <th style="background-color: #ede7f6">
                                                                                        @if($collectCountrie->total != 0)
                                                                                            {{ round(($collectEntreprise->total/$collectCountrie->total)*100,2) }}
                                                                                        @else
                                                                                            {{ 0 }}
                                                                                        @endif
                                                                                    </th>
                                                                                    <th style="background-color: #ede7f6">
                                                                                        @if($collectSameNatureCountrie->total != 0)
                                                                                            {{ round(($collectEntreprise->total/$collectSameNatureCountrie->total)*100,2) }}
                                                                                        @else
                                                                                            {{ 0 }}
                                                                                        @endif
                                                                                    </th>
                                                                                    <th style="background-color: #ede7f6">
                                                                                        @if($cUEMOA->total != 0)
                                                                                            {{ round(($collectEntreprise->total/$cUEMOA->total)*100,3) }}
                                                                                        @else
                                                                                            {{ 0 }}
                                                                                        @endif
                                                                                    </th>
                                                                                    <th style="background-color: #ede7f6">
                                                                                        @if($csnUEMOA->total != 0)
                                                                                            {{ round(($collectEntreprise->total/$csnUEMOA->total)*100,4) }}
                                                                                        @else
                                                                                            {{ 0 }}
                                                                                        @endif
                                                                                    </th>
                                                                                    @if($input['naturep'] != 'variation')
                                                                                        @foreach($collectEntreprises as $collectEntrepriseP)
                                                                                            @if($entreprise->idEntreprise != $collectEntrepriseP->idEntreprise ||
                                                                                            $collectEntrepriseP->exercice + 1 != $collectEntreprise->exercice ||
                                                                                            $collectEntrepriseP->idPays != $pay->idPays)
                                                                                                @continue
                                                                                            @else
                                                                                                @foreach($collectSameNatureEntreprises as $collectSameNatureEntrepriseP)
                                                                                                    @if($collectSameNatureEntreprise->idEntreprise != $collectSameNatureEntrepriseP->idEntreprise ||
                                                                                                    $collectSameNatureEntrepriseP->exercice +1 != $collectSameNatureEntreprise->exercice ||
                                                                                                    $collectSameNatureEntrepriseP->idPays != $pay->idPays
                                                                                                    )
                                                                                                        @continue
                                                                                                    @else
                                                                                                        @foreach($collectCountries  as $collectCountrieP)
                                                                                                            @if(
                                                                                                            $collectCountrieP->exercice + 1 != $collectCountrie->exercice ||
                                                                                                            $collectCountrieP->idPays != $pay->idPays
                                                                                                            )
                                                                                                                @continue
                                                                                                            @else
                                                                                                                @foreach($collectSameNatureCountries  as $collectSameNatureCountrieP)
                                                                                                                    @if(
                                                                                                                    $collectSameNatureCountrieP->exercice + 1 != $collectSameNatureCountrie->exercice ||
                                                                                                                    $collectSameNatureCountrieP->idPays != $pay->idPays
                                                                                                                    )
                                                                                                                        @continue
                                                                                                                    @else
                                                                                                                        @foreach($collectUEMOA  as $cUEMOAP)
                                                                                                                            @if(
                                                                                                                            $cUEMOAP->exercice + 1 != $cUEMOA->exercice)
                                                                                                                                @continue
                                                                                                                            @else
                                                                                                                                @foreach($collectSameNatureUEMOA  as $csnUEMOAP)
                                                                                                                                    @if(
                                                                                                                                    $csnUEMOAP->exercice + 1 != $csnUEMOA->exercice)
                                                                                                                                        @continue
                                                                                                                                    @else
                                                                                                                                        <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntreprise->total == $collectEntrepriseP->total) ? 'black' : 'green') }}">
                                                                                                                                            {{ (int) $collectEntreprise->total - $collectEntrepriseP->total }}</th>
                                                                                                                                        <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntrepriseP->total == 0) ? 'black' : 'green') }}">
                                                                                                                                            @if($collectEntrepriseP->total != 0) {{-- (variable === 1) ? 'foo' : ((variable === 2) ? 'bar' : 'baz') --}}
                                                                                                                                            {{ round(($collectEntreprise->total - $collectEntrepriseP->total)/($collectEntrepriseP->total)*100,2) }}
                                                                                                                                            @else
                                                                                                                                                {{ 0 }}
                                                                                                                                            @endif
                                                                                                                                        </th>
                                                                                                                                        {{--<th style="color: {{ $collectCountrie->total < $collectCountrieP->total ? 'red' :(( $collectCountrieP->total == $collectCountrieP->total) ? 'black' : 'green') }}">
                                                                                                                                            {{ (int) $collectCountrie->total - $collectCountrieP->total }}
                                                                                                                                        </th>
                                                                                                                                        <th style="color: {{ $collectCountrie->total < $collectCountrieP->total ? 'red' :(( $collectCountrieP->total == 0) ? 'black' : 'green') }}">
                                                                                                                                            @if($collectCountrieP->total != 0)
                                                                                                                                                {{ round(($collectCountrie->total - $collectCountrieP->total)/($collectCountrieP->total)*100,2) }}
                                                                                                                                            @else
                                                                                                                                                {{ 0 }}
                                                                                                                                            @endif
                                                                                                                                        </th>

                                                                                                                                        <th style="color: {{ $cUEMOA->total < $cUEMOAP->total ? 'red' :(( $cUEMOA->total == $cUEMOAP->total) ? 'black' : 'green') }}">
                                                                                                                                            {{ (int) $cUEMOA->total - $cUEMOAP->total }}
                                                                                                                                        </th>
                                                                                                                                        <th style="color: {{ $cUEMOA->total < $cUEMOAP->total ? 'red' :(( $cUEMOAP->total == 0) ? 'black' : 'green') }}">
                                                                                                                                            @if($cUEMOAP->total != 0)
                                                                                                                                                {{ round(($cUEMOA->total - $cUEMOAP->total)/($cUEMOAP->total)*100,3) }}
                                                                                                                                            @else
                                                                                                                                                {{ 0 }}
                                                                                                                                            @endif
                                                                                                                                        </th>--}}

                                                                                                                                    @endif
                                                                                                                                @endforeach
                                                                                                                            @endif
                                                                                                                        @endforeach
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                                {{-- VARIATION --}}
                                @if($input['naturep'] == 'variation')
                                    @foreach($collectEntreprises as $collectEntreprise)
                                        @if($entreprise->idEntreprise != $collectEntreprise->idEntreprise || $collectEntreprise->idPays != $pay->idPays)
                                            @continue
                                        @else
                                            @foreach($collectEntreprises as $collectEntrepriseP)
                                                @if($collectEntreprise->idEntreprise != $collectEntrepriseP->idEntreprise ||
                                                $collectEntreprise->exercice  <= $collectEntrepriseP->exercice ||
                                                $collectEntrepriseP->idPays != $pay->idPays)
                                                    @continue
                                                @else
                                                    @foreach($collectSameNatureEntreprises as $collectSameNatureEntreprise)
                                                        @if($entreprise->idEntreprise != $collectSameNatureEntreprise->idEntreprise || $collectSameNatureEntreprise->idPays != $pay->idPays)
                                                            @continue
                                                        @else
                                                            @foreach($collectSameNatureEntreprises as $collectSameNatureEntrepriseP)
                                                                @if($collectSameNatureEntreprise->idEntreprise != $collectSameNatureEntrepriseP->idEntreprise ||
                                                                $collectSameNatureEntreprise->exercice  >= $collectSameNatureEntrepriseP->exercice ||
                                                                $collectSameNatureEntrepriseP->idPays != $pay->idPays
                                                                )
                                                                    @continue
                                                                @else
                                                                    <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntreprise->total == $collectEntrepriseP->total) ? 'black' : 'green') }}">
                                                                        {{ (int) $collectEntreprise->total - $collectEntrepriseP->total }}</th>
                                                                    <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntrepriseP->total == 0) ? 'black' : 'green') }}">
                                                                        @if($collectEntrepriseP->total != 0) {{-- (variable === 1) ? 'foo' : ((variable === 2) ? 'bar' : 'baz') --}}
                                                                        {{ round(($collectEntreprise->total - $collectEntrepriseP->total)/($collectEntrepriseP->total)*100,2) }}
                                                                        @else
                                                                            {{ 0 }}
                                                                        @endif
                                                                    </th>

                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endif
                    @endforeach
                @endforeach

                {{-- In the Same Country Display All Entreprise And Calculated Results --}}
                {{--######################################## --}}
            @else
                @foreach($entreprises as $entreprise)
                    <tr>
                        <th>
                            {{ $exercices->count() > 2 ? $entreprise->Sigle : $entreprise->nomEntreprise }}
                        </th>
                        @foreach($exercices as $exercice)
                            @foreach($collectEntreprises as $collectEntreprise)
                                @if($exercice->exercice != $collectEntreprise->exercice ||
                                $entreprise->idEntreprise != $collectEntreprise->idEntreprise)
                                    @continue
                                @else
                                    @foreach($collectSameNatureEntreprises as $collectSameNatureEntreprise)
                                        @if($collectSameNatureEntreprise->idEntreprise != $collectEntreprise->idEntreprise ||
                                        $collectSameNatureEntreprise->exercice != $exercice->exercice)
                                            @continue
                                        @else
                                            @foreach($collectCountries  as $collectCountrie)
                                                @if($collectCountrie->exercice != $exercice->exercice)
                                                    @continue
                                                @else
                                                    @foreach($collectSameNatureCountries  as $collectSameNatureCountrie)
                                                        @if($collectSameNatureCountrie->exercice != $exercice->exercice)
                                                            @continue
                                                        @else
                                                            @foreach($collectUEMOA  as $cUEMOA)
                                                                @if($cUEMOA->exercice != $exercice->exercice)
                                                                    @continue
                                                                @else
                                                                    @foreach($collectSameNatureUEMOA  as $csnUEMOA)
                                                                        @if($csnUEMOA->exercice != $exercice->exercice)
                                                                            @continue
                                                                        @else
                                                                            <td style="background-color: #e2ebf0">
                                                                                {{ (int) $collectEntreprise->total ?? 0 }}
                                                                            </td>
                                                                            <th style="background-color: #ede7f6">
                                                                                @if($collectSameNatureEntreprise->total != 0)
                                                                                    {{ $csnep = round(($collectEntreprise->total/$collectSameNatureEntreprise->total)*100,2) }}
                                                                                @else
                                                                                    {{ $csnep = 0 }}
                                                                                @endif
                                                                            </th>
                                                                            <th style="background-color: #ede7f6">
                                                                                @if($ccp = $collectCountrie->total != 0)
                                                                                    {{ round(($collectEntreprise->total/$collectCountrie->total)*100,2) }}
                                                                                @else
                                                                                    {{ $ccp = 0 }}
                                                                                @endif
                                                                            </th>
                                                                            <th style="background-color: #ede7f6">
                                                                                @if($collectSameNatureCountrie->total != 0)
                                                                                    {{ $csncp = round(($collectEntreprise->total/$collectSameNatureCountrie->total)*100,2) }}
                                                                                @else
                                                                                    {{ $csncp = 0 }}
                                                                                @endif
                                                                            </th>
                                                                            <th style="background-color: #ede7f6">
                                                                                @if($cUEMOA->total != 0)
                                                                                    {{ $cup = round(($collectEntreprise->total/$cUEMOA->total)*100,2) }}
                                                                                @else
                                                                                    {{ $cup = 0 }}
                                                                                @endif
                                                                            </th>
                                                                            <th style="background-color: #ede7f6">
                                                                                @if($csnUEMOA->total != 0)
                                                                                    {{ $csnup = round(($collectEntreprise->total/$csnUEMOA->total)*100,2) }}
                                                                                @else
                                                                                    {{ $csnup = 0 }}
                                                                                @endif
                                                                            </th>
                                                                        {{-- IF BY YEARS IN COUNTRY --}}
                                                                            @if($input['naturep'] != 'variation')
                                                                                @foreach($collectEntreprises as $collectEntrepriseP)
                                                                                    @if($entreprise->idEntreprise != $collectEntrepriseP->idEntreprise ||
                                                                                    $collectEntrepriseP->exercice + 1 != $collectEntreprise->exercice)
                                                                                        @continue
                                                                                    @else
                                                                                        @foreach($collectSameNatureEntreprises as $collectSameNatureEntrepriseP)
                                                                                            @if($collectSameNatureEntreprise->idEntreprise != $collectSameNatureEntrepriseP->idEntreprise ||
                                                                                            $collectSameNatureEntrepriseP->exercice +1 != $collectSameNatureEntreprise->exercice)
                                                                                                @continue
                                                                                            @else
                                                                                                @foreach($collectCountries  as $collectCountrieP)
                                                                                                    @if($collectCountrieP->exercice + 1 != $collectCountrie->exercice)
                                                                                                        @continue
                                                                                                    @else
                                                                                                        @foreach($collectSameNatureCountries  as $collectSameNatureCountrieP)
                                                                                                            @if($collectSameNatureCountrieP->exercice + 1 != $collectSameNatureCountrie->exercice)
                                                                                                                @continue
                                                                                                            @else
                                                                                                                @foreach($collectUEMOA  as $cUEMOAP)
                                                                                                                    @if($cUEMOAP->exercice + 1 != $cUEMOA->exercice)
                                                                                                                        @continue
                                                                                                                    @else
                                                                                                                        @foreach($collectSameNatureUEMOA  as $csnUEMOAP)
                                                                                                                            @if($csnUEMOAP->exercice + 1 != $csnUEMOA->exercice)
                                                                                                                                @continue
                                                                                                                            @else
                                                                                                                                <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntreprise->total == $collectEntrepriseP->total) ? 'black' : 'green') }}">
                                                                                                                                    {{ (int) $collectEntrepriseP->total != 0 ? $collectEntreprise->total - $collectEntrepriseP->total : $collectEntreprise->total }}</th>
                                                                                                                                <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntrepriseP->total == 0) ? 'black' : 'green') }}">
                                                                                                                                    {{ is_long($collectEntrepriseP->total ) && $collectEntrepriseP->total != 0 ? round(($collectEntreprise->total - $collectEntrepriseP->total)/($collectEntrepriseP->total)*100,2) : 0 }}
                                                                                                                                </th>

                                                                                                                                {{--                                                                                                                        <th style="color: {{ $collectCountrie->total < $collectCountrieP->total ? 'red' :(( $collectCountrieP->total == $collectCountrieP->total) ? 'black' : 'green') }}">
                                                                                                                                                                                                                                                            {{ (int) $collectCountrie->total - $collectCountrieP->total }}
                                                                                                                                                                                                                                                        </th>
                                                                                                                                                                                                                                                        <th style="color: {{ $collectCountrie->total < $collectCountrieP->total ? 'red' :(( $collectCountrieP->total == 0) ? 'black' : 'green') }}">
                                                                                                                                                                                                                                                            @if($collectCountrieP->total != 0)
                                                                                                                                                                                                                                                                {{ round(($collectCountrie->total - $collectCountrieP->total)/($collectCountrieP->total)*100,2) }}
                                                                                                                                                                                                                                                            @else
                                                                                                                                                                                                                                                                {{ 0 }}
                                                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                                                        </th>

                                                                                                                                                                                                                                                        <th style="color: {{ $cUEMOA->total < $cUEMOAP->total ? 'red' :(( $cUEMOA->total == $cUEMOAP->total) ? 'black' : 'green') }}">
                                                                                                                                                                                                                                                            {{ (int) $cUEMOA->total - $cUEMOAP->total }}
                                                                                                                                                                                                                                                        </th>
                                                                                                                                                                                                                                                        <th style="color: {{ $cUEMOA->total < $cUEMOAP->total ? 'red' :(( $cUEMOAP->total == 0) ? 'black' : 'green') }}">
                                                                                                                                                                                                                                                            @if($cUEMOAP->total != 0)
                                                                                                                                                                                                                                                                {{ round(($cUEMOA->total - $cUEMOAP->total)/($cUEMOAP->total)*100,3) }}
                                                                                                                                                                                                                                                            @else
                                                                                                                                                                                                                                                                {{ 0 }}
                                                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                                                        </th>
                                                                                                                                --}}
                                                                                                                            @endif
                                                                                                                        @endforeach
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                        {{-- BY VARIATION IN ONE COUNTRY --}}
                        @if($input['naturep'] == 'variation')
                            @foreach($collectEntreprises as $collectEntreprise)
                                @if($entreprise->idEntreprise != $collectEntreprise->idEntreprise)
                                    @continue
                                @else
                                    @foreach($collectEntreprises as $collectEntrepriseP)
                                        @if($entreprise->idEntreprise != $collectEntrepriseP->idEntreprise ||
                                        $collectEntreprise->exercice <= $collectEntrepriseP->exercice ||
                                        $collectEntreprise->idEntreprise != $collectEntrepriseP->idEntreprise)
                                            @continue
                                        @else
                                            @foreach($collectSameNatureEntreprises as $collectSameNatureEntreprise)
                                                @if($entreprise->idEntreprise != $collectSameNatureEntreprise->idEntreprise)
                                                    @continue
                                                @else
                                                    @foreach($collectSameNatureEntreprises as $collectSameNatureEntrepriseP)
                                                        @if($collectSameNatureEntreprise->idEntreprise != $collectSameNatureEntrepriseP->idEntreprise ||
                                                        $collectSameNatureEntrepriseP->exercice >= $collectSameNatureEntreprise->exercice)
                                                            @continue
                                                        @else
                                                            <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntreprise->total == $collectEntrepriseP->total) ? 'black' : 'green') }}">
                                                                {{ (int) $collectEntreprise->total - $collectEntrepriseP->total }}</th>
                                                            <th style="color: {{ $collectEntreprise->total < $collectEntrepriseP->total ? 'red' :(( $collectEntrepriseP->total == 0) ? 'black' : 'green') }}">
                                                                @if($collectEntrepriseP->total != 0) {{-- (variable === 1) ? 'foo' : ((variable === 2) ? 'bar' : 'baz') --}}
                                                                {{ round(($collectEntreprise->total - $collectEntrepriseP->total)/($collectEntrepriseP->total)*100,2) }}
                                                                @else
                                                                    {{ 0 }}
                                                                @endif
                                                            </th>

                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        {{-- PART OF EITHER COUNTRY IN UEMOA FIELD--}}
        @if($input['localite'] == 'uemoa')
            <br>
            <h2 style="text-align: center; color: #0000F0;">{{ 'PART DE CHAQUE PAYS DANS L\'ESPACE UEMOA' }}</h2>
            <table class="table table-condensed" style="font-size: 12px">
                <tr style="text-align: center;">
                    <th>{{'Exercices '}}</th>
                    @foreach($exercices as $exercice)
                        <th colspan="{{ $input['naturep'] == 'variation' ? 6 : 10 }}">{{ $exercice->exercice }}</th>
                    @endforeach
                </tr>
                <tr style="text-align: center;">
                    <th></th>
                    @foreach($exercices as $exercice)
                        <th colspan="2">Brute</th>
                        <th colspan="4">Indicateur</th>
                        @if($input['naturep'] != 'variation')
                            <th colspan="2">D.B</th>
                            <th colspan="2">% Evolution</th>
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                        <th colspan="2">D.B</th>
                        <th colspan="2">% Evolution</th>
                    @endif
                </tr>
                <tr>
                    <th></th>
                    @foreach($exercices as $exercice)
                        <td>P.P</td>
                        <td>P.P.S.N</td>
                        <td>/ P.P.S.N</td>
                        <td>/ P.P.U</td>
                        <td>/ P.P.SN.U</td>
                        <td>PPSP/PPSNU</td>
                        @if($input['naturep'] != 'variation')
                            <td>D.B.E</td>
                            <td>D.B.P</td>
                            <td>% E.E</td>
                            <td>% E.P</td>
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                        <td>D.B.E</td>
                        <td>D.B.P</td>
                        <td>% E.E</td>
                        <td>% E.P</td>
                    @endif
                </tr>
                @foreach($Countries as $pay)
                    <tr>
                        <th>{{ $pay->nomPays }}</th>
                        @foreach($exercices as $exercice)
                            @foreach($collectCountries as $collectCountrie)
                                @if($collectCountrie->exercice != $exercice->exercice || $collectCountrie->idPays != $pay->idPays)
                                    @continue
                                @else
                                    @foreach($collectSameNatureCountries as $collectSameCountrie)
                                        @if($collectSameCountrie->exercice != $collectCountrie->exercice || $collectSameCountrie->idPays != $collectCountrie->idPays)
                                            @continue
                                        @else
                                            @foreach($collectUEMOA as $cUEMOA)
                                                @if($cUEMOA->exercice != $exercice->exercice)
                                                    @continue
                                                @else
                                                    @foreach($collectSameNatureUEMOA as $csnUEMOA)
                                                        @if($csnUEMOA->exercice != $exercice->exercice)
                                                            @continue
                                                        @else
                                                            <th>{{ (int)$collectCountrie->total }}</th>
                                                            <th>{{ (int) $collectSameCountrie->total }}</th>
                                                            <th>
                                                                @if($collectSameCountrie->total != 0)
                                                                    {{ round(($collectCountrie->total / $collectSameCountrie->total)*100,3) }}
                                                                @else
                                                                    {{ 0 }}
                                                                @endif
                                                            </th>
                                                            <th>
                                                                @if($cUEMOA->total != 0)
                                                                    {{ round(($collectCountrie->total / $cUEMOA->total)*100,3) }}
                                                                @else
                                                                    {{ 0 }}
                                                                @endif
                                                            </th>
                                                            <th>
                                                                @if($csnUEMOA->total != 0)
                                                                    {{ round(($collectCountrie->total / $csnUEMOA->total)*100,3) }}
                                                                @else
                                                                    {{ 0 }}
                                                                @endif
                                                            </th>
                                                            <th>
                                                                @if($csnUEMOA->total != 0)
                                                                    {{ round(($collectSameCountrie->total / $csnUEMOA->total)*100,3) }}
                                                                @else
                                                                    {{ 0 }}
                                                                @endif
                                                            </th>
                                                            @if($input['naturep'] != 'variation')
                                                                @foreach($collectCountries as $cc)
                                                                    @if($collectCountrie->exercice != $cc->exercice + 1 || $cc->idPays != $pay->idPays)
                                                                        @continue
                                                                    @else
                                                                        @foreach($collectSameNatureCountries as $csc)
                                                                            @if($collectSameCountrie->exercice != $csc->exercice + 1 || $csc->idPays != $pay->idPays)
                                                                                @continue
                                                                            @else
                                                                                <th style="color: {{ $collectCountrie->total - $cc->total < 0 ? 'red' : 'green' }}">
                                                                                    {{ (int) ($collectCountrie->total - $cc->total) }}</th>
                                                                                <th style="color: {{ $collectSameCountrie->total - $csc->total < 0 ? 'red' : 'green' }}">
                                                                                    {{ (int) ($collectSameCountrie->total - $csc->total) }}</th>
                                                                                <th style="color: {{ $collectCountrie->total - $cc->total < 0 ? 'red' : 'green' }}">
                                                                                    @if($cc->total != 0)
                                                                                        {{ round((($collectCountrie->total - $cc->total) / $cc->total)*100,3) }}
                                                                                    @else
                                                                                        {{ 0 }}
                                                                                    @endif
                                                                                </th>
                                                                                <th style="color: {{ $collectSameCountrie->total - $csc->total < 0 ? 'red' : 'green' }}">
                                                                                    @if($csc->total != 0)
                                                                                        {{ round((($collectSameCountrie->total - $csc->total) /$csc->total )*100,3) }}
                                                                                    @else
                                                                                        {{ 0 }}
                                                                                    @endif
                                                                                </th>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                        @if($input['naturep'] == 'variation')
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
