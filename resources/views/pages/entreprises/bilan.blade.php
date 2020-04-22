@include('templates._assets')
@php
    $totalNatureAPays = [];
    $totalNatureAUEMOA = [];
@endphp;
@foreach ($exercices as $item)
    @if ($input['naturep'] != 'paran')
        @if ($loop->first)
            @php($exercice1 = $item->exercice)
        @endif
        @if ($loop->last)
            @php($exercice2 = $item->exercice)
        @endif
    @endif
    {{--  creer des tableau pour formatter les brutes : totalNature(A,B)Pays, totalNature(A,B)UEMOA--}}
    @php(
        $totalNatureAPays [] = ['exercice' => $item->exercice,
            'total' => $FormatBrut($getBruteNaturePays($dbs,$natureA,$systemeClasse,$typeClasse,$item->exercice))
           ])
    @if($input['localite'] == 'uemoa')
        @php(
            $totalNatureAUEMOA [] = ['exercice' => $item->exercice,
                'total' => $FormatBrut($getBruteNatureUEMOA($natureA,$systemeClasse,$typeClasse,$item->exercice))
               ])
    @endif
@endforeach
<div class="">
    <div class="card">
        <div class="card-body">
            @foreach($infoEntreprises as $infoEntreprise )
                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium">
                    <div class="col-md-6">
                        Numero Registre :
                        <span>{{ html_entity_decode ($infoEntreprise->numRegistre)}}</span>
                    </div>
                    <div class="col-md-6">
                        Secteur :
                        <span>{{ html_entity_decode ($infoEntreprise->secteur)}}</span>
                    </div>
                </div>
                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size: medium">
                    <div class="col-md-6">
                        Raison Sociale :
                        <span>
                        {{ html_entity_decode ($infoEntreprise->entreprise) }}
                    </span>
                    </div>
                    <div class="col-md-6">
                        Activité principal :
                        <span>
                        {{ html_entity_decode ($infoEntreprise->sousecteur) }}
                    </span>
                    </div>
                </div>
                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355AF; font-size: medium">
                    <div class="col-md-6">
                        Adresse :
                        <span>{{ html_entity_decode ($infoEntreprise->adresse)}}</span>
                    </div>
                    <div class="col-md-6">
                        Services :
                        <span>{{html_entity_decode ($infoEntreprise->service) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <table class="table table-condensed" style="font-size: 12px">
            <thead>
            @if($input['naturep'] == 'variation')
                <tr>
                    @if($input['localite'] == 'uemoa')
                        @php ($colspan = 12)
                    @else
                        @php ($colspan = 6)
                    @endif
                    <th style="text-align: right;"></th>
                    <th style="text-align: center; " colspan="{{ $colspan }}">Premier Exercice : {{ $exercice1 }}</th>
                    <th style="text-align: center;background-color: #0000F0" colspan="{{ $colspan }}"> Dernier Exercice
                        : {{ $exercice2 }}</th>
                    <th style="text-align: center;"
                        colspan="@if($input['localite'] == 'uemoa'){{ 6 }} @else {{ 4 }} @endif"> Variation
                    </th>
                </tr>
            @else
                <tr style="font-size: 14px">
                    <th style="text-align: right;">Exrecices :</th>
                    @if($input['localite'] == 'uemoa')
                        @php ($colspan = 18)
                    @else
                        @php ($colspan = 10)
                    @endif
                    @foreach ($exercices as $exo )
                        <th colspan="{{ $colspan }}"
                            style="background-color: #66CCFF; text-align: center; ">{{ $exo->exercice }}</th>
                    @endforeach
                </tr>
            @endif
            <tr style="text-align: center;">
                <th></th>
                @foreach($exercices as $exercice)
                    <th colspan="2">{{$infoEntreprise->sigle }}</th>
                    <th colspan="2" style="background-color: #F3F3F3; ">Pays</th>
                    @if($input['localite'] == 'uemoa')
                        <th colspan="2">UMOA</th>
                    @endif
                    <th colspan="{{ $input['localite'] == 'uemoa' ? 6 : 2 }} "
                        style="background-color: #BCDAC5">Indicateurs
                    </th>
                    @if($input['naturep'] == 'paran')
                        <th colspan="{{ $input['localite'] == 'uemoa' ? 6 : 4 }} "
                            style="background-color: #66CCFF">&Eacute;volution
                        </th>
                    @endif
                @endforeach
                @if($input['naturep'] == 'variation')
                    @if($input['localite'] == 'uemoa')
                        @php ($colspan = 3)
                    @else
                        @php ($colspan = 2)
                    @endif
                    <th colspan="{{ $colspan }}">Evolutions Brute</th>
                    <th colspan="{{ $colspan }}">% Evolution</th>
                @endif
            </tr>
            <tr>
                {{-- Actifs ou charges --}}
                <th style="background-color: #D0FDEB; text-align: left;">
                    @foreach($classesA as $classeA)
                        {{ strtoupper($natureA)  }}
                        @break;
                    @endforeach
                </th>
                @foreach($exercices as $exercice )
                    <th>M. (CFA)</th>
                    <th>% / T.E</th>
                    <th style="background-color: #F3F3F3;">M. (CFA)</th>
                    <th style="background-color: #F3F3F3">% / T.P</th>
                    @if($input['localite'] == 'uemoa')
                        <th>M. (CFA)</th>
                        <th>% / T.U</th>
                    @endif
                    <th style="background-color: #BCDAC5">P.D.M</th>
                    <th style="background-color: #BCDAC5">R.P.E.P</th>
                    @if($input['localite'] == 'uemoa')
                        <th style="background-color: #BCDAC5">PDME % U</th>
                        <th style="background-color: #BCDAC5">R.P.E.U</th>
                        <th style="background-color: #BCDAC5">PDMP % U</th>
                        <th style="background-color: #BCDAC5">R.P.P.U</th>
                    @endif
                    @if($input['naturep'] == 'paran')
                        <th style="background-color: #66CCFF">D.B.E</th>
                        <th style="background-color: #66CCFF">% / A.P</th>
                        <th style="background-color: #66CCFF">D.B.P</th>
                        <th style="background-color: #66CCFF">% / A.P</th>
                        @if($input['localite'] == 'uemoa')
                            <th style="background-color: #66CCFF">D.B.U</th>
                            <th style="background-color: #66CCFF">% / A.P</th>
                        @endif
                    @endif
                @endforeach
                @if($input['naturep'] == 'variation')
                    <th style="background-color: #66CCFF">D.B.E</th>
                    <th style="background-color: #66CCFF">D.B.P</th>
                    @if($input['localite'] == 'uemoa')
                        <th style="background-color: #66CCFF">D.B.U</th>
                    @endif
                    <th style="background-color: #66CCFF">% E</th>
                    <th style="background-color: #66CCFF">% P</th>
                    @if($input['localite'] == 'uemoa')
                        <th style="background-color: #66CCFF">% U</th>
                    @endif
                @endif
            </tr>
            </thead>
            <tbody>
            {{-- Classes --}}
            {{-- Actif Ou Charges --}}
            @foreach($classesA as $classeA)
                <tr style="font-size: 12px; text-align: right;">
                    <th style="text-align: left;">{{ html_entity_decode ($classeA->classe) }} </th>
                    {{-- @php($n = $getNatureClasse($dbs,$classeA->id)) --}}
                    @foreach($exercices as $exercice)
                        {{-- get Previous value --}}
                        @if($loop->first && $input['naturep'] == 'paran')
                            @php($bruteEP = $FormatBrut($getBruteClasse($dbs, $classeA->id, $idE, $exercice->exercice-1)))
                            @php($brutePP = $FormatBrut($getBruteClassePays($dbs, $classeA->id, $exercice->exercice-1)))
                            @php($bruteNP = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice->exercice-1)))
                            @php($bruteNPP =
                            $FormatBrut($getBruteNaturePays($dbs,$natureA,$systemeClasse,$typeClasse,$exercice->exercice-1)))

                            @if($input['localite'] == 'uemoa')
                                @php($bruteUP = $FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice->exercice-1)))
                                @php($bruteNUP =
                                $FormatBrut($getBruteNatureUEMOA($natureA,$systemeClasse,$typeClasse,$exercice->exercice-1)))
                            @endif
                        @endif
                        @foreach($totalNatureAPays as $totalAPays)
                            @continue($totalAPays['exercice'] != $exercice->exercice)
                            <td>{{ $bruteE = (int) ($FormatBrut($getBruteClasse($dbs, $classeA->id, $idE, $exercice->exercice))) }}
                            </td>
                            <td> {{ $pE = (($z = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice->exercice))) != 0 ?  round(($bruteE / $z )*100,2) : 0 )}}</td>
                            <td>{{ $bruteP = (int) $FormatBrut($getBruteClassePays($dbs, $classeA->id, $exercice->exercice)) }}
                            </td>
                            <td>{{ $pP = (($w = $totalAPays['total']) != 0 ?  round(($bruteP / $w)*100,2) : 0)}}</td>
                            @if($input['localite'] == 'uemoa')
                                @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                    @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                    <td>{{ $bruteU = (int) $FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice->exercice)) }}
                                    </td>
                                    <td>{{$pU = (($o = $totalAUEMOA['total']) != 0 ?  round(($bruteU / $o)*100,2):0 ) }}</td>
                                @endforeach
                            @endif
                            <td>{{ $bruteP != 0 ? round(($bruteE / $bruteP)*100,2) :0 }}</td>
                            <td> {{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</td>
                            @if($input['localite'] == 'uemoa')
                                <td>{{ $bruteU != 0 ? round(($bruteE / $bruteU)*100,2) : 0}}</td>
                                <td> {{ $pU != 0 ? round(($pE / $pU)*100,2) : 0 }}</td>
                                <td>{{ $bruteU != 0 ? round(($bruteP / $bruteU)*100,2) : 0 }}</td>
                                <td>{{ $pU != 0 ? round(($pP / $pU)*100,2) : 0}}</td>
                            @endif
                            @if($input['naturep'] == 'paran')
                                <td style="color :{{ ($bruteE - $bruteEP) < 0 ? ' red' : (($bruteE - $bruteEP) == 0 ? 'black' : ' green')  }}">
                                    {{ $diff = $bruteE - $bruteEP }}</td>
                                <td> {{ $bruteEP != 0 ? round(($diff / $bruteEP)*100,2) : 0}}</td>
                                <td style="color :{{ ($bruteP - $brutePP) < 0 ? ' red' : (($bruteP - $brutePP) == 0 ? 'black' : ' green')  }}">
                                    {{ $diffP = $bruteP - $brutePP }}</td>
                                <td>{{ $brutePP != 0 ? round(($diffP / $brutePP)*100,2) : 0}}</td>
                                @if($input['localite'] == 'uemoa')
                                    <td>{{ $diffU = $bruteU - $bruteUP }}</td>
                                    <td style="color :{{ $bruteU - $bruteUP < 0 ? ' red' : ($bruteU - $bruteUP == 0 ? 'black' : ' green') }}">
                                        {{ $bruteUP != 0 ? round(($diffU / $bruteUP)*100,2) : 0}}</td>
                                @endif
                            @endif
                        @endforeach
                        @php($bruteEP = $bruteE)
                        @php($brutePP = $bruteP)
                        @if($input['localite'] == 'uemoa')
                            @php($bruteUP = $bruteU)
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                        <td>{{ $be =( $FormatBrut($getBruteClasse($dbs, $classeA->id, $idE, $exercice2)) - ($e = $FormatBrut($getBruteClasse($dbs,$classeA->id, $idE, $exercice1)))) }}
                        </td>
                        <td>{{ $bp =( $FormatBrut($getBruteClassePays($dbs, $classeA->id, $exercice2)) - ($p = $FormatBrut($getBruteClassePays($dbs,$classeA->id, $exercice1)))) }}
                        </td>
                        @if($input['localite'] == 'uemoa')
                            <td>{{ $bu = ($FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice2)) - ($u = $FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice1)))) }}
                            </td>
                        @endif
                        <td>{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</td>
                        <td>{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</td>
                        @if($input['localite'] == 'uemoa')
                            <td>{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</td>
                        @endif
                    @endif
                </tr>
                {{-- Display SousClasse If Existe and != classe--}}
                @foreach ($SousClassesInClasse($dbs,$classeA->id) as $sousclasse)
                    @continue(strtoupper($sousclasse->classe) == strtoupper($sousclasse->sousclasse))
                    <tr style="text-align: center;">
                        <th style="color: #0000F0;">{{ $sousclasse->sousclasse }}</th>
                        @foreach($exercices as $exercice )
                            @if($loop->first && $input['naturep'] == 'paran')
                                @php($scP = $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE,$exercice->exercice-1)))
                                @php($scpP = $FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice->exercice-1)))
                                @if($input['localite'] == 'uemoa')
                                    @php($scuP = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->id,
                                    $exercice->exercice-1)))
                                @endif
                            @endif
                            @foreach($totalNatureAPays as $totalAPays)
                                @continue($totalAPays['exercice'] != $exercice->exercice)
                                <td>{{ $sc = $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE, $exercice->exercice))}} </td>
                                <td>
                                    {{ $pscE = (($f = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice->exercice))) != 0 ?  round(($sc / $f )*100,3) : 0) }}
                                </td>
                                <td> {{ $scp = $FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice->exercice))}}</td>
                                <td>{{ $pscP = (($g = $totalAPays['total']) != 0 ?  round(($scp / $g)*100,3) : 0 )}}</td>
                                @if($input['localite'] == 'uemoa')
                                    @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                        @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                        <td>{{ $scu = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->id, $exercice->exercice)) }}
                                        </td>
                                        <td>{{ $pscU = (($h = $totalAUEMOA['total']) != 0 ?  round(($scu / $h)*100,3):0 ) }}</td>
                                    @endforeach
                                @endif
                                <td>{{ $scp != 0 ? round(($sc / $scp)*100,3) :0 }}</td>
                                <td>{{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</td>
                                @if($input['localite'] == 'uemoa')
                                    <td>{{ $scu != 0 ? round(($sc / $scu)*100,2) : 0}}</td>
                                    <td> {{ $pscU != 0 ? round(($pscE / $pscU)*100,2) : 0 }}</td>
                                    <td>{{ $scu != 0 ? round(($scp / $scu)*100,2) : 0 }}</td>
                                    <td>{{ $pscU != 0 ? round(($pscP / $pscU)*100,2) : 0}}</td>
                                @endif
                                @if($input['naturep'] == 'paran')
                                    <td style="color: {{ ($diff = ($sc - $scP)) < 0 ? '#e83e8c' : ($diff  == 0 ? 'gray' : '#2bbbad')  }}">
                                        {{ $diff }}</td>
                                    <td> {{ $scP == 0 ? 0 : round(($diff / $scP)*100,2) }}</td>
                                    <td style="color: {{ $scp - $scpP < 0 ? '#e83e8c' : ($scp - $scpP == 0 ? 'gray' : '#2bbbad')  }}">
                                        {{ $diffP = $scp - $scpP }}</td>
                                    <td>{{ $scpP != 0 ? round(($diffP / $scpP)*100,2) : 0}}</td>
                                    @if($input['localite'] == 'uemoa')
                                        <td style="color: {{ $scu - $scuP < 0 ? '#e83e8c' : ($scu - $scuP == 0 ? 'gray' : '#2bbbad')  }}">
                                            {{ $diffU = $scu - $scuP }}</td>
                                        <td>{{ $scuP != 0 ? round(($diffU / $scuP)*100,2) : 0}}</td>
                                    @endif
                                @endif
                            @endforeach
                            @php($scP = $sc)
                            @php($scpP = $scp)
                            @if($input['localite'] == 'uemoa')
                                @php($scuP = $scu)
                            @endif
                        @endforeach
                        @if($input['naturep'] == 'variation')
                            <td>{{ $be = ( $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE, $exercice2)) - ($e = $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE, $exercice1)))) }}
                            </td>
                            <td>{{ $bp = ($FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice2)) - ($p = $FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice1)))) }}
                            </td>
                            @if($input['localite'] == 'uemoa')
                                <td>{{ $bu = ($FormatBrut($getBruteSousClasseUEMOA($sousclasse->id, $exercice2)) - ($u = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->id, $exercice1)))) }}
                                </td>
                            @endif
                            <td>{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</td>
                            <td>{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</td>
                            @if($input['localite'] == 'uemoa')
                                <td>{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</td>
                            @endif
                        @endif
                    </tr>
                    @foreach($RubriquesSousClasse($dbs,$sousclasse->id) as $rubrique)
                        @if(strtoupper($rubrique->rubrique) != strtoupper($rubrique->sousclasse))
                            <tr style="text-align: center;">
                                <th style="text-align: right; color: #2bbbad;">{{ html_entity_decode($rubrique->rubrique) }}</th>
                                @foreach($exercices as $exercice )
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($rP = $FormatBrut($getBruteRubrique($dbs, $rubrique->id, $idE, $exercice->exercice-1)))
                                        @php($rpP = $FormatBrut( $getBruteRubriquePays($dbs, $rubrique->id, $exercice->exercice-1)))
                                        @if($input['localite'] == 'uemoa')
                                            @php($ruP = $FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice->exercice-1)))
                                        @endif
                                    @endif
                                    @foreach($totalNatureAPays as $totalAPays)
                                        @continue($totalAPays['exercice'] != $exercice->exercice)
                                        <td>{{ $r = ($FormatBrut($getBruteRubrique($dbs, $rubrique->id, $idE, $exercice->exercice)))}}
                                        </td>
                                        <td> {{ $prE = (($i = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice->exercice))) != 0 ?  round(($r / $i )*100,2) : 0) }}
                                        </td>
                                        <td>{{ $rp = $FormatBrut($getBruteRubriquePays($dbs, $rubrique->id, $exercice->exercice))}}</td>
                                        <td> {{ $prP = (($j = $totalAPays['total'] )!= 0 ?  round(($rp / $j)*100,3) : 0 )}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                                <td>{{ $ru = $FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice->exercice)) }}</td>
                                                <td>{{ $prU = (($k = $totalAUEMOA['total']) != 0 ?  round(($ru / $k)*100,3):0 ) }}</td>
                                            @endforeach
                                        @endif
                                        <td>{{ $rp != 0 ? round(($r / $rp)*100,3) :0 }}</td>
                                        <td> {{ $prP != 0 ? round(($prE / $prP)*100,2):0 }}</td>
                                        @if($input['localite'] == 'uemoa')
                                            <td>{{ $ru != 0 ? round(($r / $ru)*100,2) : 0}}</td>
                                            <td> {{ $prU != 0 ? round(($prE / $prU)*100,2) : 0 }}</td>
                                            <td>{{ $ru != 0 ? round(($rp / $ru)*100,2) : 0 }}</td>
                                            <td>{{ $prU != 0 ? round(($prP / $prU)*100,2) : 0}}</td>
                                        @endif
                                        @if($input['naturep'] == 'paran')
                                            <td style="color: {{ $r - $rP < 0 ? '#9f105c' : ($r - $rP == 0 ? ' #8d6e63' : '#00acc1')  }}">
                                                {{ $diff = $r - $rP }}</td>
                                            <td> {{ $rP != 0 ? round(($diff / $rP)*100,2) : 0}}</td>
                                            <td style="color: {{ $rp - $rpP < 0 ? '#9f105c' : ($rp - $rpP == 0 ? ' #8d6e63' : '#00acc1')  }}">
                                                {{ $diffP = $rp - $rpP }}</td>
                                            <td>{{ $rpP != 0 ? round(($diffP / $rpP)*100,2) : 0}}</td>
                                            @if($input['localite'] == 'uemoa')
                                                <td>{{ $diffU = $ru - $ruP }}</td>
                                                <td>{{ $ruP != 0 ? round(($diffU / $ruP)*100,2) : 0}}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    @php($rP = $r)
                                    @php($rpP = $rp)
                                    @if($input['localite'] == 'uemoa')
                                        @php($ruP = $ru)
                                    @endif
                                @endforeach
                                @if($input['naturep'] == 'variation')
                                    <td>{{ $be = ($FormatBrut($getBruteRubrique($dbs, $rubrique->id, $idE, $exercice2)) - ($e = $FormatBrut($getBruteRubrique($dbs,$rubrique->id, $idE, $exercice1)))) }}
                                    </td>
                                    <td>{{ $bp = ($FormatBrut($getBruteRubriquePays($dbs, $rubrique->id, $exercice2)) - ($p = $FormatBrut($getBruteRubriquePays($dbs,$rubrique->id, $exercice1)))) }}
                                    </td>
                                    @if($input['localite'] == 'uemoa')
                                        <td>{{ $bu = ($FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice2)) - ($u = $FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice1)))) }}
                                        </td>
                                    @endif
                                    <td>{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</td>
                                    <td>{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</td>
                                    @if($input['localite'] == 'uemoa')
                                        <td>{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                        {{--                        ############################# PRODUIT NET BANCAIRE #########################--}}
                        @if($loop->index == 8 && $natureA == 'res' && $systemeClasse == 'sb')
                            <tr style="text-align: center;">
                                <th style="text-align: right; color: #0b2e13;">{{ "PRODUIT NET BANCAIRE" }}</th>
                                @foreach($exercices as $exercice )
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($pnbEp = $pnbNew($idE, $exercice->exercice-1,$dbs))
                                        @php($pnbPp = $pnbNewPays($exercice->exercice-1,$dbs))
                                        @if($input['localite'] == 'uemoa')
                                            @php($pnbUp = $pnbNewUEMOA($exercice->exercice-1))
                                        @endif
                                    @endif
                                    @foreach($totalNatureAPays as $totalAPays)
                                        @continue($totalAPays['exercice'] != $exercice->exercice)
                                        <td> {{ $pnbE = $pnbNew($idE, $exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        <td> {{ $pnbP = $pnbNewPays($exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                                <td> {{ $pnbU = $pnbNewUEMOA($exercice->exercice) }} </td>
                                                <td>{{'--'}}</td>
                                            @endforeach
                                        @endif
                                        <td> {{ $pnbP == 0 ? 0 : round(($pnbE / $pnbP)*100,2) }}</td>
                                        <td>{{'##'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            <td> {{ $pnbU == 0 ? 0 : round(($pnbE / $pnbU)*100,2) }}</td>
                                            <td> {{'--'}}</td>
                                            <td> {{ $pnbU == 0 ? 0 : round(($pnbP / $pnbU)*100,2) }}</td>
                                            <td>{{'--'}}</td>
                                        @endif
                                        @if($input['naturep'] == 'paran')
                                            <td style="color: {{ ($diff = ($pnbE - $pnbEp)) < 0 ? 'red' : 'green' }}"> {{ $diff }} </td>
                                            <td> {{ $pnbEp == 0 ? 0 : round(($diff/ $pnbEp)*100,2) }}</td>
                                            <td style="color: {{ ($diffP = ($pnbP - $pnbPp)) < 0 ? 'red' : 'green' }}"> {{ $diffP }} </td>
                                            <td> {{ $pnbPp == 0 ? 0 : round(($diffP/ $pnbPp)*100,2) }}</td>
                                            @if($input['localite'] == 'uemoa')
                                                <td style="color: {{ ($diffU = ($pnbU - $pnbUp)) < 0 ? 'red' : 'green' }}"> {{ $diffU }} </td>
                                                <td> {{ $pnbUp == 0 ? 0 : round(($diffU/ $pnbUp)*100,2) }}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    @php($pnbEp = $pnbE)
                                    @php($pnbPp = $pnbP)
                                    @if($input['localite'] == 'uemoa')
                                        @php($pnbUp = $pnbU)
                                    @endif
                                @endforeach
                                @if($input['naturep'] == 'variation')
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endif

                        {{--                        ############################# RESULTAT BRUT D'EXPLOITATION ##################--}}
                        @if($loop->index == 11 && $natureA == 'res' && $systemeClasse == 'sb')
                            <tr style="text-align: center;">
                                <th style="text-align: right; color: #0b2e13;">{{ "RESULTAT BRUT D'EXPLOITATION" }}</th>
                                @foreach($exercices as $exercice )
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($rbeEp = $rbeNew($idE, $exercice->exercice-1,$dbs))
                                        @php($rbePp = $rbeNewPays($exercice->exercice-1,$dbs))
                                        @if($input['localite'] == 'uemoa')
                                            @php($rbeUp = $rbeNewUEMOA($exercice->exercice-1))
                                        @endif
                                    @endif
                                    @foreach($totalNatureAPays as $totalAPays)
                                        @continue($totalAPays['exercice'] != $exercice->exercice)
                                        <td> {{ $rbeE = $rbeNew($idE, $exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        <td> {{ $rbeP = $rbeNewPays($exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                                <td> {{ $rbeU = $rbeNewUEMOA($exercice->exercice) }} </td>
                                                <td>{{'--'}}</td>
                                            @endforeach
                                        @endif
                                        <td> {{ $rbeP == 0 ? 0 : round(($rbeE / $rbeP)*100,2) }}</td>
                                        <td>{{'##'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            <td> {{ $rbeU == 0 ? 0 : round(($rbeE / $rbeU)*100,2) }}</td>
                                            <td> {{'--'}}</td>
                                            <td> {{ $rbeU == 0 ? 0 : round(($rbeP / $rbeU)*100,2) }}</td>
                                            <td>{{'--'}}</td>
                                        @endif
                                        @if($input['naturep'] == 'paran')
                                            <td style="color: {{ ($diff = ($rbeE - $rbeEp)) < 0 ? 'red' : 'green' }}"> {{ $diff }} </td>
                                            <td> {{ $rbeEp == 0 ? 0 : round(($diff/ $rbeEp)*100,2) }}</td>
                                            <td style="color: {{ ($diffP = ($rbeP - $rbePp)) < 0 ? 'red' : 'green' }}"> {{ $diffP }} </td>
                                            <td> {{ $rbePp == 0 ? 0 : round(($diffP/ $rbePp)*100,2) }}</td>
                                            @if($input['localite'] == 'uemoa')
                                                <td style="color: {{ ($diffU = ($rbeU - $rbeUp)) < 0 ? 'red' : 'green' }}"> {{ $diffU }} </td>
                                                <td> {{ $rbeUp == 0 ? 0 : round(($diffU/ $rbeUp)*100,2) }}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    @php($rbeEp = $rbeE)
                                    @php($rbePp = $rbeP)
                                    @if($input['localite'] == 'uemoa')
                                        @php($rbeUp = $rbeU)
                                    @endif
                                @endforeach
                                @if($input['naturep'] == 'variation')
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endif

                        {{--                        ############################## RESULTAT D'EXPLOITATION #######################--}}
                        @if($loop->index == 12 && $natureA == 'res' && $systemeClasse == 'sb')
                            <tr style="text-align: center;">
                                <th style="text-align: right; color: #0b2e13;">{{ "RESULTAT D'EXPLOITATION" }}</th>
                                @foreach($exercices as $exercice )
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($reEp = $reNew($idE, $exercice->exercice-1,$dbs))
                                        @php($rePp = $reNewPays($exercice->exercice-1,$dbs))
                                        @if($input['localite'] == 'uemoa')
                                            @php($reUp = $reNewUEMOA($exercice->exercice-1))
                                        @endif
                                    @endif
                                    @foreach($totalNatureAPays as $totalAPays)
                                        @continue($totalAPays['exercice'] != $exercice->exercice)
                                        <td> {{ $reE = $reNew($idE, $exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        <td> {{ $reP = $reNewPays($exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                                <td> {{ $reU = $reNewUEMOA($exercice->exercice) }} </td>
                                                <td>{{'--'}}</td>
                                            @endforeach
                                        @endif
                                        <td> {{ $reP == 0 ? 0 : round(($reE / $reP)*100,2) }}</td>
                                        <td>{{'##'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            <td> {{ $reU == 0 ? 0 : round(($reE / $reU)*100,2) }}</td>
                                            <td> {{'--'}}</td>
                                            <td> {{ $reU == 0 ? 0 : round(($reP / $reU)*100,2) }}</td>
                                            <td>{{'--'}}</td>
                                        @endif
                                        @if($input['naturep'] == 'paran')
                                            <td style="color: {{ ($diff = ($reE - $reEp)) < 0 ? 'red' : 'green' }}"> {{ $diff }} </td>
                                            <td> {{ $reEp == 0 ? 0 : round(($diff/ $reEp)*100,2) }}</td>
                                            <td style="color: {{ ($diffP = ($reP - $rePp)) < 0 ? 'red' : 'green' }}"> {{ $diffP }} </td>
                                            <td> {{ $rePp == 0 ? 0 : round(($diffP/ $rePp)*100,2) }}</td>
                                            @if($input['localite'] == 'uemoa')
                                                <td style="color: {{ ($diffU = ($reU - $reUp)) < 0 ? 'red' : 'green' }}"> {{ $diffU }} </td>
                                                <td> {{ $reUp == 0 ? 0 : round(($diffU/ $reUp)*100,2) }}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    @php($reEp = $reE)
                                    @php($rePp = $reP)
                                    @if($input['localite'] == 'uemoa')
                                        @php($reUp = $reU)
                                    @endif
                                @endforeach
                                @if($input['naturep'] == 'variation')
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endif

                        {{--                        ############################## RESULTAT AVANT IMPOTS #######################--}}
                        @if($loop->index == 13 && $natureA == 'res' && $systemeClasse == 'sb')
                            <tr style="text-align: center;">
                                <th style="text-align: right; color: #0b2e13;">{{ "RESULTAT AVANT IMPOTS" }}</th>
                                @foreach($exercices as $exercice )
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($raiEp = $raiNew($idE, $exercice->exercice-1,$dbs))
                                        @php($raiPp = $raiNewPays($exercice->exercice-1,$dbs))
                                        @if($input['localite'] == 'uemoa')
                                            @php($raiUp = $raiNewUEMOA($exercice->exercice-1))
                                        @endif
                                    @endif
                                    @foreach($totalNatureAPays as $totalAPays)
                                        @continue($totalAPays['exercice'] != $exercice->exercice)
                                        <td> {{ $raiE = $raiNew($idE, $exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        <td> {{ $raiP = $raiNewPays($exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                                <td> {{ $raiU = $raiNewUEMOA($exercice->exercice) }} </td>
                                                <td>{{'--'}}</td>
                                            @endforeach
                                        @endif
                                        <td> {{ $raiP == 0 ? 0 : round(($raiE / $raiP)*100,2) }}</td>
                                        <td>{{'##'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            <td> {{ $raiU == 0 ? 0 : round(($raiE / $raiU)*100,2) }}</td>
                                            <td> {{'--'}}</td>
                                            <td> {{ $raiU == 0 ? 0 : round(($raiP / $raiU)*100,2) }}</td>
                                            <td>{{'--'}}</td>
                                        @endif
                                        @if($input['naturep'] == 'paran')
                                            <td style="color: {{ ($diff = ($raiE - $raiEp)) < 0 ? 'red' : 'green' }}"> {{ $diff }} </td>
                                            <td> {{ $raiEp == 0 ? 0 : round(($diff/ $raiEp)*100,2) }}</td>
                                            <td style="color: {{ ($diffP = ($raiP - $raiPp)) < 0 ? 'red' : 'green' }}"> {{ $diffP }} </td>
                                            <td> {{ $raiPp == 0 ? 0 : round(($diffP/ $raiPp)*100,2) }}</td>
                                            @if($input['localite'] == 'uemoa')
                                                <td style="color: {{ ($diffU = ($raiU - $raiUp)) < 0 ? 'red' : 'green' }}"> {{ $diffU }} </td>
                                                <td> {{ $raiUp == 0 ? 0 : round(($diffU/ $raiUp)*100,2) }}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    @php($raiEp = $raiE)
                                    @php($raiPp = $raiP)
                                    @if($input['localite'] == 'uemoa')
                                        @php($raiUp = $raiU)
                                    @endif
                                @endforeach
                                @if($input['naturep'] == 'variation')
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endif

                        {{--                        ############################## RESULTAT NET #######################--}}
                        @if($loop->index == 14 && $natureA == 'res' && $systemeClasse == 'sb')
                            <tr style="text-align: center;">
                                <th style="text-align: right; color: #0b2e13;">{{ "RESULTAT NET" }}</th>
                                @foreach($exercices as $exercice )
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($rnEp = $rnNew($idE, $exercice->exercice-1,$dbs))
                                        @php($rnPp = $rnNewPays($exercice->exercice-1,$dbs))
                                        @if($input['localite'] == 'uemoa')
                                            @php($rnUp = $rnNewUEMOA($exercice->exercice-1))
                                        @endif
                                    @endif
                                    @foreach($totalNatureAPays as $totalAPays)
                                        @continue($totalAPays['exercice'] != $exercice->exercice)
                                        <td> {{ $rnE = $rnNew($idE, $exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        <td> {{ $rnP = $rnNewPays($exercice->exercice,$dbs) }} </td>
                                        <td>{{'--'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                @continue($totalAUEMOA['exercice'] != $totalAPays['exercice'])
                                                <td> {{ $rnU = $rnNewUEMOA($exercice->exercice) }} </td>
                                                <td>{{'--'}}</td>
                                            @endforeach
                                        @endif
                                        <td> {{ $rnP == 0 ? 0 : round(($rnE / $rnP)*100,2) }}</td>
                                        <td>{{'##'}}</td>
                                        @if($input['localite'] == 'uemoa')
                                            <td> {{ $rnU == 0 ? 0 : round(($rnE / $rnU)*100,2) }}</td>
                                            <td> {{'--'}}</td>
                                            <td> {{ $rnU == 0 ? 0 : round(($rnP / $rnU)*100,2) }}</td>
                                            <td>{{'--'}}</td>
                                        @endif
                                        @if($input['naturep'] == 'paran')
                                            <td style="color: {{ ($diff = ($rnE - $rnEp)) < 0 ? 'red' : 'green' }}"> {{ $diff }} </td>
                                            <td> {{ $rnEp == 0 ? 0 : round(($diff/ $rnEp)*100,2) }}</td>
                                            <td style="color: {{ ($diffP = ($rnP - $rnPp)) < 0 ? 'red' : 'green' }}"> {{ $diffP }} </td>
                                            <td> {{ $rnPp == 0 ? 0 : round(($diffP/ $rnPp)*100,2) }}</td>
                                            @if($input['localite'] == 'uemoa')
                                                <td style="color: {{ ($diffU = ($rnU - $rnUp)) < 0 ? 'red' : 'green' }}"> {{ $diffU }} </td>
                                                <td> {{ $rnUp == 0 ? 0 : round(($diffU/ $rnUp)*100,2) }}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    @php($rnEp = $rnE)
                                    @php($rnPp = $rnP)
                                    @if($input['localite'] == 'uemoa')
                                        @php($rnUp = $rnU)
                                    @endif
                                @endforeach
                                @if($input['naturep'] == 'variation')
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($input['localite'] == 'uemoa')
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
            @if($natureA != 'res')
                {{-- Total Nature --}}
                <tr style="font-size: 13px;text-align: center; background-color: #00acc1">
                    <th style="text-align: right;">
                        @foreach($classesA as $classeA)
                            {{'TOTAL '. strtoupper($natureA)  }}
                            @break;
                        @endforeach
                    </th>
                    @foreach($exercices as $exercice )
                        @if($loop->first && $input['naturep'] == 'paran')
                            @php($pEP = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice->exercice-1)))
                            @php($bruteNPP = $FormatBrut($getBruteNaturePays($dbs,$natureA,$systemeClasse,$typeClasse,$exercice->exercice-1)))

                            @if($input['localite'] == 'uemoa')
                                @php($bruteNUP =
                                $FormatBrut($getBruteNatureUEMOA($natureA,$systemeClasse,$typeClasse,$exercice->exercice-1)))
                            @endif
                        @endif
                        @foreach($totalNatureAPays as $totalPays)
                            @continue($totalPays['exercice'] != $exercice->exercice)
                            <td> {{ $pE = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice->exercice)) }} </td>
                            <th> {{ 100 }}</th>
                            <th>{{$pP = (int) $totalPays['total']}}</th>
                            <th>{{ 100 }}</th>
                            @if($input['localite'] == 'uemoa')
                                @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                    @continue($totalAUEMOA['exercice'] != $totalPays['exercice'])
                                    <th>{{ $pU = (int) $totalAUEMOA['total'] }}</th>
                                    <th>{{ 100 }}</th>
                                @endforeach
                            @endif
                            <th>{{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</th>
                            <th>{{ '---' }}</th>
                            @if($input['localite'] == 'uemoa')
                                @foreach ($totalNatureAUEMOA as $totalU)
                                    @continue($totalU['exercice'] != $totalPays['exercice'])
                                    <th> {{$pU != 0 ? round(($pE / $pU)*100,2):0 }} </th>
                                    <th> {{'---'}} </th>
                                    <th> {{$pU != 0 ? round(($pP / $pU)*100,2):0 }} </th>
                                    <th> {{'---'}} </th>
                                @endforeach
                            @endif
                            @if($input['naturep'] == 'paran')
                                <th style="color: {{ ($diffE = ($pE - $pEP)) < 0 ? 'red' : 'green' }}">{{ $diffE }}</th>
                                <th> {{ $pEP == 0 ? 0 : round(($diffE / $pEP)*100,2)  }}</th>
                                <th style="color: {{ ($diffP = ($pP - $bruteNPP)) < 0 ? 'red' : 'green' }}">{{ $diffP  }}</th>
                                <th> {{ $pP == 0 ? 0 : round(($diffP / $pP)*100,2)  }} </th>
                                @if($input['localite'] == 'uemoa')
                                    <th style="color: {{ ($diffU = ($pU - $bruteNUP)) < 0 ? 'red' : 'green' }}">{{ $diffU }}</th>
                                    <th> {{ $pU == 0 ? 0 : round(($diffU / $pU)*100,2)  }} </th>
                                @endif
                            @endif
                        @endforeach
                        @php($pEP = $pE)
                        @php($bruteNPP = $pP)
                        @if($input['localite'] == 'uemoa')
                            @php($bruteNUP = $pU)
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                        <td> {{ $ne = ($FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice2)) - ($nep = $FormatBrut($getBruteNature($dbs,$natureA,$systemeClasse,$typeClasse,$idE,$exercice1)))) }}
                        </td>
                        <th> {{ $np = ($FormatBrut($getBruteNaturePays($dbs,$natureA,$systemeClasse,$typeClasse,$exercice2)) - ($npp = $FormatBrut($getBruteNaturePays($dbs,$natureA,$systemeClasse,$typeClasse,$exercice1)))) }}</th>
                        @if($input['localite'] == 'uemoa')
                            <th>{{ $nu = ($FormatBrut($getBruteNatureUEMOA($natureA,$systemeClasse,$typeClasse,$exercice2)) - ($nup = $FormatBrut($getBruteNatureUEMOA($natureA,$systemeClasse,$typeClasse,$exercice1)))) }}</th>
                        @endif
                        <th> {{ $nep != 0 ? round(($ne/$nep)*100,2) : 0 }} </th>
                        <th> {{ $npp != 0 ? round(($np/$npp)*100,2) : 0 }} </th>
                        @if($input['localite'] == 'uemoa')
                            <th> {{ $nup != 0 ? round(($nu/$nup)*100,2) : 0 }} </th>
                        @endif
                    @endif
                </tr>
            @endif
            {{-- Passifs Ou Produits --}}
            </tbody>
        </table>
    </div>
</div>