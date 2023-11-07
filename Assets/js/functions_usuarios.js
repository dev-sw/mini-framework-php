var tableUsuarios;

document.addEventListener('DOMContentLoaded', function(){

	tableUsuarios = $('#tableUsuarios').DataTable({ 
		/*ID de la tabla*/
		"aProcessing":true,
		"aServerside":true,
		"language": {
			/*Idioma de visualizacion*/
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"url": " "+base_url+"/usuarios/getUsuarios",
			"dataSrc":""
		},
		"columns":[
			/* Campos de la base de datos*/
			{"data":"id_usuario"},
			{"data":"nombres"},
			{"data":"apellidos"},
			{"data":"telefono"},
			{"data":"email"},
			{"data":"nombre"},
			{"data":"estado"},
			{"data":"options"}
		],
		'dom': 'lBfrtip',
        'buttons': [
            {
            	"extend": "copyHtml5",
            	"text": "<i class='far fa-copy'></i> Copiar",
            	"titleAttr": "Copiar",
            	"className": "btn btn-secondary"
            },{
            	"extend": "excelHtml5",
            	"text": "<i class='fas fa-file-excel'></i> Excel",
            	"titleAttr": "Exportar a Excel",
            	"className": "btn btn-success"
         	},{
         		"extend": "pdfHtml5",
            	"text": "<i class='fas fa-file-pdf'></i> PDF",
            	"titleAttr": "Exportar a PDF",
            	"className": "btn btn-danger"
            },{
        		"extend": "csvHtml5",
            	"text": "<i class='fas fa-file-csv'></i> CSV",
            	"titleAttr": "Exportar a CSV",
            	"className": "btn btn-info"
        	}
        ],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order":[[0,"desc"]] /*Ordenar de forma Desendente*/
	});

	var formUsuario = document.querySelector("#formUsuario");
	formUsuario.onsubmit = function(e){
		e.preventDefault();

		var strIdentificacion = document.querySelector('#txtIdentificacion').value;
		var strNombre = document.querySelector('#txtNombre').value;
		var strApellido = document.querySelector('#txtApellido').value;
		var strEmail = document.querySelector('#txtEmail').value;
		var strTelefono = document.querySelector('#txtTelefono').value;
		var intTipousuario = document.querySelector('#listRolid').value;
		var strPassword = document.querySelector('#txtPassword').value;

		if (strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || strTelefono == '' || intTipousuario == ''){
			swal("Atención","Todos los campos son obligatorios","error");
			return false;
		}else{

			if(strIdentificacion.length < 8){
				swal("¡Atención!","El campo identificación debe contener 8 dígitos.","info");
				return false;
			}
			if(strTelefono.length < 9){
				swal("¡Atención!","El campo teléfono debe contener 9 dígitos.","info");
				return false;
			}
			/*if(strPassword.length < 5){
				swal("¡Atención!","La contraseña debe tener un minimo de 5 caracteres.","info");
				return false;
			}*/

			let elementsValid = document.getElementsByClassName("valid");
			for (let i = 0; i < elementsValid.length; i++){
				if(elementsValid[i].classList.contains('is-invalid')){
					swal("Atención","Por favor verifique los campos en rojo.","error");
					return false;
				}
			}

			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url+'/usuarios/setUsuario';
			var formData = new FormData(formUsuario);
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200){
					var objData = JSON.parse(request.responseText);
					if (objData.status){
						$('#modalFormUsuario').modal("hide");
						formUsuario.reset();
						swal("Usuarios", objData.msg, "success");
						tableUsuarios.ajax.reload();
					}else{
						swal("Error", objData.msg, "error");
					}
				}
			}
		}
	}
}, false);

window.addEventListener('load', function(){
	fntRolesUsuario();
	//fntViewUsuario();
	//fntEditUsuario();
	//fntDelUsuario();
}, false);

function fntRolesUsuario(){
	var ajaxUrl = base_url+'/roles/getSelectRoles';
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	request.open("GET",ajaxUrl,true);
	request.send();

	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			document.querySelector('#listRolid').innerHTML = request.responseText;
			//document.querySelector('#listRolid').value = 1;
			$('#listRolid').selectpicker('render');
		}
	}
}

function fntViewUsuario(idUsuario){
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = `${base_url}/usuarios/getUsuario/${idUsuario}`;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			var objData = JSON.parse(request.responseText);
			if (objData.status){
				
				var estadoUsuario = objData.data.estado == 1 ? 
				'<span class="badge badge-success">Activo</span>' : 
				'<span class="badge badge-danger">Inactivo</span>';

				document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
				document.querySelector("#celNombre").innerHTML = objData.data.nombres;
				document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celEmail").innerHTML = objData.data.email;
				document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombre;
				document.querySelector("#celEstado").innerHTML = estadoUsuario;
				document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
				$('#modalViewUser').modal('show');
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
}

function fntEditUsuario(idUsuario){
	document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";

	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = `${base_url}/usuarios/getUsuario/${idUsuario}`;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			var objData = JSON.parse(request.responseText);
			if (objData.status){

				document.querySelector("#idUsuario").value = objData.data.id_usuario;
				document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
				document.querySelector("#txtNombre").value = objData.data.nombres;
				document.querySelector("#txtApellido").value = objData.data.apellidos;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtEmail").value = objData.data.email;
				document.querySelector("#listRolid").value = objData.data.id_rol;
				$('#listRolid').selectpicker('render');
				if (objData.data.estado == 1){
					document.querySelector("#listStatus").value = 1;
				}else{
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
			}

		}

		$('#modalFormUsuario').modal('show');
	}
}

function fntDelUsuario(idpersona){
	var idUsuario = idpersona;
	
	swal({
		title: "Eliminar Usuario",
		text: "¿Realmente quiere eliminar el usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Sí, eliminar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function(isConfirm){
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url+'/usuarios/delUsuario';
			var strData = "idUsuario="+idUsuario;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200){
					var objData = JSON.parse(request.responseText);
					if (objData.status){
						swal("Eliminar!", objData.msg, "success");
						tableUsuarios.ajax.reload();
						//function(){
						//	fntRolesUsuario();
						//});
					}else{
						swal("Atención!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function openModal(){
	document.querySelector('#idUsuario').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	document.querySelector("#formUsuario").reset();

	$('#modalFormUsuario').modal('show');
}