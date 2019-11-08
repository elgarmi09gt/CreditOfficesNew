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
@php($RATIO_U = collect())
@php($RATIO_V = collect())
@php($RATIOS = collect())
@foreach($Countries as $countrie) {{-- For Any Country Calculate rcd for either Year --}}
    @foreach($exercices as $exercice)
        @php($RATIO[0][0] = $countrie->idPays)
        @php($RATIO[0][1] = $exercice->exercice)
        @php($ps = ($RATIO[0][2] = $rcdPays($exercice->exercice,$countrie->bdPays)))
        @if($input['naturep'] =='paran') {{-- Evolution if By Year--}}
            @if ($loop->first)
                @php($pp = $rcdPays($exercice->exercice-1,$countrie->bdPays))
            @endif
            @php($RATIO[0][3] = $ps - $pp)
        @endif
        @php($RATIOS = $RATIOS->concat($RATIO))
        @php($pp = $ps)
    @endforeach
    @if($input['naturep'] != 'paran')
        @php($RV[0][0] = $countrie->idPays)
        @php($RV[0][1] = $rcdPays($exercice2,$countrie->bdPays) - $rcdPays($exercice1,$countrie->bdPays))
        @php($RATIO_V = $RATIO_V->concat($RV))
    @endif
@endforeach
@foreach($exercices as $exercice) {{-- Calculate rcd For UEMOA for etheir YEAR --}}
    @php ($RU[0][0] = ($exercice->exercice))
    @php ($ps = ($RU[0][1] = $rcdUEMOA($exercice->exercice)))
    @if($input['naturep'] == 'paran') {{-- UEMOA Evolution If By YEAR --}}
        @if($loop->first)
            @php($pp = $rcdUEMOA($exercice->exercice-1))
            @php($RU[0][2] = $ps - $pp)
        @endif
    @endif
    @php($RATIO_U = $RATIO_U->concat($RU))
    @php($pp = $ps)
@endforeach

@if($input['naturep'] != 'paran')
    @php($RATIO_VU [] = ($rcdUEMOA($exercice2) - $rcdUEMOA($exercice1)))
