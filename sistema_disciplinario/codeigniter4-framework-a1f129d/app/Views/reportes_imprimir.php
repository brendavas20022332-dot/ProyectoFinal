<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Disciplinario #<?= esc($reporte['reporte_id']) ?> - <?= esc($reporte['est_nombres']) ?> <?= esc($reporte['est_apellidos']) ?></title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eef2f5;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #212529;
            padding-bottom: 40px;
        }

        .action-bar {
            background: #ffffff;
            border-bottom: 2px solid #dee2e6;
            padding: 12px 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .paper-sheet {
            background: #ffffff;
            max-width: 850px;
            margin: 0 auto;
            padding: 40px 45px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            border: 1px solid #dcdcdc;
        }

        .doc-header {
            border-bottom: 3px double #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #f1f4f9;
            border-left: 4px solid #0d6efd;
            padding: 6px 12px;
            font-weight: 700;
            font-size: 0.95rem;
            text-transform: uppercase;
            color: #0d47a1;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .table-info th {
            width: 25%;
            background-color: #f8f9fa;
            color: #495057;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .table-info td {
            font-size: 0.9rem;
        }

        .signature-box {
            margin-top: 45px;
            padding-top: 10px;
        }

        .signature-line {
            border-top: 1px solid #333333;
            width: 85%;
            margin: 45px auto 8px auto;
        }

        /* ESTILOS EXCLUSIVOS PARA IMPRESIÓN Y GUARDAR COMO PDF */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                color: #000000 !important;
            }

            .no-print {
                display: none !important;
            }

            .paper-sheet {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .section-title {
                background-color: #e9ecef !important;
                color: #000000 !important;
                border-left-color: #000000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .badge {
                border: 1px solid #000000 !important;
                color: #000000 !important;
                background: transparent !important;
            }

            .signature-line {
                border-top: 1px solid #000000 !important;
            }

            @page {
                size: letter portrait;
                margin: 1.5cm 1.5cm 1.5cm 1.5cm;
            }
        }
    </style>
