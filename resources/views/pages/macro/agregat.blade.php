@include('templates._assets')
<div class="">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" style="font-size: 12px">
                <thead style="text-align: center;">
                <tr style="background-color: #00b0ff; font-size: 14px;font-weight: bolder;
            font-family: 'Times New Roman', Times, serif;">
                    <td style="width: 5em" colspan="2">{{ "Exercices" }}</td>
                    @foreach($exercices as $exercice)
                        <th colspan="{{ $request->get('naturep') == 'paran' ? ($request->get('localite') == 'uemoa' ? 6 : 4) : ($request->get('localite') != 'uemoa' ? 2 : 4) }}"
                            style="text-align: center;">
                            {{ $exercice->exercice }}</th>
                    @endforeach
                    @if($request->get('naturep') != 'paran')
                        <th colspan="{{ 2 }}">{{ "Variation" }}</th>
                    @endif
                </tr>
                <tr style="text-align: center;">
                    <th>{{ "Code" }}</th>
                    <th style="width: 1000px">{{ "Libelle" }}</th>
                    @foreach($exercices as $exercice)
                        <th>{{"BRUTE"}}</th>
                        <th>{{ "PDM" }}</th>
                        @if($request->get('localite') == 'uemoa')
                            <th>{{ "PDM % U" }}</th>
                            <th>{{ "PDM % SSU" }}</th>
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
                @if(count($soussecteurs) )
                    @foreach($soussecteurs as $soussecteur)
                        @foreach($macroInSouSecteurs($dbs,$soussecteur->id) as $macro)
                            <tr style="text-align: center;">
                                <td class="flex-md-grow-0">{{ html_entity_decode($macro->codeMacro) }}</td>
                                <td class="" style="width:100px; text-align: left;">{{ html_entity_decode($macro->macro) }}</td>
                                @foreach($exercices as $exercice)
                                    @if($loop->first && $input['naturep'] == 'paran')
                                        @php($bruteMPcdt = $FormatBrutMacro($getBruteMacro($dbs, $macro->id, $exercice->exercice-1)))
                                    @endif
                                    <td> {{ $bruteM = $FormatBrutMacro($getBruteMacro($dbs, $macro->id, $exercice->exercice)) }}</td>
                                    <th> {{ ($bruteMSS = $FormatBrutMacro($getBruteSouSecteurAgreat($dbs,$soussecteur->id,$exercice->exercice))) != 0 ?
                                round(($bruteM / $bruteMSS)*100,2) : '0.000'}}</th>
                                    @if($request->get('localite') == 'uemoa')
                                        <th> {{ ($bruteMU = $FormatBrutMacro($getBruteMacroUEMOA($macro->id, $exercice->exercice))) != 0 ?
                                    round(($bruteM / $bruteMU)*100,2) : '0.000' }} </th>
                                        <th> {{ ($bruteSSU = $FormatBrutMacro($getBruteSouSecteurAgreatUEMOA($soussecteur->id,$exercice->exercice-1))) != 0 ?
                                    round(($bruteM / $bruteSSU)*100,2) : '0.000' }}</th>
                                    @endif
                                    @if($request->get('naturep') == 'paran')
                                        {{--                                        style="color: {{ ($diff = round(($bruteM - $bruteMPcdt)*100,2)) != 0 ? ($diff > 0 ? 'green' : 'red') : ''}}"--}}
                                        <th> {{ $diff = round(($bruteM - $bruteMPcdt),2) }}</th>
                                        <th style="color: {{ ($diff == 0 || $bruteMPcdt == 0) ? '' : (($diff > 0 && $bruteMPcdt > 0) ? 'green' : 'red') }}">
                                            {{ $bruteMPcdt != 0 ? (($res = round(($diff / $bruteMPcdt)*100, 3)) < 0 ? (-1)*$res : $res ) : '0.000' }}</th>
                                    @endif
                                    @php($bruteMPcdt = $bruteM)
                                @endforeach
                            </tr>
                            @if($request->get('naturep') != 'paran')
                                <th></th>
                                <th></th>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <script>
                        alert("Veillez selectionner un sous-secteur dans la secteur choisi !!!")
                    </script>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>