@extends('mail.layout',[
    'subjectImage'=> 'https://www.grupoapok.com/mail/september/giveaway_invitation/subject.jpg',
    'template' => 'giveaway_invitation'
])
@section('subject')
    ¡SORTEO!<br/><br>
    Participa y Gana.
@endsection
@section('resume')
    <p>
        Una Página Web es imprescindible para tu Empresa o Marca Personal. Apok y sus aliados comerciales están
        sorteando una <span style="color:#F18800" >Página Web Profesional </span> y es tu oportunidad de obtener una.
    </p>

@endsection
@section('content')
    <p style="align-items: center;text-align: center;">
        Puedes participar en SIMPLES PASOS.
    </p>
    <p style="align-items: center;text-align: center;">
        ¡Ingresa a <a style="color:#F18800" href="{{url('/')}}{{isset($referral) ? "?referral=".$referral: ''}}">http://sorteo.grupoapok.com</a> y
        Participa!
    </p>
    <p style="align-items: center;text-align: center; margin: 20px;">
        <br>
        <br>
        <img width="321px" src="https://grupoapok.com/mail/september/giveaway_invitation/gift.jpg" alt="">
        <br>
        <br>
    </p>
    <p style="align-items: center;text-align: center; margin: 20px;">
    <p style="align-items: center;text-align: center;">Click en el botón y recibe tu ticket para participar</p>
    <br>
    <p style="align-items: center;text-align: center;">
        <a class="button-to-action" style="color: white; margin-top: 20px" href="{{url('/')}}{{isset($referral) ? "?referral=".$referral: ''}}">Participa
            en el Sorteo</a>
    </p>
    <br>
    <br>
    </p>
    <h3 style="align-items: center;text-align: center;">¿Que incluye la pagina web?</h3>
    <ul style="align-items: center;text-align: center; list-style: none; padding-left: 0">
        <li style="margin: 5px 0;">Diseño One Page</li>
        <li style="margin: 5px 0;">Diseño Responsivo</li>
        <li style="margin: 5px 0;">4 Secciones: Inicio, Nosotros, Servicios y Contacto</li>
        <li style="margin: 5px 0;">Hosting y Dominio por un año</li>
    </ul>

@endsection

