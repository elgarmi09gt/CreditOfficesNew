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
@php($idE = explode('-',$inputs['idEntreprise'])[0])
@php($DATA = collect())
@foreach($RESULTATS as $Res)
	@php($fp=$Res[1].'Pays')
	@php($fu=$Res[1].'UEMOA')
	@foreach($exercices as $exercice)
		@php($D[0][0] = $exercice->exercice)
		@php($D[0][1] = substr($Res[0], 4))
		@php($D[0][2] = $$fp($exercice->exercice,$dbs))
		@php($D[0][3] = $$fu($exercice->exercice))

		@php($DATA = $DATA->concat($D))
	@endforeach
@endforeach
<div class="">
    <div class="card">
		<div class="card-body">
            @foreach($infoEntreprises as $infoEntreprise )
                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size:medium">
                    <div class="col-md-6">
                        Numero Registre :
                        <span>{{$infoEntreprise->numRegistre}}</span>
                    </div>
                    <div class="col-md-6">
                        Secteur :
                        <span>{{$infoEntreprise->nomSecteur}}</span>
                    </div>
                </div>

                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355BF; font-size: medium">
                    <div class="col-md-6">
                        Raison Sociale :
                        <span>
                             {{ $infoEntreprise->nomEntreprise }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        Activité principal :
                        <span>
                            {{ $infoEntreprise->nomsouSecteur }}
                        </span>
                    </div>
                </div>
                <div class="form-row" style="font-family: 'Times New Roman'; color: #0355AF; font-size: medium">
                    <div class="col-md-6">
                        Adresse :
                        <span>{{$infoEntreprise->Adresse}}</span>
                    </div>
                    <div class="col-md-6">
                        Services :
                        <span>{{$infoEntreprise->nomService}}</span>
                    </div>
                </div>
            @endforeach
        </div>
		<table class="table table-condensed" style="background-color: #F8F9F9">
			<thead style="font-size: {{ $exercices->count() > 1 ? '10px' : '12px' }}">
				<tr >
			        <div class="col-md-6">
			        	<th style="text-align: right;"> {{'EXERCICES'}} </th>
			        </div>
			        <div class="col-md-6">
			        	@foreach($exercices as $exercice)
			            <th colspan="{{ ($inputs['naturep'] == 'paran') ? 15 : 6 }}" style="text-align: center;">{{ $exercice->exercice }}</th>
			        @endforeach
			        @if($inputs['naturep'] != 'paran')
			        	<th colspan="9" style="text-align: center; background: #AED6F1"> {{ 'VARIATIONS'}} </th>
			        @endif
			        </div>
		    	</tr>
		    	<tr >
		        	<div class="col-md-6">
			        	<th > </th>
			        </div>
			        <div class="col-md-6">
				        @foreach($exercices as $exercice)
				        	<th>{{'Brute'}}</th>
				        	<th>{{'B.P'}}</th>
				            <th>{{'%.P'}}</th>
				            <th>{{'B.U'}}</th>
				            <th>{{'%.E.U'}}</th>
				            <th>{{'%.P.U'}}</th>
				            @if($inputs['naturep'] == 'paran')
				            	<th>{{'D.B'}}</th>
				            	<th>{{'%.EV'}}</th>
				            	<th>{{'D.B.P'}}</th>
				            	<th>{{'%.EV.P'}}</th>
				            	<th>{{'D.B.U'}}</th>
				            	<th>{{'%.EV.U'}}</th>
				            	<th>{{'E.E.P'}}</th>
				            	<th>{{'E.E.U'}}</th>
				            	<th>{{'E.P.U'}}</th>
				            @endif
				        @endforeach
				        @if($inputs['naturep'] != 'paran')
				            <th>{{'D.B'}}</th>
				            <th>{{'%.EV'}}</th>
				            <th>{{'D.B.P'}}</th>
				            <th>{{'%.EV.P'}}</th>
				            <th>{{'D.B.U'}}</th>
				            <th>{{'%.EV.U'}}</th>
				            <th>{{'E.E.P'}}</th>
				            <th>{{'E.E.U'}}</th>
				            <th>{{'E.P.U'}}</th>
				        @endif
				    </div>
		    	</tr>
			</thead>
			<tbody style="font-size: {{ $exercices->count() > 1 ? '8px' : '10px' }}">
		    @foreach($supclasses as $supclasse)
		    	@foreach($RESULTATS as $r)
					@continue(substr($r[0], 4) != $supclasse->nomSupClasse)
				<tr>
					<th class="col col-md-4"> {{ $r[0]}} </th>
					@foreach($exercices as $exercice)
						@foreach($DATA as $data)
							@continue($data[1] != $supclasse->nomSupClasse || $data[0] != $exercice->exercice)
							@php($f=$r[1])
							@php($fp=$r[1].'Pays')
							@php($fu=$r[1].'UEMOA')
			            	<th> {{ $bsup =  $$f($idE,$exercice->exercice,$dbs) }} </th>
			            	<th> {{ $bsupp = $data[2] }}</th>
				            <th> {{ $bsupp  != 0 ? ((($sss = round(($bsup/$bsupp)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}} </th>
				            <th> {{ $bsupu = $data[3] }} </th>
				            <th> {{ $bsupu != 0 ? ((($sss = round(($bsup/$bsupu)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}} </th>
				            <th> {{ $bsupu != 0 ? ((($sss = round(($bsupp/$bsupu)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}} </th>
				            @if($inputs['naturep'] == 'paran')
				            	@if ($loop->parent->first)
				            		@php($bsupP = $$f($idE,$exercice->exercice-1,$dbs))
				            		@php($bsuppP = $$fp($exercice->exercice-1,$dbs))
				            		@php($bsupuP = $$fu($exercice->exercice-1))
				            	@endif
				            	<th style="color: {{ ($diff = ($bsup - $bsupP)) < 0 ? 'red' : ($diff > 0 ? 'green' : '')}}">{{ $diff  }}</th>
				            	<th>{{ $bsupP != 0 ? ((($sss = round(($diff/$bsupP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
				            	<th style="color: {{ ($diffP = ($bsupp - $bsuppP)) < 0 ? 'red' : ($diffP > 0 ? 'green' : '')}}">{{ $diffP }}</th>
				            	<th>{{ $bsuppP != 0 ? ((($sss = round(($diff/$bsuppP)*100,2)) >= 0 ? $sss : (-1)*$sss)): 0 }}</th>
				            	<th style="color: {{ ($diffU = ($bsupu - $bsupuP)) < 0 ? 'red' : ($diffU > 0 ? 'green' : '')}}">{{ $diffU }}</th>
				            	<th>{{ $bsupuP != 0 ? ((($sss = round(($diff/$bsupuP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
				            	<th>{{ $diffP != 0 ? ((($sss = round(($diff/$diffP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
				            	<th>{{ $diffU != 0 ? ((($sss = round(($diff/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
				            	<th>{{ $diffU != 0 ? ((($sss = round(($diffP/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)): 0 }}</th>
				            @endif
				        @endforeach
				        @php($bsupP = $bsup)
				        @php($bsuppP = $bsupp)
				        @php($bsupuP = $bsupu)
		        	@endforeach
		        	@if($inputs['naturep'] != 'paran')
		        		<th style="color: {{ ($diff = ($$f($idE,$exercice2,$dbs) - ($b1 = $$f($idE,$exercice1,$dbs)))) < 0 ? 'red' : ($diff > 0 ? 'green' : '')}}"> {{ (int) $diff }} </th>
		            	<th> {{ $b1 != 0 ? ((($sss = round(($diff/$b1)*100,2)) >= 0 ? $sss : (-1)*$sss)): 0 }} </th>
		            	<th style="color: {{ ($diffP = ($$fp($exercice2,$dbs) - ($bp1 = $$fp($exercice1,$dbs)))) < 0 ? 'red' : ($diffP > 0 ? 'green' : '')}}"> {{ (int) $diffP }} </th>
		            	<th> {{ $bp1 != 0 ? ((($sss = round(($diffP/$bp1)*100,2)) >= 0 ? $sss : (-1)*$sss)): 0 }} </th> 

		            	<th style="color: {{ ($diffU = ($$fu($exercice2) - ($bu1 = $$fu($exercice1)))) < 0 ? 'red' : ($diffU > 0 ? 'green' : '')}}"> {{ $diffU }} </th>
		            	<th> {{ $bu1 != 0 ? ((($sss = round(($diffU/$bu1)*100,2)) >= 0 ? $sss : (-1)*$sss)): 0 }} </th>

		            	<th>{{ $diffP != 0 ? ((($sss = round(($diff/$diffP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
				        <th>{{ $diffU != 0 ? ((($sss = round(($diff/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
				        <th>{{ $diffU != 0 ? ((($sss = round(($diffP/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)): 0 }}</th>
		            @endif
				</tr>
				@php($classes = $ClassesInSupClasse($supclasse->idSupClasse))
               	@foreach($classes as $classe)
               		<tr>
						<th style="color: blue" class="col col-md-4"> {{ $classe->nomClasse}} </th>
						@foreach($exercices as $exercice)
							<td>{{ $bruteE = (int) ($FormatBrut($getBruteClasse($classe->idClasse, $idE, $exercice->exercice))) }}</td>
				            <td>{{ $bruteP = (int) ($FormatBrut($getBruteClassePays($classe->idClasse, $exercice->exercice))) }}</td>
				            <td>{{ $bruteP != 0 ? ((($sss = round(($bruteE/$bruteP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}}</td>
							<td>{{ $bruteU = (int) ($FormatBrut($getBruteClasseUEMOA($classe->idClasse, $exercice->exercice))) }}</td></td>
				            <td>{{ $bruteU != 0 ? ((($sss = round(($bruteE/$bruteU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}}</td>
				            <td>{{ $bruteU != 0 ? ((($sss = round(($bruteP/$bruteU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}}</td>

				            @if($inputs['naturep'] == 'paran')
				            	@if ($loop->parent->first)
				            		@php($brutEP = (int) ($FormatBrut($getBruteClasse($classe->idClasse, $idE, $exercice->exercice-1))))
					            	@php($brutPP = (int) ($FormatBrut($getBruteClassePays($classe->idClasse,$exercice->exercice-1))))
					            	@php($brutUP = (int) ($FormatBrut($getBruteClasseUEMOA($classe->idClasse, $exercice->exercice-1))))
				            	@endif
				            	<td style="color: {{ ($diff = ($bruteE - $brutEP)) < 0 ? 'red' : ($diff > 0 ? 'green' : '')}}">{{ $diff }}</td>
				            	<td>{{ $brutEP != 0 ? ((($sss = round(($diff/$brutEP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            	<td style="color: {{ ($diffP = ($bruteP - $brutPP)) < 0 ? 'red' : ($diffP > 0 ? 'green' : '')}}">{{ $diffP  }}</td>
				            	<td>{{ $brutPP != 0 ? ((($sss = round(($diff/$brutPP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            	<td style="color: {{ ($diffU = ($bruteU - $brutUP)) < 0 ? 'red' : ($diffU > 0 ? 'green' : '')}}">{{ $diffU }}</td>
				            	<td>{{ $brutUP != 0 ? ((($sss = round(($diff/$brutUP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            	<td>{{ $diffP != 0 ? ((($sss =  round(($diff/$diffP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            	<td>{{ $diffU != 0 ? ((($sss =  round(($diff/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            	<td>{{ $diffU != 0 ? ((($sss =  round(($diffP/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            @endif
				            @php($brutEP = $bruteE)
				            @php($brutPP = $bruteP)
				            @php($brutUP = $bruteU)
			        	@endforeach
			        	@if($inputs['naturep'] != 'paran')
			            	<th style="color: {{ ($diff = (($FormatBrut($getBruteClasse($classe->idClasse, $idE, $exercice2))) - ($c1 = $FormatBrut($getBruteClasse($classe->idClasse, $idE, $exercice1)))) ) < 0 ? 'red' : ($diff > 0 ? 'green' : '')}}"> {{ (int) $diff }} </th>
			            	<th> {{ $c1 != 0 ? ((($sss =  round(($diff/$c1)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }} </th>
			            	<th style="color: {{ ($diffP = (($FormatBrut($getBruteClassePays($classe->idClasse,$exercice2))) - ($cp1 = $FormatBrut($getBruteClassePays($classe->idClasse,$exercice1))) )) < 0 ? 'red' : ($diffP > 0 ? 'green' : '')}}"> {{ (int) $diffP }}</th>
			            	<th> {{ $cp1 != 0 ? ((($sss =  round(($diff/$cp1)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }} </th>
			           		<th style="color: {{ ($diffU = (($FormatBrut($getBruteClasseUEMOA($classe->idClasse, $exercice2))) - ($cu1 = $FormatBrut($getBruteClasseUEMOA($classe->idClasse, $exercice1))))) < 0 ? 'red' : ($diffU > 0 ? 'green' : '')}}"> {{ (int) $diffU }} </th>
			            	<th> {{ $cu1 != 0 ? ((($sss =  round(($diff/$cu1)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</th>
			            	<td>{{ $diffP != 0 ? ((($sss =  round(($diff/$diffP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            <td>{{ $diffU != 0 ? ((($sss =  round(($diff/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            <td>{{ $diffU != 0 ? ((($sss =  round(($diffP/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
			            @endif
					</tr>
					@php($sousclasses = $SousClassesInClasse($classe->idClasse))
		            @continue((strtoupper($sousclasses[0]->nomClasse) == strtoupper($sousclasses[0]->nomSousclasse)) && ($sousclasses->count() == 1))
	               	@foreach($sousclasses as $sousclasse)
	               		<tr>
							<th style="color: #2E86C1" class="col col-md-4"> {{ $sousclasse->nomSousclasse}} </th>
							@foreach($exercices as $exercice)
				            	<td>{{ $sc = $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice->exercice))}}</td>
				            	<td> {{ $scp = $FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice->exercice))}} </td>
				            	<td> {{ $scp != 0 ? ((($sss = round(($sc/$scp)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}} </td>
				            	<td> {{ $scu = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice->exercice))}} </td>
				            	<td> {{ $scu != 0 ? ((($sss = round(($sc/$scu)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}} </td>
				            	<td> {{ $scu != 0 ? ((($sss = round(($scp/$scu)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0}} </td>
				            	
				            	@if($inputs['naturep'] == 'paran')
				            		@if ($loop->first)
				            			@php($scP = (int) $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice->exercice-1)))
				            			@php($scpP = (int) $FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice->exercice-1)))
				            			@php($scuP = (int) $FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice->exercice-1)))
				            		@endif
				            		<td style="color: {{ ($diff = ($sc - $scP)) < 0 ? 'red' : ($diff > 0 ? 'green' : '')}}"> {{ $diff }} </td>
				            		<td>{{ $scP != 0 ? ((($sss =  round(($diff/$scP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            		<td style="color: {{ ($diffP = ($scp - $scpP)) < 0 ? 'red' : ($diffP > 0 ? 'green' : '')}}"> {{ $diffP }} </td>
				            		<td>{{ $scpP != 0 ? ((($sss =  round(($diff/$scpP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            		<td style="color: {{ ($diffU = ($scu - $scuP)) < 0 ? 'red' : ($diffU > 0 ? 'green' : '')}}"> {{ $diffU }} </td>
				            		<td>{{ $scuP != 0 ? ((($sss =  round(($diff/$scuP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            		<td>{{ $diffP != 0 ? ((($sss =  round(($diff/$diffP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
					            	<td>{{ $diffU != 0 ? ((($sss =  round(($diff/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
					            	<td>{{ $diffU != 0 ? ((($sss =  round(($diffP/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            	@endif
				            	@php($scP = $sc)
				        	@endforeach
				        	@if($inputs['naturep'] != 'paran')
				            	<th style="color: {{ ($diff = ($FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice2)) - ($sc1 = $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice1))))) < 0 ? 'red' : ($diff > 0 ? 'green' : '')}}"> {{ (int) $diff }}</th>
				            	<th> {{ $sc1 != 0 ? ((($sss =  round(($diff/$sc1)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }} </th>
				            	<th style="color: {{ ($diffP = ($FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice2)) - ($scp1 = $FormatBrut($getBruteSousClassePays($sousclasse->idSousclasse, $exercice1))))) < 0 ? 'red' : ($diffP > 0 ? 'green' : '')}}"> {{ (int) $diffP }}</th>
				            	<th> {{ $scp1 != 0 ? ((($sss =  round(($diff/$scp1)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }} </th>
				            	<th style="color: {{ ($diffU = ($FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice2)) - ($scu1 = $FormatBrut($getBruteSousClasseUEMOA($sousclasse->idSousclasse, $exercice1))))) < 0 ? 'red' : ($diffU > 0 ? 'green' : '')}}"> {{ (int) $diffU }}</th>
				            	<th>{{ $scu1 != 0 ? ((($sss =  round(($diff/$scu1)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }} </th>
				            	<td>{{ $diffP != 0 ? ((($sss =  round(($diff/$diffP)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
					            <td>{{ $diffU != 0 ? ((($sss =  round(($diff/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
					            <td>{{ $diffU != 0 ? ((($sss =  round(($diffP/$diffU)*100,2)) >= 0 ? $sss : (-1)*$sss)) : 0 }}</td>
				            @endif
						</tr>
						@endforeach
					@endforeach
				@endforeach
			@endforeach
			</tbody>
		</table
	</div>
</div>