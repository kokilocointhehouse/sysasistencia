$(document).ready(function () {
    const etiqueta =document.getElementById('sindato');
    if(etiqueta){
        Swal.mixin({
            input: 'text',
            confirmButtonText: 'Next &rarr;',  
            
            allowOutsideClick: false, 
            preConfirm: (login) => {
              return fetch(`//api.github.com/users/${login}`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  
                })
                .catch(error => {
                  Swal.showValidationMessage(                    
                    'El campo no debe estar vacio'
                  )
                })
            },        
            progressSteps: ['1', '2', '3','4','5']
          }).queue([{
              title: 'Nombre de la Empresa',
              text: 'Ingrese datos veridicos'
            },
            'Direccion de la empresa',
            'Latitud',
            'Longitud',            
            'Radio'
          ]).then((result) => {
            if (result.value) {
              const answers = JSON.stringify(result.value)
              document.getElementById('sindato').value = answers;
              
              Swal.fire({
                title: 'Gracias por su paciencia',
                text: "Si quiere modificar los datos ingresados dirigase a configuracion",
                icon: 'success',               
                confirmButtonColor: '#3085d6',                
                confirmButtonText: 'Continuar!'
              }).then((result) => {
                if (result.isConfirmed) {
                 
                  $("#enviar").click();
                }
              })
              
                
              
            }
          })
    }
   

});

$("#sindato").on("keyup change", function(e) {
  console.log("asdasdasd");
})