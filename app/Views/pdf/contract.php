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
                Entre los suscritos: <b>(1) IPLANET COLOMBIA S.A.S</b>, sociedad comercial identificada con NIT 900.444.608-8,
                domiciliada en Bogotá D.C., inscrita en la Cámara de Comercio de Bogotá, representada legalmente por Wilfredo
                Daza Díaz, mayor de edad, identificado con cédula de ciudadanía 79.745.124 de Bogotá, quien en adelante se
                denominará <b>LA COMPAÑÍA</b>; y <b>(2) <?= $movement->customer->name ?></b>, mayor de edad, identificado(a) con <?= mb_strtolower($company->type_document->name, "UTF-8"). " ({$company->type_document->abbreviation})" ?>
                No. <?= number_format($company->number_document, 0, ",", ".") ?> de <?= $movement->customer->issued ?>, quien en adelante se denominará <b>EL COMPRADOR</b>, se celebra el
                presente <b><?= $title ?></b>, el cual se regirá por lo dispuesto en
                los artículos 1863, 1869 del Código Civil, 917 del Código de Comercio y demás normas aplicables, atendiendo las
                siguientes cláusulas:
            </p>
            <?= $separador ?>
            <p>
                <b>CONSIDERACIONES:</b>
                <ol>
                    <li>
                        <b>LA COMPAÑÍA</b> desarrolla actividades agrícolas y agroindustriales, incluyendo programas técnicos para la
                        producción, manejo y comercialización de cultivos de aguacate Hass y otros productos agrícolas.
                    </li>
                    <li>
                        <b>LA COMPAÑÍA</b> ha estructurado un programa técnico-agrícola especializado, que incluye procesos de
                        germinación, manejo, nutrición, poda, sanidad, administración del cultivo y comercialización, constituyendo
                        un know-how agrícola y comercial propio.
                    </li>
                    <li>
                        El aguacate requiere un tiempo estimado <b>de 26 a 30 meses</b> para alcanzar madurez productiva, pudiendo variar
                        por factores climáticos, ambientales, fitosanitarios, operativos y de manejo técnico
                    </li>
                    <li>
                        <b>EL COMPRADOR</b> declara conocer el programa técnico-agrícola, su viabilidad y su naturaleza de actividad
                        agrícola sujeta a riesgos inherentes, sin que esto constituya una inversión financiera ni un instrumento
                        regulado por la Superintendencia Financiera. 
                    </li>
                    <li>
                        Las partes reconocen la confidencialidad de la información técnica, operativa y comercial intercambiada con
                        ocasión de este contrato.
                    </li>
                    <li>
                        <b>EL COMPRADOR </b>adquiere frutos futuros provenientes de la producción obtenida en los predios donde <b>LA
                        COMPAÑÍA</b> desarrolla el programa técnico-agrícola, actualmente ubicados en el municipio de Santa María,
                        Huila, vereda El Cedral.
                    </li>
                    <li>
                        Que, dentro del programa técnico-agrícola, <b>LA COMPAÑÍA</b> ha definido la unidad comercial denominada
                        “<b>Semilla de Oro</b>”, entendida como <b>el derecho a recibir la producción anual estimada de un (1) árbol de
                        aguacate</b> cultivado dentro del proyecto. La <b>Semilla de Oro no constituye participación societaria ni
                        instrumento financiero</b>, sino una <b>modalidad de compra anticipada de frutos futuros</b>, sujeta a la variabilidad
                        natural de la actividad agrícola.
                    </li>
                </ol>
            </p>

            
            <?= $separador ?>

            <h3>
                CLÁUSULAS
            </h3>

            <h4>
                PRIMERA. OBJETO
            </h4>

            <p>
                El objeto del presente <b><?= $title ?></b> es fijar los términos y condiciones bajo los cuales
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

