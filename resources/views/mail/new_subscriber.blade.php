@extends('mail.layout',[
    'actionURL'=>'https://concurso.grupoapok.com?source=email?referral=apok',
    'subjectImage'=> 'https://www.grupoapok.com/mail/september/a/subject.png'
])
@section('subject')
    ¡GRACIAS!<br/>
    por suscribirte.
@endsection
@section('resume')
    ¡Mucha suerte!, pronto conocerás el afortunado ganador de la Página Web.
@endsection
@section('content')
    <div style="font-weight: 900;font-size: 48px; color: #F18800;line-height: 42px;align-items: center;text-align: center;">
        2
    </div>
    <h3 style="align-items: center;text-align: center;letter-spacing: 0.1em;">
        TICKETS PARTICIPANDO
    </h3>

    <p style="align-items: center;text-align: center;">Revisa tus tickets que están participando para el sorteo aquí</p>

    <p style="align-items: center;text-align: center; margin: 20px;">
        <br>
        <br>
        <a class="button-to-action" href="'https://concurso.grupoapok.com?source=email?referral=apok">Ver mis Tickets</a>
        <br>
        <br>
    </p>
    <p style="align-items: center;text-align: center;">
        EL GANADOR SERÁ ANUNCIADO EL<br/>
        <span style="font-size: 24px; color: #F18800;" > <strong> 20 SEPTIEMBRE 2019</strong></span><br/>
          EN NUESTRAS REDES SOCIALES
    </p>


@endsection

