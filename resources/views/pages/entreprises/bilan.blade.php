@include('templates._assets')
@if($input['exercice1'] > $input['exercice2'])
    @php
        $exercice1 = $input['exercice2'];
        $exercice2 = $input['exercice1'];
    @endphp
@else
    @php($exercice1 = $input['exercice1'])
    @php($exercice2 = $input['exercice2'])
@endif
@php($idE = explode('-',$input['idEntreprise'])[0])
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
                        <span>{{$infoEntreprise->nomSecteur}}</span>
                    </div>
                </div>

                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size: medium">
                    <div class="col-md-6">
                        Raison Sociale :
                        <span>
                             {{ $infoEntreprise->nomEntreprise }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        Activité principal :
                        <span>
                            {{ $infoEntreprise->nomsouSecteur }}
                        </span>
                    </div>
                </div>
                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355AF; font-size: medium">
                    <div class="col-md-6">
                        Adresse :
                        <span>{{$infoEntreprise->Adresse}}</span>
                    </div>
                    <div class="col-md-6">
                        Services :
                        <span>{{$infoEntreprise->nomService}}</span>
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
                <th style="text-align: right;" > </th>
                <th style="text-align: center; " colspan="{{ $colspan }}">Premier Exercice : {{ $exercice1 }}</th>
                <th style="text-align: center;background-color: #0000F0" colspan="{{ $colspan }}"> Dernier Exercice : {{ $exercice2 }}</th>
                <th style="text-align: center;" colspan="@if($input['localite'] == 'uemoa'){{ 6 }} @else {{ 4 }} @endif"> Variation</th>
            </tr>
        @else
            <tr style="font-size: 14px">
                <th style="text-align: right;">Exrecices : </th>
                @if($input['localite'] == 'uemoa')
                    @php ($colspan = 18)
                @else
                    @php ($colspan = 10)
                @endif
                @for ($exo = $exercice1; $exo<=$exercice2; $exo++ )
                    <th colspan="{{ $colspan }}" style="background-color: #66CCFF; text-align: center; ">{{ $exo }}</th>
                @endfor
            </tr>
        @endif
        <tr style="text-align: center;">
            <th> </th>
            @foreach($exercices as $exercice)
                <th colspan="2">{{$infoEntreprise->Sigle }}</th>
                <th colspan="2" style="background-color: #F3F3F3; ">Pays</th>
                @if($input['localite'] == 'uemoa')
                    <th colspan="2">UEMOA</th>
                @endif
                <th colspan="@if($input['localite'] == 'uemoa') {{ 6 }} @else {{ 2 }} @endif" style="background-color: #BCDAC5">Indicateurs</th>
                @if($input['naturep'] == 'paran')
                    <th colspan="@if($input['localite'] == 'uemoa') {{ 6 }} @else {{ 4 }} @endif" style="background-color: #66CCFF">&Eacute;volution </th>
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
                    <th >M. (CFA)</th>
                    <th >% / T.E</th>
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
                <th style="text-align: left;">{{ $classeA->nomClasse }}
                    {{--@if($SousClassesInClasse($classeA->idClasse)->count() >1)
                        <a href="#" title="Plus De Details">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endif--}}
                </th>
                @foreach($exercices as $exercice)
                    @if($loop->first && $input['naturep'] == 'paran' && $exercice1 > 2000)
                        @php($bruteEP = $FormatBrut($getBruteClasse($classeA->idClasse, $idE, $exercice->exercice-1)))
                        @php($brutePP = $FormatBrut($getBruteClassePays($classeA->idClasse, $exercice->exercice-1)))
                        @if($input['localite'] == 'uemoa')
                            @php($bruteUP = $FormatBrut($getBruteClasseUEMOA($classeA->idClasse, $exercice->exercice-1)))
                        @endif
                    @endif
                       @foreach($totalNatureA as $totalA)
                           @continue($exercice->exercice != $totalA->exercice)
                           @foreach($totalNatureAPays as $totalAPays)
                               @continue($totalAPays->exercice != $totalA->exercice)
                               <th>{{ $bruteE = (int) ($FormatBrut($getBruteClasse($classeA->idClasse, $idE, $exercice->exercice))) }}</th>
                               <th > {{ $FormatBrut($totalA) != 0 ? $pE = round(($bruteE / $totalA->total)*100,2) : 0 }}</th>
                               <th >{{ $bruteP = (int) $FormatBrut($getBruteClassePays($classeA->idClasse, $exercice->exercice)) }}</th>
                               <th >{{ $FormatBrut($totalAPays) != 0 ? $pP = round(($bruteP / $totalAPays->total)*100,2) : 0}}</th>
                               @if($input['localite'] == 'uemoa')
                                   @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                       @continue($totalAUEMOA->exercice != $totalAPays->exercice)
                                           <th>{{ $bruteU = (int) $FormatBrut($getBruteClasseUEMOA($classeA->idClasse, $exercice->exercice)) }}</th>
                                           <th>{{$FormatBrut($totalAUEMOA) != 0 ? $pU = round(($bruteU / $totalAUEMOA->total)*100,2):0  }}</th>
                                   @endforeach
                               @endif
                               <th >{{ $bruteP != 0 ? round(($bruteE / $bruteP)*100,2) :0 }}</th>
                               <th > {{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</th>
                               @if($input['localite'] == 'uemoa')
                                   <th >{{ $bruteU != 0 ? round(($bruteE / $bruteU)*100,2) : 0}}</th>
                                   <th > {{ $pU != 0 ? round(($pE / $pU)*100,2) : 0 }}</th>
                                   <th >{{ $bruteU != 0 ? round(($bruteP / $bruteU)*100,2) : 0 }}</th>
                                   <th >{{ $pU != 0 ? round(($pP / $pU)*100,2) : 0}}</th>
                               @endif
                               @if($input['naturep'] == 'paran' && $exercice1 > 2000)
                                   <th style="color :{{ ($bruteE - $bruteEP) < 0 ? ' red' : (($bruteE - $bruteEP) == 0 ? 'black' : ' green')  }}">{{ $diff = $bruteE - $bruteEP }}</th>
                                   <th > {{ $bruteEP != 0 ? round(($diff / $bruteEP)*100,2) : 0}}</th>
                                   <th style="color :{{ ($bruteP - $brutePP) < 0 ? ' red' : (($bruteP - $brutePP) == 0 ? 'black' : ' green')  }}">{{ $diffP = $bruteP - $brutePP }}</th>
                                   <th >{{ $brutePP != 0 ? round(($diffP / $brutePP)*100,2) : 0}}</th>
                                   @if($input['localite'] == 'uemoa')
                                       <th >{{ $diffU = $bruteU - $bruteUP }}</th>
                                       <th style="color :{{ $bruteU - $bruteUP < 0 ? ' red' : ($bruteU - $bruteUP == 0 ? 'black' : ' green') }}">{{ $bruteUP != 0 ? round(($diffU / $bruteUP)*100,2) : 0}}</th>
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
                        <th >{{ $be =( $FormatBrut($getBruteClasse($classeA->idClasse, $idE, $exercice2)) - ($e = $FormatBrut( $getBruteClasse($classeA->idClasse, $idE, $exercice1)->total))) }}</th>
                       <th >{{ $bp =( $FormatBrut($getBruteClassePays($classeA->idClasse, $exercice2)) - ($p = $FormatBrut($getBruteClassePays($classeA->idClasse, $exercice1)->total))) }}</th>
                       @if($input['localite'] == 'uemoa')
                           <th >{{ $bu = ($FormatBrut($getBruteClasseUEMOA($classeA->idClasse, $exercice2)) - ($u = $FormatBrut($getBruteClasseUEMOA($classeA->idClasse, $exercice1)->total))) }}</th>
                       @endif
                       <th >{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</th>
                       <th >{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</th>
                       @if($input['localite'] == 'uemoa')
                           <th >{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</th>
                       @endif
                   @endif
               </tr>
               {{-- Display Sous Classe If Existe--}}
               @php($sousclasses = $SousClassesInClasse($classeA->idClasse))
               @continue((strtoupper($sousclasses[0]->nomClasse) == strtoupper($sousclasses[0]->nomSousclasse)) && ($sousclasses->count() == 1))
               @foreach($sousclasses as $sousclasse)
                   <tr style="text-align: center;">
                       <th style="color: #0000F0;">{{ $sousclasse->nomSousclasse }}</th>
                       @foreach($exercices as $exercice )
                          {{-- @php($res = $getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice->exercice))
                           @php($resp = $getBruteSousClassePays($sousclasse->idSousclasse, $exercice->exercice))
                           @if($input['localite'] == 'uemoa')
                               @php($resu = $getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice->exercice))
                           @endif--}}
                           @if($loop->first && $input['naturep'] == 'paran' && $exercice1 > 2000)
                               @php($scP = $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice->exercice-1)))
                               @php($scpP =  $FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice->exercice-1)))
                               @if($input['localite'] == 'uemoa')
                                   @php($scpU =  $FormatBrut($getBrutSousClasseUEMOA($sousclasse->idSousclasse, $exercice->exercice-1)))
                               @endif
                           @endif
                           @foreach($totalNatureA as $totalA)
                               @continue($exercice->exercice != $totalA->exercice)
                               @foreach($totalNatureAPays as $totalAPays)
                                   @continue($totalAPays->exercice != $totalA->exercice)
                                   <th>{{ $sc = $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice->exercice))}}</th>
                                   <th>{{ $FormatBrut($totalA) != 0 ? $pE = round(($sc / $totalA->total)*100,3) : 0 }}</th>
                                   <th>
                                       {{--@php($getBruteSousClassePays($sousclasse->idSousclasse, $exercice->exercice))--}}
                                       {{ $scp = $FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice->exercice))}}</th>
                                   <th>{{ $FormatBrut($totalAPays) != 0 ? $pP = round(($scp / $totalAPays->total)*100,3) : 0 }}</th>
                                   @if($input['localite'] == 'uemoa')
                                       @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                           @continue($totalAUEMOA->exercice != $totalAPays->exercice)
                                           <th>{{ $scu = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice->exercice)) }}</th>
                                           <th>{{$FormatBrut($totalAUEMOA) != 0 ? $pU = round(($scu / $totalAUEMOA->total)*100,3):0  }}</th>
                                       @endforeach
                                   @endif
                                   <th>{{ $scp != 0 ? round(($sc / $scp)*100,3) :0 }}</th>
                                   <th>{{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</th>

                                   @if($input['localite'] == 'uemoa')
                                       <th>{{ $scu != 0 ? round(($sc / $scu)*100,2) : 0}}</th>
                                       <th> {{ $pU != 0 ? round(($pE / $pU)*100,2) : 0 }}</th>
                                       <th>{{ $scu != 0 ? round(($scp / $scu)*100,2) : 0 }}</th>
                                       <th>{{ $pU != 0 ? round(($pP / $pU)*100,2) : 0}}</th>
                                   @endif
                                   @if($input['naturep'] == 'paran')
                                       <th style="color: {{ $sc - $scP < 0 ? '#e83e8c' : ($sc - $scP == 0 ? 'gray' : '#2bbbad')  }}">{{ $diff = $sc - $scP }}</th>
                                       <th> {{ $scP == 0 ? 0 : round(($diff / $scP)*100,2) }}</th>
                                       <th style="color: {{ $scp - $scpP < 0 ? '#e83e8c' : ($scp - $scpP == 0 ? 'gray' : '#2bbbad')  }}">{{ $diffP = $scp - $scpP }}</th>
                                       <th>{{ $scpP != 0 ? round(($diffP / $scpP)*100,2) : 0}}</th>
                                       @if($input['localite'] == 'uemoa')
                                           <th style="color: {{ $scu - $scuP < 0 ? '#e83e8c' : ($scu - $scuP == 0 ? 'gray' : '#2bbbad')  }}">{{ $diffU = $scu - $scuP }}</th>
                                           <th>{{ $scuP != 0 ? round(($diffU / $scuP)*100,2) : 0}}</th>
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
                           <th>{{ $be = ( $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice2)) - ($e = $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice1)->total))) }}</th>
                           <th>{{ $bp = ($FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice2)) - ($p = $FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice1)->total))) }}</th>
                           @if($input['localite'] == 'uemoa')
                               <th>{{ $bu = ($FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice2)) - ($u = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice1)->total))) }}</th>
                           @endif
                           <th>{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</th>
                           <th>{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</th>
                           @if($input['localite'] == 'uemoa')
                               <th>{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</th>
                           @endif
                       @endif
                   </tr>
                   {{-- Display Rubriques if Existe
                   @php($rubriques = $RubriquesSousClasse($sousclasse->idSousclasse))--}}
                   @foreach($RubriquesSousClasse($sousclasse->idSousclasse) as $rubrique)
                       @if(strtoupper($rubrique->nomRubrique) != strtoupper($rubrique->nomSousclasse))
                           <tr style="text-align: center;">
                               <th style="text-align: right; color: #2bbbad;">{{ $rubrique->nomRubrique }}</th>
                               @foreach($exercices as $exercice )

                                   @if($loop->first && $input['naturep'] == 'paran' && $exercice1 > 2000)
                                       @php($rP = $FormatBrut($getBruteRubrique($rubrique->idRubrique, $idE, $exercice->exercice-1)))
                                       @php($rpP = $FormatBrut( $getBruteRubriquePays($rubrique->idRubrique, $exercice->exercice-1)))
                                       @if($input['localite'] == 'uemoa')
                                           @php($ruP = $FormatBrut($getBrutRubriqueUEMOA($rubrique->idRubrique, $exercice->exercice-1)))
                                       @endif
                                   @endif
                                   @foreach($totalNatureA as $totalA)
                                       @continue($exercice->exercice != $totalA->exercice)
                                       @foreach($totalNatureAPays as $totalAPays)
                                           @continue($totalAPays->exercice != $totalA->exercice)
                                           <th>{{ $r = ($FormatBrut($getBruteRubrique($rubrique->idRubrique, $idE, $exercice->exercice)))}}</th>
                                           <th>{{ $FormatBrut($totalA) != 0 ? $pE = round(($r / $totalA->total)*100,3) : 0 }}</th>
                                           <th>{{ $rp = $FormatBrut($getBruteRubriquePays($rubrique->idRubrique, $exercice->exercice))}}</th>
                                           <th> {{ $FormatBrut($totalAPays) != 0 ? $pP = round(($rp / $totalAPays->total)*100,3) : 0 }}</th>
                                           @if($input['localite'] == 'uemoa')
                                               @foreach($totalNatureAUEMOA as $totalAUEMOA)
                                                   @continue($totalAUEMOA->exercice != $totalAPays->exercice)
                                                   <th>{{ $ru = $FormatBrut($getBruteRubriqueUEMOA($rubrique->idRubrique, $exercice->exercice)) }}</th>
                                                   <th>{{$FormatBrut($totalAUEMOA) != 0 ? $pU = round(($ru / $totalAUEMOA->total)*100,3):0  }}</th>
                                               @endforeach
                                           @endif
                                           <th>{{ $rp != 0 ? round(($r / $rp)*100,3) :0 }}</th>
                                           <th> {{ $pP != 0 ? round(($pE / $pP)*100,2):0 }}</th>
                                           @if($input['localite'] == 'uemoa')
                                               <th>{{ $ru != 0 ? round(($r / $ru)*100,2) : 0}}</th>
                                               <th> {{ $pU != 0 ? round(($pE / $pU)*100,2) : 0 }}</th>
                                               <th>{{ $ru != 0 ? round(($rp / $ru)*100,2) : 0 }}</th>
                                               <th>{{ $pU != 0 ? round(($pP / $pU)*100,2) : 0}}</th>
                                           @endif
                                           @if($input['naturep'] == 'paran')
                                               <th style="color: {{ $r - $rP < 0 ? '#9f105c' : ($r - $rP == 0 ? ' #8d6e63' : '#00acc1')  }}">{{ $diff = $r - $rP }}</th>
                                               <th> {{ $rP != 0 ? round(($diff / $rP)*100,2) : 0}}</th>
                                               <th style="color: {{ $rp - $rpP < 0 ? '#9f105c' : ($rp - $rpP == 0 ? ' #8d6e63' : '#00acc1')  }}">{{ $diffP = $rp - $rpP }}</th>
                                               <th>{{ $rpP != 0 ? round(($diffP / $rpP)*100,2) : 0}}</th>
                                               @if($input['localite'] == 'uemoa')
                                                   <th>{{ $diffU = $ru - $ruP }}</th>
                                                   <th>{{ $ruP != 0 ? round(($diffU / $ruP)*100,2) : 0}}</th>
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
                                   <th>{{ $be = ($FormatBrut($getBruteRubrique($rubrique->idRubrique, $idE, $exercice2)) - ($e = $FormatBrut($getBruteRubrique($rubrique->idRubrique, $idE, $exercice1)->brut))) }}</th>
                                   <th>{{ $bp = ($FormatBrut($getBruteRubriquePays($rubrique->idRubrique, $exercice2)) - ($p = $FormatBrut($getBruteRubriquePays($rubrique->idRubrique, $exercice1)->total))) }}</th>
                                   @if($input['localite'] == 'uemoa')
                                       <th>{{ $bu = ($FormatBrut($getBruteRubriqueUEMOA($rubrique->idRubrique, $exercice2)) - ($u = $FormatBrut($getBruteRubriqueUEMOA($rubrique->idRubrique, $exercice1)->total))) }}</th>
                                   @endif
                                   <th>{{ $e != 0 ? round(($be/$e)*100,2) : 0 }}</th>
                                   <th>{{ $p != 0 ? round(($bp/$p)*100,2) : 0 }}</th>
                                   @if($input['localite'] == 'uemoa')
                                       <th>{{ $u != 0 ? round(($bu/$u)*100,2) : 0 }}</th>
                                   @endif
                               @endif
                           </tr>
                       @endif
                   @endforeach

               @endforeach
           @endforeach
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
                   <th ></th>
                   <th ></th>
                   @if($input['localite'] == 'uemoa')
                       <th ></th>
                   @endif
                   <th ></th>
                   <th ></th>
                   @if($input['localite'] == 'uemoa')
                       <th ></th>
                   @endif
               @endif

           </tr>
           {{-- Passifs Ou Produits --}}
           </tbody>
       </table>

       </div>
   </div>
