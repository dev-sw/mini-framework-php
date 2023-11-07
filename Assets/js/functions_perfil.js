var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

	// Actualizar Datos Personales Perfil
	if(document.querySelector("#formPerfil")){
		var formPerfil = document.querySelector("#formPerfil");
		formPerfil.onsubmit = function(e){
			e.preventDefault();

			var strIdentificacion = document.querySelector('#txtIdentificacion').value;
			var strNombre = document.querySelector('#txtNombre').value;
			var strApellido = document.querySelector('#txtApellido').value;
			var strTelefono = document.querySelector('#txtTelefono').value;
			
			if (strIdentificacion == '' || strNombre == '' || strApellido == '' || strTelefono == ''){
				swal("Atención","Por favor verifique los campos obligatorios.","error");
				return false;
			}else{

				if(strIdentificacion.length != 8){
					swal("¡Atención!","El campo identificación debe contener 8 dígitos.","info");
					return false;
				}
				if(strTelefono.length < 9){
					swal("¡Atención!","El campo teléfono debe contener 9 dígitos.","info");
					return false;
				}
				
				let elementsValid = document.getElementsByClassName("valid");
				for (let i = 0; i < elementsValid.length; i++){
					if(elementsValid[i].classList.contains('is-invalid')){
						swal("Atención","Por favor verifique los campos en rojo.","error");
						return false;
					}
				}

				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url+'/perfil/setPerfil';
				var formData = new FormData(formPerfil);
				request.open("POST",ajaxUrl,true);
				request.send(formData);

				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if(objData.status){
							$('#modalFormPerfil').modal("hide");
							swal({
								title: "",
								text: objData.msg,
								type: "success",
								confirmButtonText: "Aceptar",
								closeOnConfirm: false,
							}, function(isConfirm){
								if(isConfirm){
									location.reload();
								}
							});
						}else{
							swal("¡Error!", objData.msg, "error");
						}
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}

	// Actualizar Datos de Sesión Perfil
	if(document.querySelector("#formDataSession")){
		var formDataSession = document.querySelector("#formDataSession");
		formDataSession.onsubmit = function(e){
			e.preventDefault();

			var intEstado = document.querySelector('#listEstado').value;
			var strPassword = document.querySelector('#txtPassword').value;
			var strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;

			if(strPassword != "" || strPasswordConfirm != ""){
				if(strPassword != strPasswordConfirm){
					swal("Atención","Las contraseñas no coinciden","info");
					return false;
				}
				if(strPassword.length != 8){
					swal("¡Atención!","La contraseña debe contener 8 caracteres.","info");
					return false;
				}
			}

			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url+'/perfil/setDatosSesion';
			var formData = new FormData(formDataSession);
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			request.onreadystatechange = function(){
				if(request.readyState != 4) return;
				if(request.status == 200){
					var objData = JSON.parse(request.responseText);
					if(objData.status){
						$('#modalFormPerfil').modal("hide");
						swal({
							title: "",
							text: objData.msg,
							type: "success",
							confirmButtonText: "Aceptar",
							closeOnConfirm: false,
						}, function(isConfirm){
							if(isConfirm){
								location.reload();
							}
						});
					}else{
						swal("¡Error!", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
				return false;
			}
		}
	}
}, false);

function openModalPerfil(){
	$('#modalFormPerfil').modal('show');	
}