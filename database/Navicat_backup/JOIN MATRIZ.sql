select RequisitosMatriz.id ,RequisitosMatriz.FactorRiesgo, RequisitosMatriz.Grupo , RequisitosMatriz.CategoriaRiesgo , RequisitosMatriz.Descnorma, RequisitosMatriz.TipoNorma , RequisitosMatriz.Numero , RequisitosMatriz.`AñoEmision` , RequisitosMatriz.AutoridadEmite , RequisitosMatriz.ArticuloAplica , RequisitosMatriz.LitNum , RequisitosMatriz.NormasRelacionadas , EstadoCumplimiento.Requisito , EstadoCumplimiento.EvidenciaEsperada , EstadoCumplimiento.Responsable , EstadoCumplimiento.AreaAplicacion , Evaluacion.Fecha , Evaluacion.EvidenciaCumplimiento , Evaluacion.Calificacion from empresa   INNER JOIN   EstadoCumplimiento on EstadoCumplimiento.empresa = empresa.idempresa INNER JOIN RequisitosMatriz on EstadoCumplimiento.Req_asociado = RequisitosMatriz.id left JOIN  Evaluacion on Evaluacion.id_Requisito = RequisitosMatriz.id Where idempresa = 1 OR Evaluacion.id = null; 