<h3>Querido(a) </h3>
<p> Los resultados fueron:</p><br />

@foreach($msg as $result)

<p>{!! $result->category !!}  </p>
<p>{!! $result->drawing_date !!} </p>
<p>Numeros: {!! $result->numbers !!} </p>
<p>Acumulado: ${!! $result->jackpot !!} Millones </p>
@endforeach

<p> Para tiquetes extras ingrese a http://www.loteriasmillonarias.com/promo </p><br /><br />
<p>Muchas gracias por su preferencia.</p><br />
<p>Servicio Al Cliente</p><br />
<p> LoteriasMillonarias.com</p><br />
<p> info@loteriasmillonarias.com</p><br /> </p><br />
<p> 786-436-7676 (Miami-USA)</p><br /> --}}
<p> Muchas gracias por su preferencia. </p><br /> </p><br />
<p> Servicio Al Cliente </p><br />
<p> LoteriasMillonarias.com </p><br />
<p> Si usted no quiere recibir los resultados en el futuro por favor visite:</p><br />
<a href="#">Unsubscribe</a>