<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Reporte Disciplinario #<?= esc($reporte['reporte_id']) ?></title>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page {
            size: 21.59cm 27.94cm;
            margin: 2cm 2cm 2cm 2cm;
            mso-page-orientation: portrait;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #111111;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10pt;
        }
        th, td {
            border: 1px solid #777777;
            padding: 6pt 8pt;
            font-size: 10pt;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            font-weight: bold;
        }
        .header-title {
            text-align: center;
            font-size: 15pt;
            font-weight: bold;
            color: #0b3c6d;
            margin-bottom: 2pt;
            text-transform: uppercase;
        }
        .header-subtitle {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            color: #c0392b;
            margin-bottom: 4pt;
            text-transform: uppercase;
        }
        .header-cycle {
            text-align: center;
            font-size: 9pt;
            color: #666666;
            margin-bottom: 14pt;
        }
        .section-header {
            background-color: #0b3c6d;
            color: #ffffff;
            font-weight: bold;
            font-size: 10.5pt;
            padding: 4pt 8pt;
            margin-top: 12pt;
            margin-bottom: 4pt;
        }
        .content-box {
            border: 1px solid #777777;
            padding: 8pt 10pt;
            background-color: #fbfbfb;
            margin-bottom: 10pt;
            font-size: 10pt;
        }
        .signature-table {
            margin-top: 30pt;
            border: none;
        }
        .signature-table td {
            border: none;
            text-align: center;
            padding-top: 25pt;
            vertical-align: top;
        }
        .signature-line {
            border-top: 1px solid #000000;
            width: 80%;
            margin: 0 auto 4pt auto;
        }
        .footer-note {
            text-align: center;
            font-size: 8.5pt;
            color: #777777;
            border-top: 1px solid #cccccc;
            margin-top: 25pt;
            padding-top: 6pt;
        }
    </style>
