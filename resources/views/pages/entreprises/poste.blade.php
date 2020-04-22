@include('templates._assets')
<div class="">
    <hr>
    <div class="form-group row">
        <div class="col col-md-4 sm-4"
            style="text-align: center; color: #0000F0; font-style: italic; font-weight: bolder">
            {!! '<h3><strong>ENTREPRISE</strong></h3>'!!}
        </div>
        <div class="col col-md-4 sm-4"
            style="text-align: center; color: #0000F0; font-style: italic; font-weight: bolder">
            {!! '<h3><strong>POSTE</strong></h3>' !!}
        </div>
        <div class="col col-md-4 sm-4"
            style="text-align: center; color: #0000F0; font-style: italic; font-weight: bolder;">
            {!! '<h3><strong>PERIODE</strong></h3>' !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="col col-md-4 sm-4" style="text-align: center;">
            {!! '<h4><strong>'.$input['idEntreprise'].'</strong></h4>'!!}
        </div>
        <div class="col col-md-4 sm-4" style="text-align: center;">
            {!! '<h4><strong>'.$input['poste'].'</strong></h4>' !!}
        </div>
        <div class="col col-md-4 sm-4" style="text-align: center;">
            @if($input['naturep'] == 'variation')
            {!! '<h4><strong>'.$input['exercice1'] .' - '.$input['exercice2']. '</strong></h4>' !!}
            @else
            {!! '<h4><strong>DE '.$input['exercice1'].' À '.$input['exercice2'].' </strong></h4>' !!}
            @endif
        </div>
    </div>
    <hr>
    <br>
    <table class="table table-condensed table-bordered" style="font-size: 12px">
        <thead>
            <tr style="font-size: 14px">
                <th style="text-align: right;">Exrecices</th>
                @if($input['naturep'] == 'variation')
                @if($input['localite'] == 'uemoa')
                @php($colspan = 11)
                @else
                @php($colspan = 7)
                @endif
                @else
                @if($input['localite'] == 'uemoa')
                @php($colspan = 13)
                @else
                @php($colspan = 9)
                @endif
                @endif
                @foreach($exercices as $exercice)
                <th style="background-color: #66CCFF; text-align: center; " colspan="{{ $colspan }}">
                    {{ $exercice->exercice }} </th>
                @endforeach
                @if ($input['naturep'] == 'variation')
                <th colspan="2">Variation</th>
                @endif
            </tr>
            <tr style="text-align: center">
                <th></th>
                @foreach($exercices as $exercice)
                <th colspan="2">{{ $infoEntreprises->sigle }}</th>
                <th colspan="2">{{ 'PAYS' }}</th>
                @if($input['localite'] == 'uemoa')
                <th colspan="2">UEMOA</th>
                @endif
                <th colspan="{{ $input['localite'] == 'uemoa' ? 5 : 3 }}" style="background-color: #1fffac">Indicateur
                </th>
                @if ($input['naturep'] != 'variation')
                <th colspan="2">Variation</th>
                @endif
                @endforeach
                @if ($input['naturep'] == 'variation')
                <th colspan="2">Variation</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr style="font-family: 'Times New Roman'; font-size:small">
                <th>{{ $input['poste'] }}</th>
                @php($nature = $getNaturePoste($dbs,$posteid)->nature)
                @php($systeme = $getNaturePoste($dbs,$posteid)->systemeClasse)
                @php($type = $getNaturePoste($dbs,$posteid)->typeClasse)
                @foreach($exercices as $exercice)
                @if ($loop->first)
                @php($bp0 = $FormatBrut($getBruteRubrique($dbs,$posteid,$entrepriseid,$exercice->exercice-1)))
                @endif

                {{-- getBruteRubrique : valeur du rubrique en question pour entreprise --}}
                <td>{{ $bp = $FormatBrut($getBruteRubrique($dbs,$posteid,$entrepriseid,$exercice->exercice)) }}</td>

                {{--getBruteSameNatureRubrique : valeur du total de meme nature que la rubrique en question pour entreprise --}}
                <td>{{ $bpsn = $FormatBrut($getBruteNature($dbs,$nature,$systeme, $type,$entrepriseid,$exercice->exercice)) }}
                </td>
                <td>{{ $bpp = $FormatBrut($getBruteRubriquePays($dbs,$posteid,$exercice->exercice)) }}</td>
                <td>{{ $bppsn = $FormatBrut($getBruteNaturePays($dbs,$nature, $systeme, $type,$exercice->exercice)) }}
                </td>
                @if($input['localite'] == 'uemoa')
                <td>{{ $bpu = $FormatBrut($getBruteRubriqueUEMOA('bic_uemoa',$posteid,$exercice->exercice)) }}</td>
                <td>{{ $bpusn = $FormatBrut($getBruteNatureUEMOA('bic_uemoa',$nature, $systeme, $type,$exercice->exercice)) }}
                </td>
                @endif
                <td> {{ $bpsn != 0 ? round(($bp / $bpsn)*100,2) : 0 }} </td>
                <td> {{ $bpp != 0 ? round(($bp / $bpp)*100,2) : 0 }} </td>
                <td> {{ $bppsn != 0 ? round(($bp / $bppsn)*100,2) : 0}} </td>
                @if($input['localite'] == 'uemoa')
                <td> {{ $bpu != 0 ? round(($bp / $bpu)*100,2) : 0 }} </td>
                <td> {{ $bpusn != 0 ? round(($bp / $bpusn)*100,2) : 0 }} </td>
                @endif
                @if ($input['naturep'] != 'variation')
                <th> {{ $d = ($bp - $bp0)  }} </th>
                <th> {{ $bp0 != 0 ? round(($d / $bp0)*100,2) : 0 }} </th>
                @php($bp0 = $bp)
                @endif
                @endforeach
                @if ($input['naturep'] == 'variation')
                <th> {{ $d = ($bp - $bp0) }}</th>
                <th> {{ $bp0 != 0 ? round(($d / $bp0)*100,2) : 0 }} </th>
                @endif
            </tr>
        </tbody>
    </table>
</div>