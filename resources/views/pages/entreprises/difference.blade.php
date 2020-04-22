@include('templates._assets')
@php
$exercice1 = $exercice01;
$exercice2 = $exercice02;
@endphp
<div class="">
    <div class="card">
        <div class="card-body">
            <div class="form-row col-md-5 " style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium">
                @foreach($infoEntreprisesR as $infoEntrepriseR )
                <div class="row">
                    <h2>{{ $infoEntrepriseR->entreprise }}</h2>
                </div>

                <div class="row">
                    Service : <b>{{$infoEntrepriseR->service}}</b>
                </div>
                @endforeach
            </div>
            <div class="form-row col-md-5 "
                style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium;margin-left: 10%">
                @foreach($infoEntreprises as $infoEntreprise )
                <div class="row">
                    <h2>{{ $infoEntreprise->entreprise }}</h2>
                </div>

                <div class="row">
                    Service : <b>{{$infoEntreprise->service}}</b>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<table class="table table-condensed" style="font-size: 12px">
    <thead>
        @if($input['naturep'] == 'variation')
        <tr>
            <th style="text-align: right;"> </th>
            <th style="text-align: center; background-color: #7abaff" colspan="7">{{$infoEntrepriseR->sigle}}</th>
            <th style="text-align: center; background-color: #929fba" colspan="7">{{$infoEntreprise->sigle}}</th>
            <th style="text-align: center; background-color: #5cd08d" colspan="6">
                {{'Variation '.$infoEntreprise->sigle .' % à '.$infoEntrepriseR->sigle}}</th>
        </tr>
        <tr>
            <th></th>
            @foreach($exercices as $exercice)
            <th style="text-align: center; background-color: #9e9e9e" colspan="2">{{$exercice1}}</th>
            <th style="text-align: center; background-color: #1d68a7" colspan="2">{{$exercice2}}</th>
            <th style="text-align: center; " colspan="3">{{'Variation'}}</th>
            @endforeach
            <th style="text-align: center; background-color: #9e9e9e" colspan="3">{{$exercice1}}</th>
            <th style="text-align: center; background-color: #1d68a7" colspan="3">{{$exercice2}}</th>
        </tr>
        <tr>
            {{-- Actifs ou charges --}}
            <th style="background-color: #D0FDEB; text-align: left;">
                @foreach($classesA as $collectclasseA)
                {{ strtoupper($collectclasseA->nature)  }}
                @break;
                @endforeach
            </th>
            @foreach($exercices as $exercice)
            <th>{{'M. (CFA)'}}</th>
            <th>{{'% / T.E'}}</th>
            <th>{{'M. (CFA)'}}</th>
            <th>{{'% / T.E'}}</th>
            <th> {{ 'D.B' }}</th>
            <th>{{ 'R.P.M' }}</th>
            <th>{{ 'D.P.M' }}</th>
            @endforeach
            <th>{{'D.B'}}</th>
            <th>{{'R.P.M'}}</th>
            <th>{{'D.P.M'}}</th>
            <th>{{'D.B'}}</th>
            <th>{{'R.P.M'}}</th>
            <th>{{'D.P.M'}}</th>
        </tr>
        @else
        <tr style="font-size: 14px">
            <th style="text-align: right;">Exrecices : </th>
            @foreach($exercices as $exercice)
            <th colspan="7" style="background-color: #66CCFF; text-align: center; ">{{ $exercice->exercice }}</th>
            @endforeach
        </tr>
        <tr style="font-size: 14px">
            <th style="text-align: right;"> </th>
            @foreach($exercices as $exercice)
            <th colspan="2" style="background-color: #929fba; text-align: center; ">{{ $infoEntrepriseR->sigle }}</th>
            <th colspan="2" style="background-color: #66CCFF; text-align: center; ">{{ $infoEntreprise->sigle }}</th>
            <th colspan="3" style="background-color: #20c997; text-align: center; ">{{ 'Variation' }}</th>
            @endforeach
        </tr>
        <tr>
            {{-- Actifs ou charges --}}
            <th style="background-color: #D0FDEB; text-align: left;">
                @foreach($classesA as $classeA)
                {{ strtoupper($classeA->nature)  }}
                @break;
                @endforeach
            </th>
            @foreach($exercices as $exercice)
            <th>{{'M. (CFA)'}}</th>
            <th>{{'% / T.E'}}</th>
            <th>{{'M. (CFA)'}}</th>
            <th>{{'% / T.E'}}</th>
            <th> {{ 'D.B' }}</th>
            <th>{{ 'R.P' }}</th>
            <th>{{ 'D.P' }}</th>
            @endforeach
        </tr>
        @endif
    </thead>
    <tbody>
        @foreach($classesA as $classeA)
        <tr style="font-size: 12px; text-align: right;">
            <th style="text-align:left">{{ $classeA->classe }}</th>
            @if($input['naturep'] == 'paran')
            @foreach($exercices as $exercice)
            @foreach($totalNatureAR as $totalAR)
            @foreach($totalNatureA as $totalA)
            @continue($totalA->exercice != $exercice->exercice ||
            $totalAR->exercice != $exercice->exercice ||
            $totalAR->exercice != $totalA->exercice )
            {{-- $getBruteClasse($dbs, $classes,$idEntreprise, $exercice) --}}
            <td>
                {{ $er1 = (int) $FormatBrut($getBruteClasse($dbs, $classeA->id,$idER, $exercice->exercice)) }}
            </td>
            <td>
                {{ $er = (($m = $totalAR->total) != 0 ?  round(($er1 / $m)*100,2) : 0)}}
            </td>
            <td>
                {{ $e1 = (int) $FormatBrut($getBruteClasse($dbs, $classeA->id,$idE, $exercice->exercice)) }}</td>
            <td>
                {{ $e =(($n = $totalA->total) != 0 ?  round(($e1 / $n)*100,2) : 0) }}
            </td>
            <td>{{$e1 - $er1 }}</td>
            <td>{{ $er != 0 ? round( ($e / $er)*100,2) : 0 }}</td>
            <td> {{ $e - $er }} </td>
            @endforeach
            @endforeach
            @endforeach
            @else
            @foreach($entreprises as $entreprise)
            @foreach($exercices as $exercice)
            @foreach($totalNatureAR as $totalAR)
            @continue($totalAR->exercice != $exercice->exercice ||
            $totalAR->idEntreprise != $entreprise->id )
            <th>{{ $a =(int) $FormatBrut($getBruteClasse($dbs, $classeA->id,$idER, $exercice->exercice)) }}</th>
            <th>{{ $ar = (($m = $totalAR->total) != 0 ? round(($a/$m)*100,2) : 0)}} </th>
            {{-- Get value pour faire le calcul de variation dans le meme entreprise ici la référence--}}
            @if ($loop->parent->first)
            @php
            $br1 = $a;
            $pdmr1 = $ar;
            $btr1 = $m;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $br2 = $a;
            $pdmr2 = $ar;
            $btr2 = $m;
            @endphp
            @endif
            @endforeach
            @endforeach
            @if ($loop->first)
            <td>{{ $br2 - $br1 }}</td>
            <td>{{ $s = ( ($btr1 == 0 || $br1 == 0 || $btr2 == 0) ? 0 : round(($r = round(($br2 / $btr2)*100,2)) / ($r1 = round(($br1 / $btr1)*100,2))*100,2)) }}
            </td>
            <td> {{ $s != 0 ? $r - $r1 : 0}} </td>
            @endif
            @foreach($exercices as $exercice)
            @foreach($totalNatureA as $totalA)
            @continue($totalA->exercice != $exercice->exercice ||
            $totalA->idEntreprise != $entreprise->id )
            <th>{{ $a =(int) $FormatBrut($getBruteClasse($dbs, $classeA->id,$idE, $exercice->exercice)) }}</th>
            <th>{{ $ar = (($m = $totalA->total) != 0 ? round(($a/$m)*100,2) : 0)}} </th>
            {{-- Get value pour faire le calcul de variation dans le meme entreprise ici la référence--}}
            @if ($loop->parent->first)
            @php
            $b1 = $a;
            $pdm1 = $ar;
            $bt1 = $m;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $b2 = $a;
            $pdm2 = $ar;
            $bt2 = $m;
            @endphp
            @endif
            @endforeach
            @endforeach
            @if ($loop->last)
            <td>{{ $b2 - $b1 }}</td>
            <td>{{ $s = ( ($bt1 == 0 || $b1 == 0 || $bt2 == 0) ? 0 : round(($r = round(($b2 / $bt2)*100,2)) / ($r1 = round(($b1 / $bt1)*100,2))*100,2)) }}
            </td>
            <td> {{ $s != 0 ? $r - $r1 : 0}} </td>
            @endif
            @endforeach
            {{-- Si Par variation affichage des diff et ecarts --}}
            <th> {{ $b1 - $br1}} </th>
            <th> {{ $pdmr1 != 0 ? round(($pdm1 / $pdmr1)*100,2) : 0}}</th>
            <th> {{ $pdm1 - $pdmr1 }}</th>
            <th> {{ $b2 - $br2}} </th>
            <th> {{ $pdmr2 != 0 ? round(($pdm2 / $pdmr2)*100,2) : 0}} </th>
            <th> {{ $pdm2 - $pdmr2 }} </th>
            @endif
        </tr>
        @endforeach
        <tr style="font-size: 13px;text-align: center">
            <th style="text-align: right;">
                {{'TOTAL '. strtoupper($classeA->nature)  }}
            </th>
            @if($input['naturep'] == 'paran')
            @foreach($exercices as $exercice)
            @foreach($totalNatureA as $totalA)
            @foreach($totalNatureAR as $totalAR)
            @continue($totalA->exercice != $exercice->exercice ||
            $totalAR->exercice != $exercice->exercice ||
            $totalA->exercice != $totalAR->exercice )
            <th>{{ $t = (int)$totalAR->total }}</th>
            <th>{{ 100 }}</th>
            <th>{{ $t1 = (int) $totalA->total }}</th>
            <th>{{ 100 }}</th>
            <th>{{$t2 =  $t1 - $t }}</th>
            <th>{{100 }}</th>
            <th>{{ 0 }}</th>
            @endforeach
            @endforeach
            @endforeach
            @else
            @foreach($entreprises as $entreprise)
            @foreach($exercices as $exercice)
            @foreach($totalNatureAR as $totalAR)
            @continue($totalAR->exercice != $exercice->exercice ||
            $totalAR->idEntreprise != $entreprise->id)
            <th>{{ $a = (int) $totalAR->total }}</th>
            <th>{{ 100 }}</th>

            @if ($loop->parent->first)
            @php
            $brt1 = $a;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $brt2 = $a;
            @endphp
            @endif
            @endforeach
            @endforeach
            @foreach($exercices as $exercice)
            @foreach($totalNatureA as $totalA)
            @continue($totalA->exercice != $exercice->exercice ||
            $totalA->idEntreprise != $entreprise->id)
            <th>{{  $a = (int) $totalA->total }}</th>
            <th>{{ 100 }}</th>
            @if ($loop->parent->first)
            @php
            $bt1 = $a;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $bt2 = $a;
            @endphp
            @endif
            @endforeach
            @endforeach
            @if ($loop->first)
            <td>{{ $brt2 - $brt1 }}</td>
            <td> {{ 100 }}</td>
            <td> {{ 0 }}</td>
            @endif
            @if ($loop->last)
            <td>{{ $bt2 - $bt1 }}</td>
            <td>{{ 100 }}</td>
            <td>{{ 0 }}</td>
            @endif
            @endforeach
            @foreach($exercices as $exercice)
            @if ($loop->first)
            <th>{{ $bt1 - $brt1 }}</th>
            <th> {{ 100}} </th>
            <th> {{ 0}} </th>
            @endif
            @if ($loop->last)
            <th>{{ $bt2 - $brt2 }}</th>
            <th> {{ 100}} </th>
            <th> {{ 0}} </th>
            @endif
            @endforeach
            @endif
        </tr>
        {{-- PASSIF OU PRODUIT --}}
        <tr style="text-align:right">
            <th style="background-color: #D0FDEB; text-align:left">
                @foreach($classesB as $classeB)
                {{ strtoupper($classeB->nature)  }}
                @break;
                @endforeach
            </th>
            @if ($input['naturep'] == 'paran')
            <th colspan="{{ 7*count($exercices)}}" style="background-color: #D0FDEB;"></th>
            @else
            <th colspan="20" style="background-color: #D0FDEB;"></th>
            @endif
        </tr>
        @foreach($classesB as $classeB)
        <tr style="font-size: 12px; text-align: right;">
            <th style="text-align:left">{{ $classeB->classe }}</th>
            @if($input['naturep'] == 'paran')
            @foreach($exercices as $exercice)
            @foreach($totalNatureBR as $totalBR)
            @foreach($totalNatureB as $totalB)
            @continue($totalB->exercice != $exercice->exercice ||
            $totalBR->exercice != $exercice->exercice ||
            $totalBR->exercice != $totalB->exercice )
            {{-- $getBruteClasse($dbs, $classes,$idEntreprise, $exercice) --}}
            <td>
                {{ $er1 = (int) $FormatBrut($getBruteClasse($dbs, $classeB->id,$idER, $exercice->exercice)) }}
            </td>
            <td>
                {{ $er = (($m = $totalBR->total) != 0 ?  round(($er1 / $m)*100,2) : 0)}}
            </td>
            <td>
                {{ $e1 = (int) $FormatBrut($getBruteClasse($dbs, $classeB->id,$idE, $exercice->exercice)) }}</td>
            <td>
                {{ $e =(($n = $totalB->total) != 0 ?  round(($e1 / $n)*100,2) : 0) }}
            </td>
            <td>{{$e1 - $er1 }}</td>
            <td>{{ $er != 0 ? round( ($e / $er)*100,2) : 0 }}</td>
            <td> {{ $e - $er }} </td>
            @endforeach
            @endforeach
            @endforeach
            @else
            @foreach($entreprises as $entreprise)
            @foreach($exercices as $exercice)
            @foreach($totalNatureBR as $totalBR)
            @continue($totalBR->exercice != $exercice->exercice ||
            $totalBR->idEntreprise != $entreprise->id )
            <th>{{ $a =(int) $FormatBrut($getBruteClasse($dbs, $classeB->id,$idER, $exercice->exercice)) }}</th>
            <th>{{ $ar = (($m = $totalBR->total) != 0 ? round(($a/$m)*100,2) : 0)}} </th>
            {{-- Get value pour faire le calcul de variation dans le meme entreprise ici la référence--}}
            @if ($loop->parent->first)
            @php
            $br1 = $a;
            $pdmr1 = $ar;
            $btr1 = $m;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $br2 = $a;
            $pdmr2 = $ar;
            $btr2 = $m;
            @endphp
            @endif
            @endforeach
            @endforeach
            @if ($loop->first)
            <td>{{ $br2 - $br1 }}</td>
            <td>{{ $s = ( ($btr1 == 0 || $br1 == 0 || $btr2 == 0) ? 0 : round(($r = round(($br2 / $btr2)*100,2)) / ($r1 = round(($br1 / $btr1)*100,2))*100,2)) }}
            </td>
            <td> {{ $s != 0 ? $r - $r1 : 0}} </td>
            @endif
            @foreach($exercices as $exercice)
            @foreach($totalNatureB as $totalB)
            @continue($totalB->exercice != $exercice->exercice ||
            $totalB->idEntreprise != $entreprise->id )
            <th>{{ $a =(int) $FormatBrut($getBruteClasse($dbs, $classeB->id,$idE, $exercice->exercice)) }}</th>
            <th>{{ $ar = (($m = $totalB->total) != 0 ? round(($a/$m)*100,2) : 0)}} </th>
            {{-- Get value pour faire le calcul de variation dans le meme entreprise ici la référence--}}
            @if ($loop->parent->first)
            @php
            $b1 = $a;
            $pdm1 = $ar;
            $bt1 = $m;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $b2 = $a;
            $pdm2 = $ar;
            $bt2 = $m;
            @endphp
            @endif
            @endforeach
            @endforeach
            @if ($loop->last)
            <td>{{ $b2 - $b1 }}</td>
            <td>{{ $s = ( ($bt1 == 0 || $b1 == 0 || $bt2 == 0) ? 0 : round(($r = round(($b2 / $bt2)*100,2)) / ($r1 = round(($b1 / $bt1)*100,2))*100,2)) }}
            </td>
            <td> {{ $s != 0 ? $r - $r1 : 0}} </td>
            @endif
            @endforeach
            {{-- Si Par variation affichage des diff et ecarts --}}
            <th> {{ $b1 - $br1}} </th>
            <th> {{ $pdmr1 != 0 ? round(($pdm1 / $pdmr1)*100,2) : 0}}</th>
            <th> {{ $pdm1 - $pdmr1 }}</th>
            <th> {{ $b2 - $br2}} </th>
            <th> {{ $pdmr2 != 0 ? round(($pdm2 / $pdmr2)*100,2) : 0}} </th>
            <th> {{ $pdm2 - $pdmr2 }} </th>
            @endif
        </tr>
        @endforeach
        <tr style="font-size: 13px;text-align: center">
            <th style="text-align: right;">
                {{'TOTAL '. strtoupper($classeB->nature)  }}
            </th>
            @if($input['naturep'] == 'paran')
            @foreach($exercices as $exercice)
            @foreach($totalNatureB as $totalB)
            @foreach($totalNatureBR as $totalBR)
            @continue($totalB->exercice != $exercice->exercice ||
            $totalBR->exercice != $exercice->exercice ||
            $totalB->exercice != $totalBR->exercice )
            <th>{{ $t = (int)$totalBR->total }}</th>
            <th>{{ 100 }}</th>
            <th>{{ $t1 = (int) $totalB->total }}</th>
            <th>{{ 100 }}</th>
            <th>{{$t2 =  $t1 - $t }}</th>
            <th>{{100 }}</th>
            <th>{{ 0 }}</th>
            @endforeach
            @endforeach
            @endforeach
            @else
            @foreach($entreprises as $entreprise)
            @foreach($exercices as $exercice)
            @foreach($totalNatureBR as $totalBR)
            @continue($totalBR->exercice != $exercice->exercice ||
            $totalBR->idEntreprise != $entreprise->id)
            <th>{{ $a = (int) $totalBR->total }}</th>
            <th>{{ 100 }}</th>

            @if ($loop->parent->first)
            @php
            $brt1 = $a;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $brt2 = $a;
            @endphp
            @endif
            @endforeach
            @endforeach
            @foreach($exercices as $exercice)
            @foreach($totalNatureB as $totalB)
            @continue($totalB->exercice != $exercice->exercice ||
            $totalB->idEntreprise != $entreprise->id)
            <th>{{  $a = (int) $totalB->total }}</th>
            <th>{{ 100 }}</th>
            @if ($loop->parent->first)
            @php
            $bt1 = $a;
            @endphp
            @endif
            @if ($loop->parent->last)
            @php
            $bt2 = $a;
            @endphp
            @endif
            @endforeach
            @endforeach
            @if ($loop->first)
            <td>{{ $brt2 - $brt1 }}</td>
            <td> {{ 100 }}</td>
            <td> {{ 0 }}</td>
            @endif
            @if ($loop->last)
            <td>{{ $bt2 - $bt1 }}</td>
            <td>{{ 100 }}</td>
            <td>{{ 0 }}</td>
            @endif
            @endforeach
            @foreach($exercices as $exercice)
            @if ($loop->first)
            <th>{{ $bt1 - $brt1 }}</th>
            <th> {{ 100}} </th>
            <th> {{ 0}} </th>
            @endif
            @if ($loop->last)
            <th>{{ $bt2 - $brt2 }}</th>
            <th> {{ 100}} </th>
            <th> {{ 0}} </th>
            @endif
            @endforeach
            @endif
        </tr>
    </tbody>
</table>