</head>
<body>

    <!-- BARRA SUPERIOR DE ACCIONES (NO SALE EN IMPRESIÓN) -->
    <div class="action-bar no-print sticky-top">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <a href="<?= site_url('reportes') ?>" class="btn btn-outline-secondary btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Reportes
                </a>
                <span class="ms-2 fw-semibold text-secondary">
                    Reporte Disciplinario Folio #<?= str_pad($reporte['reporte_id'], 5, '0', STR_PAD_LEFT) ?>
                </span>
            </div>

            <div class="d-flex gap-2">
                <!-- Botón Imprimir / Guardar como PDF -->
                <button type="button" class="btn btn-primary btn-sm fw-bold shadow-sm" onclick="window.print()">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir / Guardar como PDF
                </button>

                <!-- Botón Descargar en Word -->
                <a href="<?= site_url('reportes/descargar-word/' . $reporte['reporte_id']) ?>" class="btn btn-success btn-sm fw-bold shadow-sm">
                    <i class="bi bi-file-earmark-word-fill me-1"></i> Descargar en Word (.doc)
                </a>
            </div>
        </div>
    </div>

    <!-- DOCUMENTO OFICIAL PARA IMPRESIÓN Y PDF -->
    <div class="container">
        <div class="paper-sheet">

            <!-- ENCABEZADO INSTITUCIONAL -->
            <div class="doc-header">
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <i class="bi bi-mortarboard-fill text-primary" style="font-size: 3.5rem;"></i>
                    </div>
                    <div class="col-7 text-center">
                        <h4 class="fw-bold mb-1 text-uppercase text-dark tracking-wide">Centro Educativo</h4>
                        <h5 class="fw-bold text-danger mb-1 fs-6 text-uppercase">Constancia de Incidencia y Reporte Disciplinario</h5>
                        <p class="text-muted small mb-0">Comité de Convivencia y Disciplina Escolar &bull; Ciclo Lectivo <?= esc($reporte['ciclo_lectivo'] ?? date('Y')) ?></p>
                    </div>
                    <div class="col-3 text-end">
                        <div class="border rounded p-2 text-center bg-light">
                            <span class="text-muted small d-block">FOLIO N°</span>
                            <span class="fw-bold text-danger fs-5"><?= str_pad($reporte['reporte_id'], 5, '0', STR_PAD_LEFT) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FECHA, HORA Y ESTADO -->
            <div class="row mb-3">
                <div class="col-4">
                    <strong>Fecha de Emisión:</strong> <?= esc(date('d/m/Y', strtotime($reporte['fecha']))) ?>
                </div>
                <div class="col-4 text-center">
                    <strong>Hora del Suceso:</strong> <?= esc(date('H:i', strtotime($reporte['hora']))) ?> hrs
                </div>
                <div class="col-4 text-end">
                    <strong>Estado del Caso:</strong>
                    <span class="badge bg-dark"><?= esc($reporte['estado_nombre']) ?></span>
                </div>
            </div>

            <!-- SECCIÓN 1: DATOS DEL ESTUDIANTE -->
            <div class="section-title">
                1. Información del Estudiante
            </div>
            <table class="table table-bordered table-sm table-info mb-2">
                <tbody>
                    <tr>
                        <th>Nombre del Alumno(a):</th>
                        <td class="fw-bold fs-6" colspan="3">
                            <?= esc($reporte['est_nombres']) ?> <?= esc($reporte['est_apellidos']) ?>
                            <span class="text-muted fw-normal ms-2 small">(ID Estudiante: #<?= esc($reporte['estudiante_id']) ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Grado y Sección:</th>
                        <td class="fw-semibold">
                            <?= esc($reporte['nombre_grado'] ?? 'No asignado') ?> &mdash; Sección "<?= esc($reporte['nombre_seccion'] ?? 'A') ?>"
                        </td>
                        <th>Género:</th>
                        <td><?= esc($reporte['est_genero'] ?? 'No especificado') ?></td>
                    </tr>
                    <tr>
                        <th>Padre / Encargado:</th>
                        <td>
                            <?= esc($reporte['enc_nombre'] ?? 'Sin asignar') ?> <?= esc($reporte['enc_apellido'] ?? '') ?>
                            <?php if (!empty($reporte['enc_parentesco'])): ?>
                                (<?= esc($reporte['enc_parentesco']) ?>)
                            <?php endif; ?>
                        </td>
                        <th>Teléfono de Contacto:</th>
                        <td>
                            <i class="bi bi-telephone text-success me-1"></i><?= esc($reporte['enc_telefono'] ?? 'Sin teléfono') ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- SECCIÓN 2: DATOS DEL MAESTRO INFORMANTE -->
            <div class="section-title">
                2. Maestro / Docente que Elabora el Reporte
            </div>
            <table class="table table-bordered table-sm table-info mb-2">
                <tbody>
                    <tr>
                        <th>Docente Informante:</th>
                        <td class="fw-bold text-primary">
                            Prof(a). <?= esc($reporte['doc_nombre']) ?> <?= esc($reporte['doc_apellido']) ?>
                        </td>
                        <th>Asignación / Responsabilidad:</th>
                        <td>
                            <?= esc($reporte['doc_grado_encargado'] ?? 'Docente') ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- SECCIÓN 3: TIPIFICACIÓN DE LA FALTA -->
            <div class="section-title">
                3. Tipificación de la Falta Disciplinaria
            </div>
            <table class="table table-bordered table-sm table-info mb-2">
                <tbody>
                    <tr>
                        <th>Tipo de Infracción:</th>
                        <td class="fw-semibold"><?= esc($reporte['falta_nombre']) ?></td>
                        <th>Nivel de Gravedad:</th>
                        <td>
                            <?php
                                $badgeColor = 'bg-secondary';
                                if ($reporte['falta_gravedad'] === 'Leve') $badgeColor = 'bg-warning text-dark';
                                elseif ($reporte['falta_gravedad'] === 'Moderada') $badgeColor = 'bg-warning-subtle text-dark border border-warning';
                                elseif ($reporte['falta_gravedad'] === 'Grave') $badgeColor = 'bg-danger text-white';
                            ?>
                            <span class="badge <?= $badgeColor ?> px-2 py-1"><?= esc($reporte['falta_gravedad']) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Motivo / Título:</th>
                        <td colspan="3" class="fw-semibold text-dark">
                            <?= esc($reporte['motivo']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- SECCIÓN 4: DESCRIPCIÓN CIRCUNSTANCIADA DE LOS HECHOS -->
            <div class="section-title">
                4. Descripción Circunstanciada de los Hechos
            </div>
            <div class="border rounded p-3 bg-light mb-3" style="min-height: 100px; font-size: 0.95rem; line-height: 1.5;">
                <?= nl2br(esc($reporte['descripcion_falta'])) ?>
            </div>

            <!-- SECCIÓN 5: ACCIONES Y MEDIDAS DISCIPLINARIAS APLICADAS -->
            <div class="section-title">
                5. Acciones Tomadas, Medidas Correctivas y Compromisos
            </div>
            <div class="border rounded p-3 bg-light mb-4" style="min-height: 80px; font-size: 0.95rem; line-height: 1.5;">
                <?php if (!empty($reporte['acciones_tomadas'])): ?>
                    <?= nl2br(esc($reporte['acciones_tomadas'])) ?>
                <?php else: ?>
                    <span class="text-muted fst-italic">Sin acciones registradas al momento de la emisión.</span>
                <?php endif; ?>
            </div>

            <!-- SECCIÓN 6: FIRMAS DE CONSTANCIA Y NOTIFICACIÓN -->
            <div class="section-title">
                6. Firmas de Notificación y Compromiso
            </div>

            <div class="row text-center signature-box">
                <div class="col-4">
                    <div class="signature-line"></div>
                    <strong class="d-block small">Prof(a). <?= esc($reporte['doc_nombre']) ?> <?= esc($reporte['doc_apellido']) ?></strong>
                    <span class="text-muted small">Docente Informante</span>
                </div>

                <div class="col-4">
                    <div class="signature-line"></div>
                    <strong class="d-block small">
                        <?= !empty($reporte['enc_nombre']) ? esc($reporte['enc_nombre'] . ' ' . $reporte['enc_apellido']) : 'Padre / Encargado' ?>
                    </strong>
                    <span class="text-muted small">Firma de Enterado(a)</span>
                </div>

                <div class="col-4">
                    <div class="signature-line"></div>
                    <strong class="d-block small">Dirección / Administración</strong>
                    <span class="text-muted small">Sello y Firma Institucional</span>
                </div>
            </div>

            <!-- NOTA AL PIE -->
            <div class="mt-4 pt-3 border-top text-center text-muted small">
                <em>Este documento es un registro oficial de conducta que se anexa al expediente del estudiante conforme al reglamento disciplinario escolar.</em>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-imprimir si viene parámetro auto=1 en la URL -->
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auto') === '1') {
            window.addEventListener('load', function () {
                window.print();
            });
        }
    </script>
</body>
</html>
