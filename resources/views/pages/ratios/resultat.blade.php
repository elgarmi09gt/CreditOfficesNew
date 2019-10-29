@include('templates._assets')

@php($idE = explode('-',$inputs['idEntreprise'])[0])
@php($DATA = collect())
@foreach($RESULTATS as $Res)
	@php($fp=$Res[1].'Pays')
	@php($fu=$Res[1].'UEMOA')
	@foreach($exercices as $exercice)
		@php($D[0][0] = $exercice->exercice)
		@php($D[0][1] = substr($Res[0], 4))
		@php($D[0][2] = $$fp($exercice->exercice))
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
		<table class="table table-condensed container" style="font-size: 12px">
			<tr>
		        <th> {{'EXERCICES'}} </th>
		        @foreach($exercices as $exercice)
		            <th colspan="{{ ($inputs['naturep'] == 'paran') ? 7 : 3 }}" style="text-align: center;">{{ $exercice->exercice }}</th>
		        @endforeach
		    </tr>
		    <tr>
		        <th>  </th>
		        @foreach($exercices as $exercice)
		        	<th>{{'Brute'}}</th>
		            <th>{{'% P'}}</th>
		            <th>{{'% U'}}</th>
		            @if($inputs['naturep'] == 'paran')
		            	<th>{{'D.B'}}</th>
		            	<th>{{'% .EV'}}</th>
		            	<th>{{'% .EV P'}}</th>
		            	<th>{{'% .EV U'}}</th>
		            @endif
		        @endforeach
		        @if($inputs['naturep'] != 'paran')
		            	<th>{{'D.B'}}</th>
		            	<th>{{'% .EV'}}</th>
		            	<th>{{'% .EV P'}}</th>
		            	<th>{{'% .EV U'}}</th>
		            @endif
		    </tr>
		    @foreach($supclasses as $supclasse)
		    	@foreach($RESULTATS as $r)
					@continue(substr($r[0], 4) != $supclasse->nomSupClasse)
				<tr>
					<th> {{ $r[0]}} </th>
					@foreach($exercices as $exercice)
						@foreach($DATA as $data)
							@continue($data[1] != $supclasse->nomSupClasse || $data[0] != $exercice->exercice)
							@php($f=$r[1])
			            	<th>{{ $bsup =  $$f($idE,$exercice->exercice) }}</th>
				            <th>{{ ($psup = $data[2]) != 0 ? round(($bsup/$psup)*100,2) : 0}}</th>
				            <th>{{ ($usup = $data[3]) != 0 ? round(($bsup/$usup)*100,2) : 0}}</th>
				            @if($inputs['naturep'] == 'paran')
				            	<th></th>
				            	<th></th>
				            	<th></th>
				            	<th></th>
				            @endif
				        @endforeach
		        	@endforeach
		        	@if($inputs['naturep'] != 'paran')
		            		<th></th>
		            		<th></th>
		            		<th></th>
		            		<th></th>
		            	@endif
				</tr>
				@php($classes = $ClassesInSupClasse($supclasse->idSupClasse))
               	@foreach($classes as $classe)
               		<tr style="color: blue">
						<th > {{ $classe->nomClasse}} </th>
						@foreach($exercices as $exercice)
			            	<th>{{ $bruteE = (int) ($FormatBrut($getBruteClasse($classe->idClasse, $idE, $exercice->exercice))) }}</th>
			            	<th></th>
			            	<th></th>
			            	@if($inputs['naturep'] == 'paran')
			            		<th></th>
			            		<th></th>
			            		<th></th>
			            		<th></th>
			            	@endif
			        	@endforeach
			        	@if($inputs['naturep'] != 'paran')
			            	<th></th>
			            	<th></th>
			            	<th></th>
			            	<th></th>
			            @endif
					</tr>
					@php($sousclasses = $SousClassesInClasse($classe->idClasse))
		            @continue((strtoupper($sousclasses[0]->nomClasse) == strtoupper($sousclasses[0]->nomSousclasse)) && ($sousclasses->count() == 1))
	               	@foreach($sousclasses as $sousclasse)
	               		<tr style="color: #42D1DB">
							<th > {{ $sousclasse->nomSousclasse}} </th>
							@foreach($exercices as $exercice)
				            	<th>{{ $sc = $FormatBrut($getBruteSousClasse($sousclasse->idSousclasse, $idE, $exercice->exercice))}}</th>
				            	<th></th>
				            	<th></th>
				            	@if($inputs['naturep'] == 'paran')
				            		<th></th>
				            		<th></th>
				            		<th></th>
				            		<th></th>
				            	@endif
				        	@endforeach
				        	@if($inputs['naturep'] != 'paran')
				            	<th></th>
				            	<th></th>
				            	<th></th>
				            	<th></th>
				            @endif
						</tr>
						@endforeach
					@endforeach
				@endforeach
			@endforeach

			{{-- @foreach($RESULTATS as $r)
				<tr>
					<th> {{ $r[0]}} </th>
					@foreach($exercices as $exercice)
					@php($f=$r[1])
		            	<th style="background-color: #c2bcbe">{{ $$f($idE,$exercice->exercice) }}</th>
		            	<th></th>
		            	<th></th>
		            	@if($inputs['naturep'] == 'paran')
		            		<th></th>
		            		<th></th>
		            		<th></th>
		            		<th></th>
		            	@endif
		        	@endforeach
		        	@if($inputs['naturep'] != 'paran')
		            		<th></th>
		            		<th></th>
		            		<th></th>
		            		<th></th>
		            	@endif
				</tr>
			@endforeach --}}
		</table
	</div>
</div>