@endif
<table class="table table-condensed container" style="font-size: 12px">
    @foreach($Countries as $countrie)
        @if($Countries->count() > 1)
            <tr>
                <th colspan="{{$input['naturep'] == "paran" ? 7*$exercices->count() : 10}}" style="text-align: center;">
                    {{ $countrie->nomPays }}
                </th>
            </tr>
        @endif
        <tr>
            <th>
                <div class="col" style="text-align: right; color: #3aa2ff">
                    {{ $input['ratio'] }}
                </div>
            </th>
            @foreach($exercices as $exercice)
                @foreach($RATIOS as $r)
                    @continue($r[0] != $countrie->idPays || $r[1] != $exercice->exercice)
                    @foreach($RATIO_U as $ru)
                        @continue($ru[0] != $exercice->exercice || $ru[0] != $r[1])
                        <th colspan="{{$input['naturep'] == "paran" ? 7 : 3}}"
                            style="background-color: #8ec5fc; text-align: center;">
                            <div class="col">
                                {{ ' Pays : '. $r[2] }}
                            </div>
                            <div class="col">
                                {{ ' UEMOA : '. $ru[1] }}
                            </div>
                        </th>
                    @endforeach
                @endforeach
            @endforeach
            @if($input['naturep'] != "paran")
                <th colspan="4" style="text-align: center;background-color: #8ec5fc;">
                    <div class="col">{{ 'Pays : '. ($rcdPays($exercice2,$countrie->bdPays) - $rcdPays($exercice1,$countrie->bdPays))}}</div>
                    <div class="col">{{ 'UEMOA : '. ($rcdUEMOA($exercice2) - $rcdUEMOA($exercice1))}}</div>
                </th>
            @endif
        </tr>
        <tr>
            <th>{{ 'Exercices' }}</th>
            @foreach($exercices as $exercice)
                <th colspan="{{$input['naturep'] == "paran" ? 7 : 3}}"
                    style="text-align: center;"> {{ $exercice->exercice}}</th>
            @endforeach
            <th colspan="4"></th>
        </tr>
        <tr style="text-align: center;">
            <th rowspan="2"></th>
            @foreach($exercices as $exercice)
                <th colspan="3">{{ "INDICATEUR" }}</th>
                @if($input['naturep'] == "paran")
                    <th colspan="4">{{ "EVOLUTION" }}</th>
                @endif
            @endforeach
            @if($input['naturep'] != "paran")
                <th colspan="4">{{ "EVOLUTION" }}</th>
            @endif
        </tr>
        <tr>
            @foreach($exercices as $exercice)
                <th>{{ " RATIO " }}</th>
                <th>{{ " % AU PAYS " }}</th>
                <th>{{ " % A UEMOA " }}</th>
                @if($input['naturep'] == "paran")
                    <th>{{ "D.R" }}</th>
                    <th>{{ "% E" }}</th>
                    <th>{{ "E % E.P" }}</th>
                    <th>{{ "E % E.U" }}</th>
                @endif
            @endforeach
            @if($input['naturep'] != "paran")
                <th>{{ "D.R" }}</th>
                <th>{{ "% E" }}</th>
                <th>{{ "E % E.P" }}</th>
                <th>{{ "E % E.U" }}</th>
            @endif
        </tr>
        @foreach($entreprises as $entreprise)
            @continue($countrie->idPays != $entreprise->idPays)
            <tr>
                <th> {{ $exercices->count() > 2 ? $entreprise->Sigle : $entreprise->nomEntreprise}}</th>
                @foreach($exercices as $exercice)
                    @if($loop->first && $input['naturep'] == "paran")
                        @php($ep = $rcd($entreprise->idEntreprise,$exercice->exercice - 1,$countrie->bdPays))
                    @endif
                    @foreach($RATIOS as $r)
                        @continue($r[0] != $countrie->idPays || $r[1] != $exercice->exercice)
                        @foreach($RATIO_U as $ru)
                            @continue($ru[0] != $r[1])
                            <td style="background-color: #e2ebf0">{{ $e = $rcd($entreprise->idEntreprise,$exercice->exercice,$countrie->bdPays) }}</td>
                            <td style="background-color: #c2e9fb">
                                {{ $pp = ($r[2] != 0 ? ($e/$r[2] >= 0 ? round(($e/$r[2])*100,2) :(-1*round(($e/$r[2])*100,2)) ) : 0 )}}
                            </td>
                            <td style="background-color: #ede7f6;">
                                {{ $pu = ($ru[1] != 0 ? ($e/$ru[1] >=0 ? round(($e/$ru[1])*100,2) : (-1*round(($e/$ru[1])*100,2))) : 0) }}
                            </td>
                            @if($input['naturep'] == "paran")
                                <td style="color: {{ ($diff = $e - $ep) < 0 ? 'red' : (($diff = $e - $ep) > 0 ? 'green' : 'black')}}">{{ round($diff,2)}}</td>
                                <td>{{ $ep != 0 ? ($diff / $ep < 0 ? round(($diff / $ep )*100,2)*(-1) : round(($diff / $ep )*100,2)) : 0}}</td>
                                <td>{{ $r[3] != 0 ? (($diff / $r[3]) >= 0 ? round(($diff / $r[3])*100,2) :round(($diff / $r[3])*100,2)*(-1))  : 0 }}</td>
                                <td>{{ $ru[2] != 0 ? (($diff / $ru[2]) >= 0 ? round(($diff / $ru[2])*100,2) :round(($diff / $ru[2])*100,2)*(-1))  : 0 }}</td>
                            @endif
                        @endforeach
                        @php($ep = $e)
                        @endforeach
                @endforeach
                @if($input['naturep'] != "paran")
                    @foreach($RATIO_V as $rv)
                        @continue($rv[0] != $countrie->idPays)
                        @php($diff = ($rcd($entreprise->idEntreprise,$exercice2,$countrie->bdPays) - ($ep = $rcd($entreprise->idEntreprise,$exercice1,$countrie->bdPays))))
                        <td style="color: {{ $diff < 0 ? 'red' : ($diff > 0 ? 'green':'black')}}">{{ round($diff,2)}}</td>
                        <td>{{  $ep != 0 ? ($diff / $ep > 0 ? (round(($diff / $ep)*100,2)) : (-1 * round(($diff / $ep)*100,2))) : 0 }}</td>
                        <td>{{ $rv[1] != 0 ? ($diff / $rv[1] > 0 ? (round(($diff / $rv[1])*100,2)) : (-1 * round(($diff / $rv[1])*100,2))) : 0 }}</td>
                        <td>{{ $RATIO_VU[0] != 0 ? ($diff / $RATIO_VU[0] > 0 ? (round(($diff / $RATIO_VU[0])*100,2)) : (-1 * round(($diff / $RATIO_VU[0])*100,2))) : 0 }}</td>
                    @endforeach
                @endif
            </tr>
        @endforeach
    @endforeach
</table>
