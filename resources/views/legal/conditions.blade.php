<!-- Stored in resources/views/child.blade.php -->

@extends('legal.layout')

@section('content')
    <div class="col-12">
        <h1>Terminos y Condiciones del sorteo</h1>
        <h4>1. Entidad organizadora y finalidad del presente sorteo</h4>
        <p> El sorteo es organizado por Apok C.A., cuyo domicilio se encuentra en elSector Alta Vista, de Ciudad
            Guayana, estado Bolívar, Venezuela; con el fin de promocionar su actividad comercial en las redes sociales
            de Instagram, Twitter, Facebook y LinkedIn para conseguir ampliar la visibilidad de la empresa.
        </p>

        <h4> 2. Personas a las que se dirige el sorteo</h4>
        <p>Pueden participar en el sorteo todas aquellas personas mayores de edad que residan en cualquier lugar del
            mundo..</p>
        <p> Quedarán excluidos de la participación de este sorteo todo el personal de Apok y sus familiares.</p>

        <h4> 3. Fecha del sorteo</h4>
        <p>El presente sorteo comienza el {{ config('giveaway.startDate') }} a las 12:00 a.m. y finaliza el {{ config('giveaway.endDate') }} a las 11:59 pm, hora
            Venezuela.</p>

        <h4> 4. Sorteo y Mecanismo de participación y obtención de premios</h4>
        <p> Cualquier persona interesada en participar en el sorteo se podrá suscribir a través del siguiente enlace: <a
                href="https://sorteo.grupoapok.com">https://sorteo.grupoapok.com</a>, siempre que cumpla los requisitos
            mencionados en el punto 2.</p>

        <p> Con su suscripción obtendrá un ticket de participación. Luego de inscrito en el sorteo, puede optar por más
            tickets válidos para el sorteo, completando cualquiera de las misiones que seleccione previamente en la
            página del sorteo: <a href="https://sorteo.grupoapok.com">https://sorteo.grupoapok.com</a>.</p>
        <p> Estas misiones no son de carácter obligatorias:
        <ul>
            <li><strong>Misión 1:</strong> Seguir nuestra cuenta en Twitter @grupoapok y publicar el Sorteo en la red
                social Twitter para lograr 2 Tickets del sorteo.
            </li>
            <li><strong>Misión 2:</strong> Publicar el Sorteo en la red social Facebook para lograr 3 Tickets del
                sorteo.
            </li>
            <li><strong>Misión 3:</strong> Publicar el Sorteo en la red social Linkedin para lograr 3 Tickets del
                sorteo.
            </li>
            <li><strong>Misión 4:</strong> Publicar el Sorteo en la red social Instagram para lograr 3 Tickets del
                sorteo.
            </li>
            <li><strong>Misión 5:</strong> Completar el formulario con información verídica para lograr 5 Tickets del
                sorteo.
            </li>
        </ul>
        </p>
        <p> Una vez finalizada la fecha comprendida en el punto 3, se hará un sorteo haciendo uso de los servicios de
            https://www.random.org para elegir un ticket de los previamente asignados al participante por medio del
            sitio web.</p>

        <p> El premio consistirá en la realización de una Página Web cuyo diseño estará basado en una plantilla
            personalizada que contendrá las secciones:</p>
        <p>
        <ul>
            <li><strong>Inicio:</strong> Página de entrada con un banner e información resumida de los servicios de la
                empresa y contactos.
            </li>
            <li><strong>Nosotros:</strong> Página con la información institucional de la empresa (Misión, Visión,
                Valores, Equipo).
            </li>
            <li><strong>Servicios:</strong> Un listado con una imagen y una descripción de los servicios de la empresa.
            </li>
            <li><strong>Contacto:</strong> Información de contacto de la empresa, número de teléfono, dirección, redes
                sociales y mapa de
                ubicación.

            </li>
            <li>
                <strong>Hosting Básico por un año </strong>
            </li>
            <li>
                <strong> Registro de Dominio por un año.</strong>
            </li>
        </ul>
        </p>
        <p>No incluye correos electrónicos, creación de logos ni ningún otro servicio salvo los especificados
            anteriormente.</p>
        <p> El ganador debe proveer el contenido de la página web, es decir, logotipo, imágenes y descripción de sus
            servicios, datos de contacto e información institucional de la empresa o emprendimiento.
        </p>


        <h4>5. Comunicación del premio</h4>
        <p>
            Al día siguiente de haber seleccionado el ticket ganador, y después de dar por terminado el sorteo, se
            publicará en las redes sociales de Apok el ganador del sorteo, además se le enviará una notificación directa
            a través del correo electrónico que ha suscrito.
        </p>
        <p>
            Para reclamar el premio la persona debe confirmar sus datos a través del correo electrónico o por medio de
            las redes de Apok. Pasados cinco días desde la publicación del ganador, si este no se pone en contacto con
            Apok para la confirmación de sus datos o no nos podemos poner en contacto con él por la causa que fuere,
            perderá la condición de ganador y se realizará un nuevo sorteo con los mismos participantes.
        </p>
        </p>
        <p>
            Los detalles del premio se concretarán por correo electrónico y siguiendo las instrucciones de Apok.
        </p>
        <p>
            Los premios bajo ninguna circunstancia se podrán cambiar por cualquier otro obsequio, ni canjearse por su
            equivalente compensación en metálico.
        </p>
        <h4>6. Responsabilidad de la empresa</h4>
        Apok se reserva el derecho de acortar, prorrogar, modificar o cancelar este concurso si así lo estimase
        conveniente o si ocurriesen supuestos especiales en lo que se impide la realización del mismo.
        </p>
        <p> Igualmente, Apok se reservará el derecho de eliminar cualquier comentario que no se adecue a su filosofía de
            empresa o que se consideren ofensivas para otros visitantes.</p>

        <p> No se responsabilizará por las afirmaciones que se hagan a través de la red social terceras personas
            pudiendo
            llevar a cabo las actuaciones judiciales que crea pertinentes contra las mismas.</p>

        <p> Tampoco se responsabiliza de los daños o perjuicios que pudieran ocurrir cuando el ganador disfrute del
            premio.</p>

        <h4>7. Tratamiento de los datos personales</h4>
        <p>
            Los datos personales facilitados serán incorporados a una base de datos, propiedad de Apok, C.A. y de
            acuerdo a las políticas de privacidad especificadas en <a
                href="{{url('/privacy')}}">{{url('/privacy')}} </a>.
        </p>
        <p>Apok se reserva el derecho de informar a los participantes de las promociones y acciones comerciales que la
            empresa lleve a cabo posteriormente por cualquier medio.</p>

        <h4>8. Ley aplicable</h4>
        <p>Para todo lo que no se especifica en estas bases legales del sorteo, la promoción se someterá a las normas
            que estén en vigor en ese momento. En caso de litigio resolverán la contienda los Juzgados y Tribunales de
            Venezuela sin perjuicio del fuero que pudiera corresponder según la normativa aplicable..</p>


        <h4>9. Aceptación de las bases de este concurso</h4>
        <p> Al participar en el sorteo y dar tus datos personales estás aceptando de forma expresa los presentes
            Términos y Condiciones del sorteo. En caso de que desees obtener más información podrás ponerte en contacto
            con Apok C.A llamando al número de teléfono +58 286 – 971.95.09 o enviando un email a
            info@grupoapok.com.</p>

    </div>
@endsection
