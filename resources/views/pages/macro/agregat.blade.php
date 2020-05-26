@include('templates._assets')
@php
    $BruteSousSecteur = [];
    $BruteUEMOA = []
@endphp
@if($uemoa)
    @foreach($macros as $idmacro)
        @foreach($exercices as $exo)
            @php(
                $BruteUEMOA [] = ['exercice' => $exo->exercice,
                    'idMacro' => $idmacro->id,
                    'total' => $FormatBrutMacro($getBruteMacroUEMOA($idmacro->id,$exo->exercice))
                   ])
        @endforeach
    @endforeach
@endif
<div class="">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" style="font-size: 12px">
                @if(count($localite))
                    <thead style="text-align: center;">
                    <tr style="background-color: #00b0ff; font-size: 14px;font-weight: bolder;
            font-family: 'Times New Roman', Times, serif;">
                        <td style="width: 5em" colspan="2">{{ "Exercices" }}</td>
                        @foreach($exercices as $exercice)
                            <th colspan="{{ $request->get('naturep') == 'paran' ? ($uemoa ? 4 : 3) : ($uemoa ? 2 : 1) }}"
                                style="text-align: center;">
                                {{ $exercice->exercice }}</th>
                        @endforeach
                        @if($request->get('naturep') != 'paran')
                            <th colspan="2">{{ "Variation" }}</th>
                        @endif
                    </tr>
                    <tr style="text-align: center;">
                        <th>{{ "PAYS" }}</th>
                        <th style="width: 1000px">{{ "Libelle" }}</th>
                        @foreach($exercices as $exercice)
                            <th>{{"BRUTE"}}</th>
                            @if($uemoa)
                                <th>{{ "PDM % U" }}</th>
                            @endif
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
                        @foreach($countries as $country)
                            <tr style="text-align: center;">
                                <th class="flex-md-grow-0">{{ strtoupper(html_entity_decode($country->pays)) }}</th>
                                <td class="flex-1"
                                    style="width:100px; text-align: left;">{{ html_entity_decode($macro->macro) }}</td>
                                @foreach($exercices as $exercice)
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($bruteMPcdt = $FormatBrutMacro($getBruteMacro($country->bdPays, $macro->id, $exercice->exercice-1)))
                                    @endif
                                    @if($loop->first && $input['naturep'] != 'paran')
                                        @php($exercice1 = $exercice->exercice)
                                    @endif
                                    @if($loop->last && $input['naturep'] != 'paran')
                                        @php($exercice2 = $exercice->exercice)
                                    @endif
                                    <td> {{ $bruteM = $FormatBrutMacro($getBruteMacro($country->bdPays, $macro->id, $exercice->exercice)) }}</td>
                                    @if($uemoa)
                                        @foreach($BruteUEMOA as $bu)
                                            @continue($bu['exercice'] != $exercice->exercice || $bu['idMacro'] !=  $macro->id)
                                            <th> {{ $bu['total'] != 0 ? round(($bruteM / $bu['total'])*100,3) : '0.000'}}</th>
                                        @endforeach
                                    @endif
                                    @if($request->get('naturep') == 'paran')
                                        <th> {{ $diff = round(($bruteM - $bruteMPcdt),2) }}</th>
                                        <th style="color: {{ ($diff == 0 || $bruteMPcdt == 0) ? '' : (($diff > 0 && $bruteMPcdt > 0) ? 'green' : 'red') }}">
                                            {{ $bruteMPcdt != 0 ? (($res = round(($diff / $bruteMPcdt)*100, 3)) < 0 ? (-1)*$res : $res ) : '0.000' }}</th>
                                    @endif
                                    @php($bruteMPcdt = $bruteM)
                                @endforeach
                                @if($request->get('naturep') != 'paran')
                                    <th> {{ $diff = ($FormatBrutMacro($getBruteMacro($country->bdPays, $macro->id, $exercice2)) -
                                    ($bruteMP = $FormatBrutMacro($getBruteMacro($country->bdPays, $macro->id, $exercice1)))) }}</th>
                                    <th> {{ $bruteMP != 0 ? round(($diff / $bruteMP)*100,2) : '0.00' }}</th>
                                @endif
                            </tr>
                        @endforeach
                        @if($uemoa)
                            <tr style="text-align: center;">
                                <th class="flex-md-grow-0">{{ "UEMOA" }}</th>
                                <td class="flex-1"
                                    style="width:100px; text-align: left;">{{ html_entity_decode($macro->macro) }}</td>
                                @foreach($BruteUEMOA as $bruteU)
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($bruteUPcdt = $FormatBrutMacro($getBruteMacroUEMOA($macro->id, $exercice->exercice-1)))
                                    @endif
                                    @if($loop->first && $input['naturep'] != 'paran')
                                        @php($exercice1 = $exercice->exercice)
                                    @endif
                                    @if($loop->last && $input['naturep'] != 'paran')
                                        @php($exercice2 = $exercice->exercice)
                                    @endif
                                    <td> {{ $bu = $bruteU['total'] }}</td>
                                    <th> {{ '100.00' }}</th>
                                    @if($request->get('naturep') == 'paran')
                                        <th> {{ $diff = round(($bu - $bruteUPcdt),2) }}</th>
                                        <th style="color: {{ ($diff == 0 || $bruteMPcdt == 0) ? '' : (($diff > 0 && $bruteMPcdt > 0) ? 'green' : 'red') }}">
                                            {{ $bruteUPcdt != 0 ? (($res = round(($diff / $bruteUPcdt)*100, 3)) < 0 ? (-1)*$res : $res ) : '0.000' }}</th>
                                    @endif
                                    @php($bruteUPcdt = $bu)
                                @endforeach
                                @if($request->get('naturep') != 'paran')
                                    @foreach($BruteUEMOA as $b)
                                        @if($loop->first)
                                            @php($firts = $b['total'])
                                        @else
                                            @php($lasts = $b['total'])
                                        @endif
                                    @endforeach
                                    <th> {{ $diff = round(($lasts -  $firts),3) }}</th>
                                    <th> {{ $firts != 0 ? (($res = round(($diff / $firts)*100, 3)) < 0 ? (-1)*$res : $res ) : '0.000'  }}</th>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                @else
                    <script> alert("Selectionne une localité")</script>
                @endif
            </table>
        </div>
    </div>
</div>