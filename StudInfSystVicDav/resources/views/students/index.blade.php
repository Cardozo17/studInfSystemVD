@extends('master')

@section('content')
	
	<div class="container-fluid" >
		<div class= "col-md-12">
			<h2>Estudiantes Registrados</h2>

			@foreach ($students as $student)

			 	<ui>	
					<li>
						<label>Nombre y Apellido:</label>
						{{$student->person->name }} {{$student->person->last_name}}  <br>

						@foreach($student->brothers as $brother)
							<label>Sus Hermanos En La Institución: </label> {{$brother->person->name or ''}} {{$brother->person->last_name or ''}}   <br>

						@endforeach

						<label> Su Representante Legal: </label> {{$student->legalRepresentative->person->name}} {{$student->legalRepresentative->person->last_name}} <br>
						<label> Su Padre o Madre: </label> {{$student->parent->person->name or ''}} {{$student->parent->person->last_name or ''}} <br>
						<label> Su Profesor: </label> {{$student->teacher->person->name or 'No Asignado'}} {{$student->teacher->person->last_name or ''}}
					 </li>
				</ui>	 	

			@endforeach
		</div>
	</div>	
		

	
@stop