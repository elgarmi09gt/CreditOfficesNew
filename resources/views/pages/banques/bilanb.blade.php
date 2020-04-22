@include('templates._assets')
@foreach ($exercices as $item)
@if ($loop->first)
@php
$exercice1 = $item->exercice;
@endphp
@endif
@if ($loop->last)
@php
$exercice2 = $item->exercice;
@endphp
@endif
@endforeach
<div class="">
    <div class="card">
        <div class="card-body">
            @foreach($infoEntreprises as $infoEntreprise )
            <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium">
                <div class="col-md-6">
                    Numero Registre :
                    <span>{{$infoEntreprise->numRegistre}}</span>
                </div>
                <div class="col-md-6">
                    Secteur :
                    <span>{{$infoEntreprise->secteur}}</span>
                </div>
            </div>
            <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size: medium">
                <div class="col-md-6">
                    Raison Sociale :
                    <span>
                        {{ $infoEntreprise->entreprise }}
                    </span>
                </div>
                <div class="col-md-6">
                    Activité principal :
                    <span>
                        {{ $infoEntreprise->sousecteur }}
                    </span>
                </div>
            </div>
            <div class="form-row" style="font-family: 'Times New Roman'; color: #0355AF; font-size: medium">
                <div class="col-md-6">
                    Adresse :
                    <span>{{$infoEntreprise->adresse}}</span>
                </div>
                <div class="col-md-6">
                    Services :
                    <span>{{$infoEntreprise->service}}</span>
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
                    <th style="text-align: right;"> </th>
                    <th style="text-align: center; " colspan="{{ $colspan }}">Premier Exercice : {{ $exercice1 }}</th>
                    <th style="text-align: center;background-color: #0000F0" colspan="{{ $colspan }}"> Dernier Exercice
                        : {{ $exercice2 }}</th>
                    <th style="text-align: center;"
                        colspan="@if($input['localite'] == 'uemoa'){{ 6 }} @else {{ 4 }} @endif"> Variation</th>
                </tr>
                @else
                <tr style="font-size: 14px">
                    <th style="text-align: right;">Exrecices : </th>
                    @if($input['localite'] == 'uemoa')
                    @php ($colspan = 18)
                    @else
                    @php ($colspan = 10)
                    @endif
                    @for ($exo = $exercice1; $exo<=$exercice2; $exo++ ) <th colspan="{{ $colspan }}"
                        style="background-color: #66CCFF; text-align: center; ">{{ $exo }}</th>
                    @endfor
                </tr>
                @endif
                <tr style="text-align: center;">
                    <th> </th>
                    @foreach($exercices as $exercice)
                    <th colspan="2">{{$infoEntreprise->sigle }}</th>
                    <th colspan="2" style="background-color: #F3F3F3; ">Pays</th>
                    @if($input['localite'] == 'uemoa')
                    <th colspan="2">UMOA</th>
                    @endif
                    <th colspan="@if($input['localite'] == 'uemoa') {{ 6 }} @else {{ 2 }} @endif"
                        style="background-color: #BCDAC5">Indicateurs</th>
                    @if($input['naturep'] == 'paran')
                    <th colspan="@if($input['localite'] == 'uemoa') {{ 6 }} @else {{ 4 }} @endif"
                        style="background-color: #66CCFF">&Eacute;volution </th>
                    @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                    @if($input['localite'] == 'uemoa')
                    @php ($colspan = 3)
                    @else
                    @php ($colspan = 2)
                    @endif
                    <th colspan="{{ $colspan }}">Ecart des Evolutions</th>
                    <th colspan="{{ $colspan }}">Rapport des Evolution</th>
                    @endif
                </tr>
                <tr>
                    {{-- Actifs ou charges --}}
                    <th style="background-color: #D0FDEB; text-align: left;">
                        @foreach($classesA as $classeA)
                        {{ strtoupper($classeA->nature)  }}
                        @break;
                        @endforeach
                    </th>
                    @foreach($exercices as $exercice )
                    @if($exercice->exercice < $exercice1 ||$exercice->exercice > $exercice2 )
                        @continue
                        @else
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
                        @endif
                        @endforeach
                        @if($input['naturep'] == 'variation')
                        <th style="background-color: #66CCFF">% / E</th>
                        <th style="background-color: #66CCFF">% / P</th>
                        @if($input['localite'] == 'uemoa')
                        <th style="background-color: #66CCFF">% / U</th>
                        @endif
                        <th style="background-color: #66CCFF">% / E</th>
                        <th style="background-color: #66CCFF">% / P</th>
                        @if($input['localite'] == 'uemoa')
                        <th style="background-color: #66CCFF">% / U</th>
                        @endif
                        @endif
                </tr>
            </thead>
            <tbody>
                {{-- Classes --}}
                {{-- Actif Ou Charges --}}
                @foreach($classesA as $classeA)
                <tr style="font-size: 12px; ">
                    <th style="text-align: left;">{{ $classeA->classe }}
                        {{--@if($SousClassesInClasse($classeA->id)->count() >1)
                        <a href="#" title="Plus De Details">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endif--}}
                    </th>
                    @foreach($exercices as $exercice)
                        @if($loop->first && $input['naturep'] == 'paran' && $exercice1 > 2000)
                            @php($bruteEP = $FormatBrut($getBruteClasse($dbs, $classeA->id, $idE, $exercice->exercice-1)))
                            @php($brutePP = $FormatBrut($getBruteClassePays($dbs, $classeA->id, $exercice->exercice-1)))
                            @if($input['localite'] == 'uemoa')
                                @php($bruteUP = $FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice->exercice-1)))
                            @endif
                        @endif
                        @foreach($totalNatureA as $totalA)
                            @continue($exercice->exercice != $totalA->exercice)
                            @foreach($totalNatureAPays as $totalAPays)
                                @continue($totalAPays->exercice != $totalA->exercice)
                                <td>{{ $bruteE = (int) ($FormatBrut($getBruteClasse($dbs, $classeA->id, $idE, $exercice->exercice))) }}
                                </td>
                                <td> {{ $FormatBrut($totalA) != 0 ? $pE = round(($bruteE / $totalA->total)*100,2) : 0 }}</td>
                                <td>{{ $bruteP = (int) $FormatBrut($getBruteClassePays($dbs, $classeA->id, $exercice->exercice)) }}
                                </td>
                                <td>{{ $FormatBrut($totalAPays) != 0 ? $pP = round(($bruteP / $totalAPays->total)*100,2) : 0}}</td>
                                @if($input['localite'] == 'uemoa')
                                    @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                        @continue($totalAUEMOA->exercice != $totalAPays->exercice)
                                        <td>{{ $bruteU = (int) $FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice->exercice)) }}
                                        </td>
                                        <td>{{$FormatBrut($totalAUEMOA) != 0 ? $pU = round(($bruteU / $totalAUEMOA->total)*100,2):0  }}</td>
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
                                @if($input['naturep'] == 'paran' && $exercice1 > 2000)
                                    <td
                                        style="color :{{ ($bruteE - $bruteEP) < 0 ? ' red' : (($bruteE - $bruteEP) == 0 ? 'black' : ' green')  }}">
                                        {{ $diff = $bruteE - $bruteEP }}</td>
                                    <td> {{ $bruteEP != 0 ? round(($diff / $bruteEP)*100,2) : 0}}</td>
                                    <td
                                        style="color :{{ ($bruteP - $brutePP) < 0 ? ' red' : (($bruteP - $brutePP) == 0 ? 'black' : ' green')  }}">
                                        {{ $diffP = $bruteP - $brutePP }}</td>
                                    <td>{{ $brutePP != 0 ? round(($diffP / $brutePP)*100,2) : 0}}</td>
                                    @if($input['localite'] == 'uemoa')
                                        <td>{{ $diffU = $bruteU - $bruteUP }}</td>
                                        <td
                                            style="color :{{ $bruteU - $bruteUP < 0 ? ' red' : ($bruteU - $bruteUP == 0 ? 'black' : ' green') }}">
                                            {{ $bruteUP != 0 ? round(($diffU / $bruteUP)*100,2) : 0}}</td>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                        @php($bruteEP = $bruteE)
                        @php($brutePP = $bruteP)
                        @if($input['localite'] == 'uemoa')
                            @php($bruteUP = $bruteU)
                        @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                    <td>{{ $be =( $FormatBrut($getBruteClasse($dbs, $classeA->id, $idE, $exercice2)) - ($e = $FormatBrut($dbs,  $getBruteClasse($classeA->id, $idE, $exercice1)->total))) }}
                    </td>
                    <td>{{ $bp =( $FormatBrut($getBruteClassePays($dbs, $classeA->id, $exercice2)) - ($p = $FormatBrut($dbs, $getBruteClassePays($classeA->id, $exercice1)->total))) }}
                    </td>
                    @if($input['localite'] == 'uemoa')
                    <td>{{ $bu = ($FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice2)) - ($u = $FormatBrut($getBruteClasseUEMOA($classeA->id, $exercice1)->total))) }}
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
                @php($sousclasses = $SousClassesInClasse($dbs,$classeA->id))
                @continue((strtoupper($sousclasses[0]->classe) == strtoupper($sousclasses[0]->sousclasse)) &&
                ($sousclasses->count() == 1))
                @foreach($sousclasses as $sousclasse)
                <tr style="text-align: center;">
                    <th style="color: #0000F0;">{{ $sousclasse->sousclasse }}</th>
                    @foreach($exercices as $exercice )
                    {{-- @php($res = $getBruteSousClasse($sousclasse->id, $idE, $exercice->exercice))
                           @php($resp = $getBruteSousClassePays($sousclasse->id, $exercice->exercice))
                           @if($input['localite'] == 'uemoa')
                               @php($resu = $getBruteSousClasseUEMOA($sousclasse->id, $exercice->exercice))
                           @endif--}}
                    @if($loop->first && $input['naturep'] == 'paran' && $exercice1 > 2000)
                    @php($scP = $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE,
                    $exercice->exercice-1)))
                    @php($scpP = $FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice->exercice-1)))
                    @if($input['localite'] == 'uemoa')
                    @php($scuP = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->id,
                    $exercice->exercice-1)))
                    @endif
                    @endif
                    @foreach($totalNatureA as $totalA)
                    @continue($exercice->exercice != $totalA->exercice)
                    @foreach($totalNatureAPays as $totalAPays)
                    @continue($totalAPays->exercice != $totalA->exercice)
                    <td>{{ $sc = $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE, $exercice->exercice))}}
                    </td>
                    <td>{{ $FormatBrut($totalA) != 0 ? $pE = round(($sc / $totalA->total)*100,3) : 0 }}</td>
                    <td>
                        {{--@php($getBruteSousClassePays($sousclasse->id, $exercice->exercice))--}}
                        {{ $scp = $FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice->exercice))}}
                    </td>
                    <td>{{ $FormatBrut($totalAPays) != 0 ? $pP = round(($scp / $totalAPays->total)*100,3) : 0 }}</td>
                    @if($input['localite'] == 'uemoa')
                    @foreach($totalNatureAUEMOA as $totalAUEMOA)
                    @continue($totalAUEMOA->exercice != $totalAPays->exercice)
                    <td>{{ $scu = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->id, $exercice->exercice)) }}
                    </td>
                    <td>{{$FormatBrut($totalAUEMOA) != 0 ? $pU = round(($scu / $totalAUEMOA->total)*100,3):0  }}</td>
                    @endforeach
                    @endif
                    <td>{{ $scp != 0 ? round(($sc / $scp)*100,3) :0 }}</td>
                    <td>{{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</td>

                    @if($input['localite'] == 'uemoa')
                    <td>{{ $scu != 0 ? round(($sc / $scu)*100,2) : 0}}</td>
                    <td> {{ $pU != 0 ? round(($pE / $pU)*100,2) : 0 }}</td>
                    <td>{{ $scu != 0 ? round(($scp / $scu)*100,2) : 0 }}</td>
                    <td>{{ $pU != 0 ? round(($pP / $pU)*100,2) : 0}}</td>
                    @endif
                    @if($input['naturep'] == 'paran')
                    <td style="color: {{ $sc - $scP < 0 ? '#e83e8c' : ($sc - $scP == 0 ? 'gray' : '#2bbbad')  }}">
                        {{ $diff = $sc - $scP }}</td>
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
                    @endforeach
                    @php($scP = $sc)
                    @php($scpP = $scp)
                    @if($input['localite'] == 'uemoa')
                    @php($scuP = $scu)
                    @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                    <td>{{ $be = ( $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE, $exercice2)) - ($e = $FormatBrut($getBruteSousClasse($dbs, $sousclasse->id, $idE, $exercice1)->total))) }}
                    </td>
                    <td>{{ $bp = ($FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice2)) - ($p = $FormatBrut($getBruteSousClassePays($dbs, $sousclasse->id, $exercice1)->total))) }}
                    </td>
                    @if($input['localite'] == 'uemoa')
                    <td>{{ $bu = ($FormatBrut($getBruteSousClasseUEMOA($sousclasse->id, $exercice2)) - ($u = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->id, $exercice1)->total))) }}
                    </td>
                    @endif
                    <td>{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</td>
                    <td>{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</td>
                    @if($input['localite'] == 'uemoa')
                    <td>{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</td>
                    @endif
                    @endif
                </tr>
                {{-- Display Rubriques if Existe or != sousclasse
                   @php($rubriques = $RubriquesSousClasse($sousclasse->id))--}}
                @foreach($RubriquesSousClasse($dbs,$sousclasse->id) as $rubrique)
                @if(strtoupper($rubrique->rubrique) != strtoupper($rubrique->sousclasse))
                <tr style="text-align: center;">
                    <th style="text-align: right; color: #2bbbad;">{{ $rubrique->rubrique }}</th>
                    @foreach($exercices as $exercice )

                    @if($loop->first && $input['naturep'] == 'paran' && $exercice1 > 2000)
                    @php($rP = $FormatBrut($getBruteRubrique($dbs, $rubrique->id, $idE, $exercice->exercice-1)))
                    @php($rpP = $FormatBrut( $getBruteRubriquePays($dbs, $rubrique->id, $exercice->exercice-1)))
                    @if($input['localite'] == 'uemoa')
                    @php($ruP = $FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice->exercice-1)))
                    @endif
                    @endif
                    @foreach($totalNatureA as $totalA)
                    @continue($exercice->exercice != $totalA->exercice)
                    @foreach($totalNatureAPays as $totalAPays)
                    @continue($totalAPays->exercice != $totalA->exercice)
                    <td>{{ $r = ($FormatBrut($getBruteRubrique($dbs, $rubrique->id, $idE, $exercice->exercice)))}}
                    </td>
                    <td>{{ $FormatBrut($totalA) != 0 ? $pE = round(($r / $totalA->total)*100,3) : 0 }}</td>
                    <td>{{ $rp = $FormatBrut($getBruteRubriquePays($dbs, $rubrique->id, $exercice->exercice))}}</td>
                    <td> {{ $FormatBrut($totalAPays) != 0 ? $pP = round(($rp / $totalAPays->total)*100,3) : 0 }}</td>
                    @if($input['localite'] == 'uemoa')
                    @foreach($totalNatureAUEMOA as $totalAUEMOA)
                    @continue($totalAUEMOA->exercice != $totalAPays->exercice)
                    <td>{{ $ru = $FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice->exercice)) }}</td>
                    <td>{{$FormatBrut($totalAUEMOA) != 0 ? $pU = round(($ru / $totalAUEMOA->total)*100,3):0  }}</td>
                    @endforeach
                    @endif
                    <td>{{ $rp != 0 ? round(($r / $rp)*100,3) :0 }}</td>
                    <td> {{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</td>
                    @if($input['localite'] == 'uemoa')
                    <td>{{ $ru != 0 ? round(($r / $ru)*100,2) : 0}}</td>
                    <td> {{ $pU != 0 ? round(($pE / $pU)*100,2) : 0 }}</td>
                    <td>{{ $ru != 0 ? round(($rp / $ru)*100,2) : 0 }}</td>
                    <td>{{ $pU != 0 ? round(($pP / $pU)*100,2) : 0}}</td>
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
                    @endforeach
                    @php($rP = $r)
                    @php($rpP = $rp)
                    @if($input['localite'] == 'uemoa')
                    @php($ruP = $ru)
                    @endif
                    @endforeach
                    @if($input['naturep'] == 'variation')
                    <td>{{ $be = ($FormatBrut($getBruteRubrique($dbs, $rubrique->id, $idE, $exercice2)) - ($e = $FormatBrut($dbs, $getBruteRubrique($rubrique->id, $idE, $exercice1)->brut))) }}
                    </td>
                    <td>{{ $bp = ($FormatBrut($getBruteRubriquePays($dbs, $rubrique->id, $exercice2)) - ($p = $FormatBrut($dbs, $getBruteRubriquePays($rubrique->id, $exercice1)->total))) }}
                    </td>
                    @if($input['localite'] == 'uemoa')
                    <td>{{ $bu = ($FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice2)) - ($u = $FormatBrut($getBruteRubriqueUEMOA($rubrique->id, $exercice1)->total))) }}
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
                @endforeach
                @endforeach
                @endforeach
                {{-- Total Nature --}}
                <tr style="font-size: 13px;text-align: center; background-color: #00acc1">
                    <th style="text-align: right;">
                        @foreach($classesA as $classeA)
                        {{'TOTAL '. strtoupper($classeA->nature)  }}
                        @break;
                        @endforeach
                    </th>
                    @foreach($exercices as $exercice )
                    @foreach($totalNatureA as $totalA)
                    @continue($totalA->exercice != $exercice->exercice)
                    @foreach($totalNatureAPays as $totalPays)
                    @continue($totalPays->exercice != $totalA->exercice)
                    <th> {{ (int)$totalA->total }}</th>
                    <th> {{ 100 }}</th>
                    <th>{{(int)$totalPays->total}}</th>
                    <th>{{ 100 }}</th>
                    @if($input['localite'] == 'uemoa')
                    @foreach($totalNatureAUEMOA as $totalAUEMOA)
                    @continue($totalAUEMOA->exercice != $totalPays->exercice)
                    <th>{{ (int)$totalAUEMOA->total }}</th>
                    <th>{{ 100 }}</th>
                    @endforeach
                    @endif
                    <th>{{ $totalPays->total != 0 ? round(($totalA->total / $totalPays->total)*100,2):0 }}</th>
                    <th>{{ '---' }}</th>
                    @if($input['localite'] == 'uemoa')
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    @endif
                    @if($input['naturep'] == 'paran')
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    @if($input['localite'] == 'uemoa')
                    <th></th>
                    <th></th>
                    @endif
                    @endif
                    @endforeach
                    @endforeach
                    @endforeach
                    @if($input['naturep'] == 'variation')
                    <th></th>
                    <th></th>
                    @if($input['localite'] == 'uemoa')
                    <th></th>
                    @endif
                    <th></th>
                    <th></th>
                    @if($input['localite'] == 'uemoa')
                    <th></th>
                    @endif
                    @endif
                </tr>
                {{-- Passifs Ou Produits --}}
            </tbody>
        </table>

    </div>
</div>