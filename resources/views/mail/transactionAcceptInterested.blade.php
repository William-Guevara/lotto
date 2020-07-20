<p>Se ha aprobado tu solicitud de intercambio</p>

<div>
	<p><b>Tipo de transacción: </b>{{ $info->transfer_type }}</p>
	<p><b>Producto a recibir: </b>{{ $info->ofrecido }}</p>
	<p><b>Cantidad: </b>{{ $info->quantity }}</p>
	<p><b>Producto ofrecido: </b>{{ $info->comprado }}</p>
	
	<p>Datos de contacto</p>
	<p><b>Clinica: </b>{{ $facility->name }}</p>
	<p><b>Nombre del Administrador: </b>{{ $facility->application_user }}</p>
	<p><b>Correo electronico del Administrador: </b>{{ $facility->email }}</p>
</div>
