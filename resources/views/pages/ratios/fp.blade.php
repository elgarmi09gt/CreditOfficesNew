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
@foreach($Countries as $countrie) {{-- For Any Country Calculate fondPropre for either Year --}}
    @foreach($exercices as $exercice)
        @php($RATIO[0][0] = $countrie->idPays)
        @php($RATIO[0][1] = $exercice->exercice)
        @php($RATIO[0][2] = (int)$fondProprePays($exercice->exercice,$countrie->bdPays)->total)
        @if($input['naturep']=='paran') {{-- Evolution if By Year--}}
            @php($RATIO[0][3] = (int) ($fondProprePays($exercice->exercice,$countrie->bdPays)->total - (int) $fondProprePays($exercice->exercice-1,$countrie->bdPays)->total))
        @endif
        @php($RATIOS = $RATIOS->concat($RATIO))
    @endforeach
   @php($RV[0][0] = $countrie->idPays)
   @php($RV[0][1] = (int) $fondProprePays($exercice2,$countrie->bdPays)->total - $fondProprePays($exercice1,$countrie->bdPays)->total)
    @php($RATIO_V = $RATIO_V->concat($RV))
@endforeach
@foreach($exercices as $exercice) {{-- Calculate fondPropre For UEMOA for etheir YEAR --}}
    @php ($RU[0][0] = ($exercice->exercice))
    @php ($RU[0][1] = $fondPropreUEMOA($exercice->exercice)->total)
    @if($input['naturep'] == 'paran') {{-- UEMOA Evolution If By YEAR --}}
        @php($RU[0][2] = (int) $fondPropreUEMOA($exercice->exercice)->total - $fondPropreUEMOA($exercice->exercice-1)->total)
    @endif
    @php($RATIO_U = $RATIO_U->concat($RU))
@endforeach
@if($input['naturep'] != 'paran')
    @php($RATIO_VU [] = (int)($fondPropreUEMOA($exercice2)->total - $fondPropreUEMOA($exercice1)->total))
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
                        <th colspan="{{$input['naturep'] == 'paran' ? 7 : 3}}"
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
                    <div class="col">{{ 'Pays : '. (int)($fondProprePays($exercice2,$countrie->bdPays)->total - $fondProprePays($exercice1,$countrie->bdPays)->total)}}</div>
                    <div class="col">{{ 'UEMOA : '. (int)($fondPropreUEMOA($exercice2)->total - $fondPropreUEMOA($exercice1)->total)}}</div>
                </th>
            @endif
        </tr>
        <tr>
            <th>{{ 'Exercices' }}</th>
            @foreach($exercices as $exercice)
                <th colspan="{{$input['naturep'] == 'paran' ? 7 : 3}}"
                    style="text-align: center;"> {{ $exercice->exercice}}</th>
            @endforeach
            <th colspan="4"></th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
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
            <th></th>
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
                    @if($loop->first && $input['naturep'] == 'paran')
                        @php($ep = (int) $fondPropre($entreprise->idEntreprise,$exercice->exercice - 1,$countrie->bdPays)->total)
                    @endif
                    @foreach($RATIOS as $r)
                        @continue($r[0] != $countrie->idPays || $r[1] != $exercice->exercice)
                        @foreach($RATIO_U as $ru)
                            @continue($ru[0] != $r[1])
                            <th style="background-color: #e2ebf0">{{ $e = (int)$fondPropre($entreprise->idEntreprise,$exercice->exercice,$countrie->bdPays)->total }}</th>
                            <th style="background-color: #c2e9fb">
                                {{ $pp = ($r[2] != 0 ? ($e/$r[2] >= 0 ? round(($e/$r[2])*100,2) :(-1*round(($e/$r[2])*100,2)) ) : 0 )}}
                            </th>
                            <th style="background-color: #ede7f6;">
                                {{ $pu = ($ru[1] != 0 ? ($e/$ru[1] >=0 ? round(($e/$ru[1])*100,2) : (-1*round(($e/$ru[1])*100,2))) : 0) }}
                            </th>
                            @if($input['naturep'] == "paran")
                                <th style="color: {{ ($diff = $e - $ep) < 0 ? 'red' : (($diff = $e - $ep) > 0 ? 'green' : 'black')}}">{{ round($diff,2)}}</th>
                                <th>{{ $ep != 0 ? ($diff / $ep < 0 ? round(($diff / $ep )*100,2)*(-1) : round(($diff / $ep )*100,2)) : 0}}</th>
                                <th>{{ $r[3] != 0 ? (($diff / $r[3]) >= 0 ? round(($diff / $r[3])*100,2) :round(($diff / $r[3])*100,2)*(-1))  : 0 }}</th>
                                <th>{{ $ru[2] != 0 ? (($diff / $ru[2]) >= 0 ? round(($diff / $ru[2])*100,2) :round(($diff / $ru[2])*100,2)*(-1))  : 0 }}</th>
                            @endif
                        @endforeach
                        @php($ep = $e)
                        @endforeach
                @endforeach
                @if($input['naturep'] != "paran")
                    @foreach($RATIO_V as $rv)
                        @continue($rv[0] != $countrie->idPays)
                        @php($diff = (int)($fondPropre($entreprise->idEntreprise,$exercice2,$countrie->bdPays)->total - ($ep = $fondPropre($entreprise->idEntreprise,$exercice1,$countrie->bdPays)->total)))
                        <th style="color: {{ $diff < 0 ? 'red' : ($diff > 0 ? 'green':'black')}}">{{ round($diff,2)}}</th>
                        <th>{{  $ep != 0 ? ($diff / $ep > 0 ? (round(($diff / $ep)*100,2)) : (-1 * round(($diff / $ep)*100,2))) : 0 }}</th>
                        <th>{{ $rv[1] != 0 ? ($diff / $rv[1] > 0 ? (round(($diff / $rv[1])*100,2)) : (-1 * round(($diff / $rv[1])*100,2))) : 0 }}</th>
                        <th>{{ $RATIO_VU[0] != 0 ? ($diff / $RATIO_VU[0] > 0 ? (round(($diff / $RATIO_VU[0])*100,2)) : (-1 * round(($diff / $RATIO_VU[0])*100,2))) : 0 }}</th>
                    @endforeach
                @endif
            </tr>
        @endforeach
    @endforeach
</table>
