@extends('mail.layout',[
    'subjectImage'=> 'https://www.grupoapok.com/mail/september/confirmation/subject.jpg',
    'template' => 'confirmation'
])
@section('subject')
    Confirma tu Suscripción
    al Boletín de Apok
@endsection
@section('resume')
    <p>
        ¡Hola {{ $name ?? ''}}!,
    </p>
    <p>
        En algún momento te diste de alta en nuestra lista de contactos o de nuestros aliados comerciales y nos gustaría
        saber si deseas recibir nuestro boletín.
    </p>
    <p>
        <strong style="color: #F18800">No nos gusta el spam</strong>, por eso queremos que nos des permiso para enviarte
        correos electrónicos.
    </p>


@endsection
@section('content')
    <p>
        Para ello solo debes hacer clic en el siguiente botón.
    </p>
    <br>

    <p style="align-items: center;text-align: center; margin: 10px 0;">
        <a class="button-to-action" style="color: white; margin-top: 20px" href="http://eepurl.com/gF3e89">CONFIRMAR SUSCRIPCIÓN</a>
    </p>
    <br>

    <h4>¿Qué beneficios obtendrás al suscribirte a nuestro boletín?</h4>
    <p>
    <ul>
        <li style="margin: 5px 0"> Noticias y artículos de interés que te ayudarán a lograr los objetivos de tu
            negocio.
        </li>
        <li style="margin: 5px 0"> Información y opiniones acerca de nuestros productos y servicios.</li>
        <li style="margin: 5px 0"> Descuentos, ofertas y promociones.</li>
    </ul>
    </p>
    <br>
    <p>
        Confirma tu suscripción y recibe las ventajas de formar parte de nuestra comunidad.
    </p>
    <br>
    <p style="align-items: center;text-align: center;">
        <a class="button-to-action" style="color: white; margin-top: 20px" href="http://eepurl.com/gF3e89">CONFIRMAR SUSCRIPCIÓN</a>
    </p>
    <br>
    <p><strong>P.D.:</strong> Tenemos un sorteo especial para nuestros suscriptores donde te puedes ganar una <strong
            style="color: #F18800">Pagina
            Web</strong> para tu empresa o emprendimiento. Solo tienes que registrate acá:
    </p>
    <br>
    <p style="align-items: center;text-align: center;">
        <a class="button-to-action" style="color: white; margin-top: 20px"
           href="https://sorteo.grupoapok.com?referral=apok">PARTICIPAR EN EL SORTEO</a>
    </p>

@endsection

