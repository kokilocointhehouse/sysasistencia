@extends('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Categorías <a href="Categoria/create"><button class="btn btn-success">Nuevo</button></a></h3>
	
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Denominacion</th>
				</thead>
               
			</table>
		</div>
		
	</div>
</div>



@endsection


