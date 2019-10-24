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
@if($exercice2 - $exercice1 == 0)
    @php($RATIO = [$exercice1,$roaPays($exercice1),$roaUEMOA($exercice1)])
@else
    @php($RATIO = [ [],[]])
    @for($j = 0; $j<=($exercice2 - $exercice1); $j++)
            @php ($RATIO [$j][0] = ($exercice1 + $j))
            @php ($RATIO [$j][1] = $roaPays($exercice1 + $j))
            @php ($RATIO [$j][2] = $roaUEMOA($exercice1 + $j))
    @endfor
@endif
<table class="table table-condensed container" style="font-size: 12px">
    <tr>
        <th>
            <div class="col" style="text-align: right; color: #3aa2ff">
                {{ $input['ratio'] }}
            </div>
        </th>
        @foreach($exercices as $exercice)
            <th colspan="3" style="background-color: #8ec5fc;">
                <div class="col">
                    {{ ' Pays : '. $roaPays($exercice->exercice) }}
                </div>
                <div class="col">
                    {{ ' UEMOA : '. $roaUEMOA($exercice->exercice) }}
                </div>
            </th>
        @endforeach
    </tr>
    <tr>
        <th>{{ 'Exercices' }}</th>
        @foreach($exercices as $exercice)
            <th colspan="3" style="text-align: center;"> {{ $exercice->exercice}}</th>
        @endforeach
    </tr>
    <tr>
        <th></th>
        @foreach($exercices as $exercice)
            <th>{{ " RATIO " }}</th>
            <th>{{ " % AU PAYS " }}</th>
            <th>{{ " % A UEMOA " }}</th>
        @endforeach
    </tr>
    @if($input['localite'] == 'pays')
        @foreach($entreprises as $entreprise)
            <tr>
                <th> {{ $entreprise->nomEntreprise }}</th>
                @foreach($exercices as $exercice)
                    @if($exercice2 - $exercice1 > 0)
                        @foreach($RATIO as $r)
                            @continue($r[0] != $exercice->exercice)
                            <th style="background-color: #e2ebf0">{{ $e = $roa($entreprise->idEntreprise,$exercice->exercice) }}</th>
                            <th style="background-color: #c2e9fb">
                                {{ $r[1] != 0 ? round(($e/$r[1])*100,2) : 0 }}
                            </th>
                            <th style="background-color: #ede7f6;">
                                {{ $r[2] != 0 ? round(($e/$r[2])*100,2) : 0 }}
                            </th>
                        @endforeach
                    @else
                        @continue($RATIO[0] != $exercice->exercice)
                        <th style="background-color: #e2ebf0">{{ $e = $roa($entreprise->idEntreprise,$exercice->exercice) }}</th>
                        <th style="background-color: #c2e9fb">
                            {{ $RATIO[1] != 0 ? round(($e/$RATIO[1])*100,2) : 0 }}
                        </th>
                        <th style="background-color: #ede7f6;">
                            {{ $RATIO[2] != 0 ? round(($e/$RATIO[2])*100,2) : 0 }}
                        </th>
                    @endif
                @endforeach
            </tr>
        @endforeach
    @endif
</table>
