<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h1 class="title">
            <?= $title ?>
            <br>(<?= $movement->resolution ?>)
        </h1>
        
        <div class="content">
            <p>
                Entre los suscritos a saber, de una parte: <?= $movement->customer->name ?>, mayor de edad, plenamente capaz
                para contratar y obligarse, identificado(a) con <?= mb_strtolower($movement->customer->type_document_name ?? "", 'UTF-8') ?> número <?= number_format($movement->customer->number_document, 0, ",", ".") ?>
                expedida en <?= $movement->customer->issued ?>. quien en para efectos de este instrumento, se denominara, en
                adelante como <b>EL COMPRADOR</b> y de otra parte, la Empresa denominada <?= $company->name ?>, NIT No <?= $company->number_nit ?>-<?= $company->dv ?>, inscrita ante la Cámara de Comercio de <?= $company->origin ?>,
                bajo la matrícula mercantil número <?= number_format($company->business_number, 0, ',', '.') ?> quien en adelante se denominará <b>LA
                COMPAÑIA</b>, representando legalmente por el señor <?= mb_strtoupper($company->propierty, "UTF-8") ?>,
                identificado con <?= mb_strtolower($company->type_document->name, "UTF-8"). " ({$company->type_document->abbreviation})" ?>
                N° <?= number_format($company->number_document, 0, ",", ".") ?> de Bogotá, domiciliado, en
                Bogotá, se convino libremente la celebración de un <?= $title ?>,
                que se regirá en lo general por las disposiciones del Código
                de Civil, art. 1869 en concordancia con el art. 917 del C. de Cio, y las demás leyes
                Colombianas aplicables al asunto, y las cláusulas que a continuación se determinan,
                previas las siguientes:
            </p>
            <p>
                <b>CONSIDERACIONES:</b>
                <ol>
                    <li>
                        Que, la compañía <b><?= $company->name ?> NIT No <?= $company->number_nit ?>-<?= $company->dv ?></b>, en desarrollo de su objeto
                        social, efectúa diversos tipos de negocios, relacionados con proyectos <b>agrícolas</b>,
                        actividades que desarrollará a nivel nacional e internacional. 
                    </li>
                    <li>
                        La compañía <b><?= $company->name ?></b> ha desarrollado unos métodos específicos de
                        producción, germinación, así como de manipulación y presentación de cultivos de
                        aguacate mediante un programa técnico-agrícola que en conjunto constituyen un know
                        how agrícola y comercial particular logrado mediante la inversión económica en
                        investigación, así como en virtud de la larga experiencia en el sector, condiciones
                        específicas del terreno, temperatura, humedad, entre otros; para lograr una mayor
                        uniformidad en el desarrollo del embrión y por lo tanto una disponibilidad permanente de
                        aguacate.
                    </li>
                    <li>
                        El proceso de germinación y maduración de los frutos objeto de este contrato,
                        (aguacate) tendrá un tiempo aproximado que en términos generales será de entre 26-30
                        meses, durante los cuales los frutos y cosechas tendrán las siguientes etapas:
                        <ol type="a">
                            <li>- Preparación del terreno y fertilización.</li>
                            <li>- Siembra.</li>
                            <li>- Proceso de germinación.</li>
                            <li>- Administración del desarrollo del árbol (fertilización foliar, fertilización radicular,
                            poda, entre otros).</li>
                            <li>- Desarrollo del fruto.</li>
                        </ol>
                        No obstante, la duración y el resultado pueden variar en función del tipo de fruto, la
                        variedad, el tiempo de almacenamiento, la calidad del agua empleada, entre otros
                        factores.
                    </li>
                    <li>
                        El saber-hacer de la compañía <b><?= $company->name ?></b>, es el resultado de varios años de
                        experiencia probada y puesta en práctica con rigor y fidelidad, por parte de los miembros
                        de la compañía en negocios relacionados con diferentes actividades agrícolas y
                        comerciales, entre las que se cuenta la <b>AGROINDUSTRIA</b>.
                    </li>
                    <li>
                        La compañía <b><?= $company->name ?></b> brinda <b>AL COMPRADOR</b> la tranquilidad de ser una
                        empresa debidamente registrada y sus productos certificados ante el ICA, cumplirá con
                        todas las disposiciones legales sobre la producción, comercialización y exportación de
                        productos agrícolas especialmente el <b>aguacate</b>.
                    </li>
                    <li>
                        <b>El COMPRADOR</b>, manifiesta y reconoce haber conocido la viabilidad técnica,
                        económica y comercial del <b>programa técnico-agrícola</b> antes descrito, y ha recibido toda
                        la información necesaria sobre la viabilidad del negocio, y se ha hecho una idea real sobre
                        las eventuales producciones de este, y que ha tenido el tiempo necesario para reflexionar
                        la viabilidad comercial de estos, y el potencial de tales actividades en el mercado nacional
                        e internacional.
                    </li>
                    <li>
                        Las partes acuerdan proteger la confidencialidad de la información privada o secreta
                        que llegue a su conocimiento como consecuencia de este convenio y se comprometen a
                        protegerla, reconociendo su valor y su importancia, salvo que la información sea o pase
                        al dominio público; o que sea requerida por la orden de una autoridad pública.
                    </li>
                    <li>
                        El <b>Artículo 1863 del código civil</b> prescribe: Modalidades de la compraventa. <i>“La
                        venta puede ser pura y simple, o bajo condición suspensiva o resolutoria.
                        Puede hacerse a plazo para la entrega de las cosas o del precio. Puede tener por objeto
                        dos o más cosas alternativas.
                        Bajo todos estos respectos se rige por las reglas generales de los contratos, en lo que
                        no fueren modificadas por las de este título”</i>.
                        <p>
                            El <b>Artículo 1869, del código civil</b> habla de la venta de cosa futura, y establece: <i>“La
                            venta de cosas que no existen, pero se espera que existan, se entenderá hecha bajo la
                            condición de existir, salvo que se exprese lo contrario, o que por la naturaleza del contrato
                            aparezca que se compró la suerte”</i>.
                        </p>
                        <p>
                            El <b>Artículo 917 del código de comercio</b> señala: <i>“La venta de cosa futura sólo quedará
                            perfecta en el momento en que exista, salvo que se exprese lo contrario o que de la
                            naturaleza del contrato parezca que se compra el alea”</i>.
                        </p>
                    </li>
                    <li>
                        En tal virtud, teniendo plena capacidad y autonomía para obligarse como persona
                        natural y jurídica, los anteriormente nombrados formalizan el presente <b><?= $title ?></b>, al tenor de las siguientes clausulas:
                    </li>
                </ol>
            </p>

            <p>
                <b>CLÁUSULA PRIMERA.- OBJETO</b>: El objeto del presente <b><?= $title ?></b> es fijar los términos y condiciones bajo los cuales
                <b>El COMPRADOR</b> hará la compra de cosecha futura a la compañía <b><?= $company->name ?></b>, la cual
                viene desarrollando de tiempo atrás un <b>programa técnico-agrícola</b> para el aumento
                diferencial de la producción en el cultivo de aguacates, así como su explotación comercial,
                a nivel nacional e internacional, con un aliado estratégico de acuerdo con el plan de
                negocios, propuestos por la compañía <b><?= $company->name ?></b>, y aceptado por el <b>COMPRADOR</b>,
                pues ha efectuado un análisis sobre la viabilidad del programa técnico-agrícola y el fondo
                del negocio.
            </p>

            <p>
                <b>SEGUNDA. ÁMBITO.</b> Las operaciones mencionadas se ejecutarán de manera preferente
                en el territorio que comprende la ciudad de Medellín, departamento de Antioquia, sin
                perjuicio de extenderse por todo el territorio nacional, pero para efecto de este contrato el
                cultivo y las plantaciones están ubicadas en el departamento de Antioquia, municipio
                Montebello, vereda La Honda, punto denominado Zarcitos. Comprendidos por los predios
                con matrícula inmobiliaria: 023-11593, 023-11597, 023-2184, 023-2182, 023-2183, 023-
                21838,en los cuales se desarrolla y ejecuta el <b>programa técnico-agrícola</b>, y para los
                cuales, <b>El COMPRADOR</b>, adquiere una cantidad de frutos, especificada más adelante,
                con el fin que la compañía <b><?= $company->name ?></b>, acopie la mayor cantidad posible de frutos,
                principalmente aguacate, mediante el <b>programa técnico-agrícola</b> para el aumento
                diferencial de la producción, y posteriormente los revenda y comercialice, en mercados
                nacionales y/o internacionales, por medio de un aliado estratégico.
            </p>

            <p>
                <b>TERCERA. COMPROMISOS DE LAS PARTES Y PAGO POR LA COMPRA DE
                COSECHA FUTURA:<b>
                <ol>
                    <li>- Mantener en reserva la Información confidencial sobre los planes de negocios y el
                        <b>programa técnico-agrícola</b> de la compañía <b><?= $company->name ?></b>, dado que esa información
                        confidencial se le ha trasmitido al <b>COMPRADOR</b>, a fin de que este pueda establecer las
                        condiciones del negocio y ver l     a viabilidad de la compraventa de frutos o cosechas a
                        futuro, salvo que la información sea o pase al dominio público; o que sea requerida por la
                        orden de una autoridad pública.
                    </li>
                    <li>
                        - Habida cuenta que ha conocido toda la información brindada por la compañía
                        <b><?= $company->name ?></b>, y que ha tenido el tiempo suficiente para conocer la viabilidad el
                        <b>programa técnico-agrícola</b> y el plan de negocios en su integridad, y que ha conocido y
                        estudiado la parte financiera, el fondo y la viabilidad del negocio, la importancia de este;y
                        que está a cargo de la compañía <b><?= $company->name ?></b> quien ha ideado y desarrollado el
                        <b>programa técnico-agrícola</b> y por tanto tiene el <b>SABER HACER</b>; ha decidido voluntariay
                        libremente realizar la compra de frutos, y la cosecha futura, que se ha plantado en los
                        predios ya descritos, bajo las siguientes condiciones:
                        <ol type="a">
                            <li>- Inicialmente el <b>COMPRADOR</b>, adquiere por la suma de <b><?= numeroALetras($movement->value) ?></b>
                                (<b>$ <?= number_format($movement->value, 2, ",", ".") ?> COP</b>), la cantidad equivalente a <?= $movement->detail->quantity ?>
                                 vite<?= $movement->detail->quantity > 1 ? "s" : "" ?> o a la producción de
                                 <?= $movement->detail->quantity ?> árbol<?= $movement->detail->quantity > 1 ? "es" : "" ?> de la cosecha futura, que germina, se desarrolla y madura en los
                                terrenos de propiedad de la compañía, descritos en la cláusula segunda. <b>Parágrafo</b>: el
                                <b>COMPRADOR</b> aporto inicialmente la suma de <b><?= numeroALetras($movement->value) ?></b> (Valor pendiente a validar)
                                (<b>$ <?= number_format($movement->value, 2, ",", ".") ?> COP</b>), el cual fue abonado el día «Fecha» «Financiación»
                                «M_2Dinero_Letra» («M_2Dinero_Numero») «M_2Fecha» «Mensualidad» .
                            </li>
                            <li>
                                - La compañía <b><?= $company->name ?></b>, podrá desarrollar el aprovechamiento de las áreas de
                                terreno ya descritas, mediante el cultivo de <b><?= $movement->detail->unit_productive ?></b>,
                                de acuerdo a las necesidades o conveniencia técnico-agrícola, que para el efecto
                                recomienden los agrónomos, con esto aumentando los frutos producidos. Claro está,
                                siempre que el desarrollo el <b>programa técnico-agrícola</b> lo requiera, la compañía
                                <b><?= $company->name ?></b>, lo autorice en el momento oportuno.
                            </li>
                            <li>
                                -<b>El COMPRADOR</b>, autoriza desde ya con la firma de este contrato a la compañía
                                <b><?= $company->name ?></b>, para que ella de forma autónoma y exclusiva, debido a su conocimiento,
                                experiencia, el personal a cargo, la clientela, y demás; para que una compañía externa
                                y/o asociada, para que esta realice la comercialización nacional y/o internacional de
                                dichos frutos.
                            </li>
                            <li>
                                - <b>EL COMPRADOR</b> declara que está perfectamente informado en cuanto a que los
                                recursos están destinados a la plantación directa para el cultivo de aguacate, y se
                                abstendrá de realizar, por sí mismo o a través de un tercero, cualquier multiplicación,
                                propagación, reproducción del modelo de negocio aquí pactado, por medios o
                                procedimientos iguales o similares a los aquí descritos.
                            </li>
                        </ol>
                    </li>
                </ol>
            </p>
        </div>
    </body>
</html>

