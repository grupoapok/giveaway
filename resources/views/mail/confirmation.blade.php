@extends('mail.layout',[
    'subjectImage'=> 'https://www.grupoapok.com/mail/september/confirmation/subject.jpg',
    'template' => 'confirmation',
    'webVersion' => true
])
@section('subject')
    Confirma tu Suscripción
    al Boletín de Apok
@endsection
@section('resume')
    <p>
        Hola {{ $name ?? ''}},
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
        <a class="button-to-action" style="color: white; margin-top: 20px" href="{{url('/')}}?referral=apok">CONFIRMAR SUSCRIPCIÓN</a>
    </p>
    <br>

    <h4>¿Qué beneficios obtendrás al suscribirte a nuestro boletín?</h4>
    <p>Tenemos un sorteo especial para nuestros suscriptores donde te puedes ganar una <strong
            style="color: #F18800">Página
            Web</strong> para tu empresa o emprendimiento.
    </p>
    <p> Además, recibirás información sobre: </p>
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
        <a class="button-to-action" style="color: white; margin-top: 20px" href="{{url('/')}}?referral=apok">CONFIRMAR SUSCRIPCIÓN</a>
    </p>
    <br>
    <br>

    <p style="font-size: 14px">
        Si no quieres recibir nuevamente un correo simplemente puedes hacer click sobre este link
        <a style="color: #F18800" href="https://grupoapok.us19.list-manage.com/unsubscribe?u=2e45e55fcfb6fd4047caf2d86&id=913fe614aa">Darse de Baja</a>
    </p>

@endsection

