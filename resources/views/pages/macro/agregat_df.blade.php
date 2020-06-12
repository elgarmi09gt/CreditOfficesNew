@include('templates._assets')
@php
    $BruteREF = [];
@endphp
<div class="">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" style="font-size: 12px">
                @if(count($localite))
                    <thead style="text-align: center;">
                    <tr style="background-color: #00b0ff; font-size: 14px;font-weight: bolder;
            font-family: 'Times New Roman', Times, serif;">
                        <td style="width: 5em">{{ "Exercices" }}</td>
                        @foreach($exercices as $exercice)
                            <th colspan="{{ $request->get('naturep') == 'paran' ? 3 : 1 }}"
                                style="text-align: center;">
                                {{ $exercice->exercice }}</th>
                        @endforeach
                        @if($request->get('naturep') != 'paran')
                            <th colspan="2">{{ "Variation" }}</th>
                        @endif
                    </tr>
                    <tr style="text-align: center;">
                        <th>{{ "PAYS" }}</th>
                        @foreach($exercices as $exercice)
                            <th>{{"BRUTE"}}</th>
                            @if($request->get('naturep') == 'paran')
                                <th>{{"EV Brute"}}</th>
                                <th>{{"% EV"}}</th>
                            @endif
                        @endforeach
                        @if($request->get('naturep') != 'paran')
                            <th>{{"EV Brute"}}</th>
                            <th>{{"% EV"}}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($macros as $macro)
                        <h3 style="text-align: center; color: blue"> {{ 'Analyse sur '.$macro->macro.' dans différents Pays' }}</h3>
                        <tr style="text-align: center;">
                            <th>{{ $pays->pays }}</th>
                            @foreach($exercices as $exercice)
                                @php($total = $FormatBrutMacro($getBruteMacro($pays->bdPays,$macro->id,$exercice->exercice)))
                                @php(
                                $BruteREF [] = ['exercice' => $exercice->exercice,
                                    'idMacro' => $macro->id,
                                    'total' => $total
                                   ])
                                <th>{{ $total }}</th>
                                @if($request->get('naturep') == 'paran')
                                    <th>{{"0.00"}}</th>
                                    <th>{{"0.00"}}</th>
                                @endif
                            @endforeach
                            @if($request->get('naturep') != 'paran')
                                <th>{{"0.00"}}</th>
                                <th>{{"0.00"}}</th>
                            @endif
                        </tr>
                        @foreach($countries as $country)
                            @continue($country->pays == $pays->pays)
                            <tr style="text-align: center;">
                                <th>{{ $country->pays }}</th>
                                @foreach($exercices as $exercice)
                                    @foreach($BruteREF as $brf)
                                        @continue($brf['exercice'] != $exercice->exercice)
                                        <th>{{ $m = $FormatBrutMacro($getBruteMacro($country->bdPays,$macro->id,$exercice->exercice)) }}</th>
                                        @if($request->get('naturep') == 'paran')
                                            <th style=" color : {{ ($diff = ($m - $brf['total'])) < 0 ? 'red' : 'green'  }}">{{ round($diff,3)}}</th>
                                            <th>{{ $brf['total'] != 0 ? (($diff > 0 && $brf['total'] > 0) ? round(($diff / $brf['total'])*100,3) : (-1)*round(($diff / $brf['total'])*100,3)) : '0.00' }}</th>
                                        @endif
                                    @endforeach
                                @endforeach
                                @if($request->get('naturep') != 'paran')
                                    <th>{{"0.00"}}</th>
                                    <th>{{"0.00"}}</th>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>