</head>
<body>

    <!-- ENCABEZADO INSTITUCIONAL -->
    <div class="header-title">Centro Educativo</div>
    <div class="header-subtitle">Constancia Oficial de Incidencia y Reporte Disciplinario</div>
    <div class="header-cycle">Comité de Convivencia y Disciplina Escolar &bull; Ciclo Lectivo <?= esc($reporte['ciclo_lectivo'] ?? date('Y')) ?></div>

    <!-- FOLIO Y DATOS DE EMISIÓN -->
    <table>
        <tr>
            <th style="width: 20%;">FOLIO N°:</th>
            <td style="width: 30%; color: #c0392b; font-weight: bold; font-size: 12pt;">
                <?= str_pad($reporte['reporte_id'], 5, '0', STR_PAD_LEFT) ?>
            </td>
            <th style="width: 25%;">ESTADO DEL REPORTE:</th>
            <td style="width: 25%; font-weight: bold;">
                <?= esc($reporte['estado_nombre']) ?>
            </td>
        </tr>
        <tr>
            <th>FECHA DEL REPORTE:</th>
            <td><?= esc(date('d/m/Y', strtotime($reporte['fecha']))) ?></td>
            <th>HORA DEL INCIDENTE:</th>
            <td><?= esc(date('H:i', strtotime($reporte['hora']))) ?> hrs</td>
        </tr>
    </table>

    <!-- 1. INFORMACIÓN DEL ESTUDIANTE -->
    <div class="section-header">1. INFORMACIÓN DEL ESTUDIANTE</div>
    <table>
        <tr>
            <th style="width: 25%;">Nombre Completo:</th>
            <td style="width: 45%; font-weight: bold;"><?= esc($reporte['est_nombres']) ?> <?= esc($reporte['est_apellidos']) ?></td>
            <th style="width: 15%;">ID Alumno:</th>
            <td style="width: 15%;">#<?= esc($reporte['estudiante_id']) ?></td>
        </tr>
        <tr>
            <th>Grado y Sección:</th>
            <td><?= esc($reporte['nombre_grado'] ?? 'No asignado') ?> &mdash; Sección "<?= esc($reporte['nombre_seccion'] ?? 'A') ?>"</td>
            <th>Género:</th>
            <td><?= esc($reporte['est_genero'] ?? 'No especificado') ?></td>
        </tr>
        <tr>
            <th>Padre o Encargado:</th>
            <td>
                <?= esc($reporte['enc_nombre'] ?? 'Sin asignar') ?> <?= esc($reporte['enc_apellido'] ?? '') ?>
                <?= !empty($reporte['enc_parentesco']) ? '(' . esc($reporte['enc_parentesco']) . ')' : '' ?>
            </td>
            <th>Teléfono:</th>
            <td><?= esc($reporte['enc_telefono'] ?? 'Sin teléfono') ?></td>
        </tr>
    </table>

    <!-- 2. MAESTRO / DOCENTE QUE REPORTA -->
    <div class="section-header">2. MAESTRO / DOCENTE QUE REPORTA</div>
    <table>
        <tr>
            <th style="width: 25%;">Docente Informante:</th>
            <td style="width: 45%; font-weight: bold; color: #0b3c6d;">Prof(a). <?= esc($reporte['doc_nombre']) ?> <?= esc($reporte['doc_apellido']) ?></td>
            <th style="width: 15%;">Asignación:</th>
            <td style="width: 15%;"><?= esc($reporte['doc_grado_encargado'] ?? 'Docente') ?></td>
        </tr>
    </table>

    <!-- 3. TIPIFICACIÓN DE LA FALTA -->
    <div class="section-header">3. TIPIFICACIÓN DE LA FALTA DISCIPLINARIA</div>
    <table>
        <tr>
            <th style="width: 25%;">Tipo de Falta:</th>
            <td style="width: 45%; font-weight: bold;"><?= esc($reporte['falta_nombre']) ?></td>
            <th style="width: 15%;">Gravedad:</th>
            <td style="width: 15%; font-weight: bold;"><?= esc($reporte['falta_gravedad']) ?></td>
        </tr>
        <tr>
            <th>Motivo del Reporte:</th>
            <td colspan="3" style="font-weight: bold; color: #222222;"><?= esc($reporte['motivo']) ?></td>
        </tr>
    </table>

    <!-- 4. DESCRIPCIÓN CIRCUNSTANCIADA DE LOS HECHOS -->
    <div class="section-header">4. DESCRIPCIÓN CIRCUNSTANCIADA DE LOS HECHOS</div>
    <div class="content-box">
        <?= nl2br(esc($reporte['descripcion_falta'])) ?>
    </div>

    <!-- 5. ACCIONES Y MEDIDAS DISCIPLINARIAS APLICADAS -->
    <div class="section-header">5. ACCIONES TOMADAS, MEDIDAS CORRECTIVAS Y COMPROMISOS</div>
    <div class="content-box">
        <?php if (!empty($reporte['acciones_tomadas'])): ?>
            <?= nl2br(esc($reporte['acciones_tomadas'])) ?>
        <?php else: ?>
            <span style="color: #888888; font-style: italic;">Sin acciones registradas al momento de la emisión.</span>
        <?php endif; ?>
    </div>

    <!-- 6. FIRMAS DE NOTIFICACIÓN Y COMPROMISO -->
    <div class="section-header">6. FIRMAS DE NOTIFICACIÓN Y CONFORMIDAD</div>
    <table class="signature-table">
        <tr>
            <td style="width: 33%;">
                <div class="signature-line"></div>
                <strong>Prof(a). <?= esc($reporte['doc_nombre']) ?> <?= esc($reporte['doc_apellido']) ?></strong><br>
                <span style="font-size: 8.5pt; color: #555555;">Docente Informante</span>
            </td>
            <td style="width: 33%;">
                <div class="signature-line"></div>
                <strong><?= !empty($reporte['enc_nombre']) ? esc($reporte['enc_nombre'] . ' ' . $reporte['enc_apellido']) : 'Padre / Encargado' ?></strong><br>
                <span style="font-size: 8.5pt; color: #555555;">Firma de Enterado(a)</span>
            </td>
            <td style="width: 33%;">
                <div class="signature-line"></div>
                <strong>Dirección / Administración</strong><br>
                <span style="font-size: 8.5pt; color: #555555;">Firma y Sello Oficial</span>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Este documento es un registro oficial de conducta escolar emitido por la institución educativa y se integra al expediente del alumno.
    </div>

</body>
</html>
