var tableRoles;

document.addEventListener('DOMContentLoaded', function(){
	tableRoles = $('#tableRoles').DataTable({ 
		/*ID de la tabla*/
		"aProcessing":true,
		"aServerside":true,
		"language": {
			/*Idioma de visualizacion*/
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"url": `${base_url}/roles/getRoles`,
			"dataSrc":""
		},
		"columns":[
			/* Campos de la base de datos*/
			{"data":"id_rol"},
			{"data":"nombre"},
			{"data":"descripcion"},
			{"data":"estado"},
			{"data":"options"}
		],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order":[[0,"desc"]] /*Ordenar de forma Desendente*/
	});

	//NUevo Rol
	var formRol = document.querySelector('#formRol');
	formRol.onsubmit = function(e){
		e.preventDefault();

		var intIdRol = document.querySelector('#idRol').value;
		var strNombre = document.querySelector('#txtNombre').value;
		var strDescripcion = document.querySelector('#txtDescripcion').value;
		var intEstado = document.querySelector('#listStatus').value;
		
		if (strNombre == '' || strDescripcion == '' || intEstado == ''){
			swal("Atención","Todos los campos son obligatorios","error");
			return false;
		}

		let elementsValid = document.getElementsByClassName("valid");
		for (let i = 0; i < elementsValid.length; i++){
			if(elementsValid[i].classList.contains('is-invalid')){
				swal("Atención","Por favor verifique los campos en rojo.","error");
				return false;
			}
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = `${base_url}/roles/setRol`;
		var formData = new FormData(formRol);
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200){
				var objData = JSON.parse(request.responseText);
				if (objData.status){
					$('#modalFormRol').modal("hide");
					formRol.reset();
					swal("Roles de Usuario", objData.msg, "success");
					tableRoles.ajax.reload();
				}else{
					swal("Error", objData.msg, "error");
				}
			}
		}
	}	
});

$('#tableRoles').DataTable();

function openModal(){
	document.querySelector('#idRol').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	document.querySelector("#formRol").reset();

	$('#modalFormRol').modal('show');
}

window.addEventListener('load', function(){
	// fntPermisos(idRol);
}, false);

function fntEditRol(idRol){
	document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";

	var idrol = idRol;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = `${base_url}/roles/getRol/${idrol}`;
	request.open("GET",ajaxUrl,true);
	request.send();

	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector("#idRol").value = objData.data.id_rol;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				
				if (objData.data.estado == 1) {
					var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
				}else{
					var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
				}

				var htmlSelect = `${optionSelect}
								<option value="1">Activo</option>
								<option value="2">Inactivo</option>			
								`;
				document.querySelector("#listStatus").innerHTML = htmlSelect;
				$('#modalFormRol').modal('show');
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
}

function fntDelRol(idRol){	
	swal({
		title: "Eliminar Rol",
		text: "¿Realmente quiere eliminar el Rol?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Sí, eliminar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function(isConfirm){
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = `${base_url}/roles/delRol`;
			var strData = `idrol=${idRol}`;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200){
					var objData = JSON.parse(request.responseText);
					if (objData.status){
						swal("Eliminar!", objData.msg, "success");
						tableRoles.ajax.reload(function(){
							fntEditRol();
							fntDelRol();
						});
					}else{
						swal("Atención!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function fntPermisos(idRol){
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = `${base_url}/permisos/getPermisosRol/${idRol}`;
	request.open("GET",ajaxUrl,true);
	request.send();

	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){

			document.querySelector('#contentAjax').innerHTML = request.responseText;
			$('.modalPermisos').modal('show');
			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
		}
	}
}

function fntSavePermisos(event){
	event.preventDefault();
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = `${base_url}/permisos/setPermisos`;
	var formElement = document.querySelector("#formPermisos");
	var formData = new FormData(formElement);
	request.open("POST",ajaxUrl,true);
	request.send(formData);

	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			var objData = JSON.parse(request.responseText);
			if (objData.status){
				swal("Permisos de Usuario", objData.msg, "success");
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
}