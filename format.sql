SELECT
    CASE
        hist_testEdps.testEdps_pregunta1
        WHEN 0 THEN 'Igual que siempre'
        WHEN 1 THEN 'Ahora no tanto como siempre'
        WHEN 2 THEN 'Ahora mucho menos'
        ELSE 'No, nada en absoluto'
    END AS 'resPregunta1',
    (
        SELECT
            COUNT(*)
        FROM
            hist_testEdps
        WHERE
            testEdps_admiAdmision = 'A514244'
    ) AS 'cantidadTests',
    CASE
        WHEN(
            SUM(
                testEdps_pregunta1 + testEdps_pregunta2 + testEdps_pregunta3 + testEdps_pregunta4 + testEdps_pregunta5 + testEdps_pregunta6 + testEdps_pregunta7 + testEdps_pregunta8 + testEdps_pregunta9 + testEdps_pregunta10
            )
        ) > 10 THEN 'SI'
        ELSE 'NO'
    END AS 'resultadoTest',
    CASE
        WHEN testEdps_pregunta10 <> 0 THEN 'SI'
        ELSE 'NO'
    END AS 'validacionesAdicioanles',
    testEdps_admiAdmision,
    testEdps_fecha,
    testEdps_hora,
    MEDICOS.MEDICO,
    (
        SELECT
            MEDICOS.FIRMA
        FROM
            MEDICOS
        WHERE
            CODMED = hist_testEdps.idUsuario
    ) AS 'firmaMedico',
    Tip_Esp.Especialid,
    USUARIOS.Reg_Med
FROM
    hist_testEdps
    INNER JOIN MEDICOS ON MEDICOS.CODMED = hist_testEdps.idUsuario
    INNER JOIN Tip_Esp ON Tip_Esp.CodEsp = MEDICOS.ESPECIALIDAD
    INNER JOIN USUARIOS ON USUARIOS.[IDE-FACT] = hist_testEdps.idUsuario
WHERE
    hist_testEdps.testEdps_admiAdmision = 'A514244'
GROUP BY
    testEdps_admiAdmision,
    testEdps_fecha,
    testEdps_hora,
    testEdps_pregunta10,
    MEDICOS.MEDICO,
    hist_testEdps.idUsuario,
    Tip_Esp.Especialid,
    USUARIOS.Reg_Med,
    hist_testEdps.testEdps_pregunta1
ORDER BY
    testEdps_fecha DESC,
    testEdps_hora DESC