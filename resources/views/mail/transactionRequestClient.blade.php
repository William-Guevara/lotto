<p>Se ha solicitado un producto de su inventario para ser transado. Por favor ingrese a la aplicación Trazway para revisar los detalles</p>

<div>
	<p><b>Tipo de transacción: </b>{{ $info->transfer_type }}</p>
	<p><b>Producto solicitado: </b>{{ $info->ofrecido }}</p>
	<p><b>Lote del producto: </b>{{ $info->batch }}</p>
	<p><b>Fecha de vencimiento: </b>{{ $info->expiration_date }}</p>
	<p><b>Cantidad solicitada: </b>{{ $info->quantity }}</p>
	<p><b>Estado de la solicitud solicitada: </b>{{ $info->transfer_status }}</p>
	<p><b>Producto a recibir: </b>{{ $info->comprado }}</p>
</div>
