@extends('mail.layout',[
    'subjectImage'=> 'https://www.grupoapok.com/mail/september/a/subject.png'
])
@section('subject')
    ¡{{$name}}<br/>
    ya estás participando!
@endsection
@section('resume')
    Se ha generado tu primer ticket del sorteo, por lo que ya estás participando para ganar una Página Web para tu marca o negocio.
@endsection
@section('content')
    <p style="align-items: center;text-align: center; margin: 20px;">
        <br>
        <br>
        <a class="button-to-action" style="color: white" href="{{ url("/subscriber/{$token}") }}">VER MIS TICKETS</a>
        <br>
        <br>
    </p>

    <p  style="align-items: center;text-align: center;">
        Si quieres obtener más tickets y aumentar tus probabilidades de ganar, recuerda que debes cumplir todas las misiones disponibles en la página del sorteo.
    </p>
    <p style="align-items: center;text-align: center; margin: 20px;">
        <br>
        <br>
        <a class="button-to-action" style="color: white" href="{{ url("/subscriber/{$token}") }}">QUIERO MÁS TICKETS</a>
        <br>
        <br>
    </p>
    <p style="align-items: center;text-align: center;">
        EL GANADOR SERÁ ANUNCIADO EL<br/>
        <span style="font-size: 24px; color: #F18800;" > <strong> {{ config('giveaway.announcementDate') }}</strong></span><br/>
          EN NUESTRAS REDES SOCIALES
    </p>
    <br>
    <br>
    <p><strong>¿Serás tú el/la ganador@?</strong></p>
    <p><strong>Esperamos que sí.</strong></p>
    <p><strong>¡Mucha Suerte!</strong></p>
@endsection

