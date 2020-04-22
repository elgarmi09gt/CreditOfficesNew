{{--1.Secteur précisé :
    -Pour chaque exercice en fonction du secteur afficher les classes corespondantes
    -Pour chaque exercice le nombre d'entreprise pour chaque Secteur, SousSecteur, Service et SousService
    -Pour chaque secteur ses soussercteurs
    -Pour chaque soussecteur ses services
    -Pour chaque service ses sous service
    -NB : Le nombre d'entreprise, brute, evolution brute, % evol pour chaque poste par sect, soussect, serv, sousserv
2.Secteur non précisé :
    -...--}}
@include('templates._assets')
{{--@dd($SousSecteursInSecteur($request)->request->get('exercice1'))--}}
<div class="">
    <div class="card">
        <div class="card-body">
        </div>
        <table class="table table-condensed" style="font-size: 12px">
            <thead style="text-align: center;">
            <tr style="background-color: #00b0ff; font-size: 14px;font-weight: bolder;
            font-family: 'Times New Roman', Times, serif;">
                <td colspan="2">{{ "Exercices" }}</td>
                @foreach($exercices as $exercice)
                    <th colspan="{{ $request->get('naturep') == 'paran' ? count($classes)*3 : count($classes) }}"
                        style="text-align: center;">
                        {{ $exercice->exercice }}</th>
                @endforeach
                @if($request->get('naturep') != 'paran')
                    <th colspan="{{ count($classes)*2 }}">{{ "Variation" }}</th>
                @endif
            </tr>
            <tr>
                <th rowspan="2">{{ "!!!!" }}</th>
                <th rowspan="2">Nombre Entreprise</th>
                @foreach($exercices as $exercice)
                    @foreach($classes as $classe)
                        <th colspan="{{ $request->get('naturep') == 'paran' ? 3 : 1}}"> {{ $classe->classe }}</th>
                    @endforeach
                @endforeach
                @if($request->get('naturep') != 'paran')
                    @foreach($classes as $classe)
                        <th colspan="2"> {{ $classe->classe }}</th>
                    @endforeach
                @endif
            </tr>
            <tr style="text-align: center;">
                @foreach($exercices as $exercice)
                    @foreach($classes as $classe)
                        <th>BRUTE</th>
                        @if($request->get('naturep') == 'paran')
                            <th>EV Brute</th>
                            <th>% EV</th>
                        @endif
                    @endforeach
                @endforeach
                @if($request->get('naturep') != 'paran')
                    @foreach($classes as $classe)
                        <th>Ev Brute</th>
                        <th>% EV</th>
                    @endforeach
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($secteurs as $secteur)
                <tr>
                    <th>{{ html_entity_decode( $secteur->secteur )}}</th>
                    <td>{{ $EntrepriseInSector($dbs,$secteur->id)}}</td>
                    @foreach($exercices as $exercice)
                        @foreach($classes as $classe)
                            <td>{{ $brute = $FormatBrut($BruteClasseSecteur($dbs,$classe->id,$secteur->id,$exercice->exercice) )}}</td>
                            @if($request->get('naturep') == 'paran')
                                <td>{{$diff = $brute - ($bruteP = $FormatBrut($BruteClasseSecteur($dbs,$classe->id,$secteur->id,$exercice->exercice-1)))}}</td>
                                <td>{{ $bruteP != 0 ? round(($diff/$bruteP)*100,2) : 0 }}</td>
                            @endif
                        @endforeach
                    @endforeach
                    @if($request->get('naturep') != 'paran')
                        @foreach($classes as $classe)
                            <td>{{'Diff brute'}}</td>
                            <td>{{'% EV'}}</td>
                        @endforeach
                    @endif
                </tr>
                {{-- sousSecteur in secteur--}}
                {{--            @php($soussecteurs = $SousSecteursInSecteur($dbs,$secteur->id))--}}
                @foreach($SousSecteursInSecteur($dbs,$secteur->id) as $sousecteur)
                    @continue(strtolower(html_entity_decode($sousecteur->sousecteur)) == strtolower(html_entity_decode($secteur->secteur)))
                    <tr>
                        <th style="color: #0d47a1;">{{ html_entity_decode($sousecteur->sousecteur) }}</th>
                        <td>{{ $EntrepriseInSousSector($dbs,$sousecteur->id)}}</td>
                        @foreach($exercices as $exercice)
                            @foreach($classes as $classe)
                                <td>{{ $brute = $FormatBrut($BruteClasseSousSecteur($dbs,$classe->id,$sousecteur->id,$exercice->exercice) )}}</td>
                                @if($request->get('naturep') == 'paran')
                                    <td>{{$diff = $brute - $FormatBrut($BruteClasseSousSecteur($dbs,$classe->id,$sousecteur->id,$exercice->exercice-1) )}}</td>
                                    <td>{{ $brute != 0 ? round(($diff/$brute)*100,2) : 0 }}</td>
                                @endif
                            @endforeach
                        @endforeach
                        @if($request->get('naturep') != 'paran')
                            @foreach($classes as $classe)
                                <td>{{'Diff brute'}}</td>
                                <td>{{'% EV'}}</td>
                            @endforeach
                        @endif
                    </tr>
                    {{--  services in sousSecteur--}}
                    {{--                @php($services = $ServicesInSousSecteur($dbs,$sousecteur->id))--}}
                    @foreach($ServicesInSousSecteur($dbs,$sousecteur->id) as $service)
                        @continue(strtolower(html_entity_decode($service->service)) == strtolower(html_entity_decode($sousecteur->sousecteur)))
                        <tr>
                            <th style="color: #b388ff;">{{ html_entity_decode($service->service) }}</th>
                            <td>{{ $EntrepriseInService($dbs,$service->id)}}</td>
                            @foreach($exercices as $exercice)
                                @foreach($classes as $classe)
                                    <td>{{ $brute = $FormatBrut($BruteClasseService($dbs,$classe->id,$service->id,$exercice->exercice) )}}</td>
                                    @if($request->get('naturep') == 'paran')
                                        <td>{{$diff = $brute - $FormatBrut($BruteClasseService($dbs,$classe->id,$service->id,$exercice->exercice-1) )}}</td>
                                        <td>{{ $brute != 0 ? round(($diff/$brute)*100,2) : 0 }}</td>
                                    @endif
                                @endforeach
                            @endforeach
                            @if($request->get('naturep') != 'paran')
                                @foreach($classes as $classe)
                                    <td>{{'Diff brute'}}</td>
                                    <td>{{'% EV'}}</td>
                                @endforeach
                            @endif
                        </tr>
                        {{-- sousServices in service--}}
                        {{--                    @php($sousservices = $SousServicesInService($dbs,$service->id))--}}
                        @foreach($SousServicesInService($dbs,$service->id) as $sousservice)
                            @continue(strtolower(html_entity_decode($service->service)) == strtolower(html_entity_decode($sousservice->souservice)))
                            <tr>
                                <th style="color: #0f6674;">{{ html_entity_decode($sousservice->souservice) }}</th>
                                <td>{{ $EntrepriseInSousService($dbs,$sousservice->id)}}</td>
                                @foreach($exercices as $exercice)
                                    @foreach($classes as $classe)
                                        <td>{{ $brute = $FormatBrut($BruteClasseSousService($dbs,$classe->id,$sousservice->id,$exercice->exercice) )}}</td>
                                        @if($request->get('naturep') == 'paran')
                                            <td>{{$diff = $brute - $FormatBrut($BruteClasseSousService($dbs,$classe->id,$sousservice->id,$exercice->exercice-1) )}}</td>
                                            <td>{{ $brute != 0 ? round(($diff/$brute)*100,2) : 0 }}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                                @if($request->get('naturep') != 'paran')
                                    @foreach($classes as $classe)
                                        <td>{{'Diff brute'}}</td>
                                        <td>{{'% EV'}}</td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>

    </div>
</div>