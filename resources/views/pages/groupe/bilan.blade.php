@include('templates._assets')
@if($inputs['exercice1'] > $inputs['exercice2'])
@php
$exercice1 = $inputs['exercice2'];
$exercice2 = $inputs['exercice1'];
@endphp
@else
@php($exercice1 = $inputs['exercice1'])
@php($exercice2 = $inputs['exercice2'])
@endif
<table class="table table-condensed" style="font-size: 12px">
    <thead>
        @if($inputs['naturep'] == 'variation')
        <tr>
            <th style="text-align: right;" colspan="3"> </th>
            <th style="text-align: center; " colspan="2">Premier Exercice : {{ $exercice1 }}</th>
            <th style="text-align: center;background-color: #66CCFF" colspan="2"> Dernier Exercice :
                {{ $exercice2 }}</th>
            <th style="text-align: center;" colspan="2"> Variation</th>
        </tr>
        @else
        <tr style="font-size: 14px">
            <th style="text-align: right;" colspan=" {{ !$inputs['groupe'] ? 2 : 3 }}">Exrecices : </th>
            @for ($exo = $exercice1; $exo<=$exercice2; $exo++ ) <th colspan="4"
                style="background-color: #66CCFF; text-align: center; ">
                {{ $exo }}</th>
                @endfor
        </tr>
        @endif
        <tr style="text-align: center;">
            <th> {{ 'Groupe'}} </th>
            <th> {{'Origine'}} </th>
            @if ($inputs['groupe'])
            <th> {{ 'Entreprise'}} </th>
            @endif
            @foreach($exercices as $exercice)
            <th>{{ 'Bilan' }}</th>
            <th>{{'P.D.M'}}</th>
            @if($inputs['naturep'] == 'paran')
            <th>{{'Evolution'}} </th>
            <th>{{'% Evolution'}} </th>
            @endif
            @endforeach
            @if($inputs['naturep'] == 'variation')
            <th>{{'Evolutions'}}</th>
            <th>{{'% Evolution'}}</th>
            @endif
        </tr>
        {{-- Parcours Group and display info of the group --}}
        @foreach ($groupes as $groupe)
        <tr style="background-color : lightblue">
            <th>{{ $groupe->groupe}} </th>
            <th>{{ $groupe->origine}} </th>
            @if ($inputs['groupe'])
            <th> </th>
            @endif
            @foreach($exercices as $exercice)
            @if ($loop->first && $exercice->exercice != 2000)
            {{-- This is the first iteration --}}
            @php($bgp = (int) $getBianGroupe($groupe->idGroupe, $exercice->exercice-1))
            @endif
            @foreach ($bilanUEMOA as $item)
            @continue($item->exercice != $exercice->exercice)
            {{-- Bilan and Market Part --}}
            <th> {{  $bg = (int) $getBianGroupe($groupe->idGroupe, $exercice->exercice)}} </th>
            <th> {{ $item->total != 0 ? round(($bg/$item->total)*100,2) : 0}} </th>
            @if($inputs['naturep'] == 'paran')
            {{-- Evolution --}}
            <th style="color :{{ ($diff =($bg - $bgp)) < 0 ? 'red' : ( $diff == 0 ? 'black' : ' green') }}"> {{ $diff }}
            </th>
            <th> {{ $bgp != 0 ? ($res = (round(($diff/$bgp)*100,2))) >= 0 ? $res : (-1)*$res : 0}} </th>
            @endif
            @endforeach
            @php( $bgp = $bg)
            @endforeach
            @if($inputs['naturep'] == 'variation')
            {{-- Evolution --}}
            <th
                style="color :{{ ($diff =(  (int) $getBianGroupe($groupe->idGroupe, $exercice2) - 
                        (($bg1 = (int) $getBianGroupe($groupe->idGroupe, $exercice1))))) < 0 ? 'red' : ( $diff == 0 ? 'black' : ' green') }}">
                {{ $diff }} </th>
            <th> {{ $bg1 != 0 ? ($res = (round(($diff/$bg1)*100,2))) >= 0 ? $res : (-1)*$res : 0}} </th>
            @endif
        </tr>
        @if($inputs['groupe'])
        {{-- Display entreprise of group --}}
        @foreach ($entreprises as $entreprise)
        @continue($entreprise->idGroupe != $groupe->idGroupe)
        <tr>
            <th> </th>
            <th> </th>
            <th>{{ ($exercice2 - $exercice1) > 2 ?
                                $getEntrepriseNameHelper($entreprise->idPays,$entreprise->idEntreprise)
                                ->Sigle
                            : $getEntrepriseNameHelper($entreprise->idPays,$entreprise->idEntreprise)
                            ->nomEntreprise
                            }}</th>
            @foreach($exercices as $exercice)
            @if ($loop->first && $exercice->exercice != 2000)
            {{-- This is the first iteration --}}
            @php($bep = (int) $getBilanEntreprise($entreprise->idPays,$entreprise->idEntreprise,
            $exercice->exercice - 1))
            @endif
            {{-- Bilan and Market Part of entreprise in the group--}}
            <th> {{ $be = (int) $getBilanEntreprise($entreprise->idPays,
                                $entreprise->idEntreprise, $exercice->exercice)}} </th>
            <th> {{ ($bg = $getBianGroupe($groupe->idGroupe, $exercice->exercice) ) != 0 ? 
                                round(($be/$bg)*100,2) : 0 }} </th>
            @if($inputs['naturep'] == 'paran')
            {{-- Evolution --}}
            <th style="color :{{ ($diff =($be - $bep)) < 0 ? 'red' : ( $diff == 0 ? 'black' : ' green') }}"> {{ $diff }}
            </th>
            <th> {{ $bep != 0 ? ($res = (round(($diff/$bep)*100,2))) >= 0 ? $res : (-1)*$res : 0}} </th>
            @endif
            @php( $bep = $be)
            @endforeach
            @if($inputs['naturep'] == 'variation')
            {{-- Evolution --}}
            <th
                style="color :{{ ($diff =(  (int) $getBilanEntreprise($entreprise->idPays,
                                $entreprise->idEntreprise, $exercice2) - 
                                (($bg1 = (int) $getBilanEntreprise($entreprise->idPays,
                                $entreprise->idEntreprise, $exercice1))))) < 0 ? 'red' : ( $diff == 0 ? 'black' : ' green') }}">
                {{ $diff }} </th>
            <th> {{ $bg1 != 0 ? ($res = (round(($diff/$bg1)*100,2))) >= 0 ? $res : (-1)*$res : 0}} </th>
            @endif
        </tr>
        @endforeach

        @endif
        @endforeach
    </thead>
</table>