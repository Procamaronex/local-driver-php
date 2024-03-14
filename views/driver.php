<!-- <div class="container"> -->
<div id="app" style="z-index: -1!important;" class="container">
    <div class="container text-center mb-5 mt-3">
        <h1 @click="visualizarQR('', 'INGREGAR AL REPOSITORIO')">DRIVER LOCAL <small class="small badge"><small class="badge badge-warning small"><?php echo($_ENV['version'] ?? 'v1.0.1'); ?> </small></small></h1>
    </div>

    <!-- <div v-for="fichero in ficheros" style="z-index: -1!important;">
        <div class="text-center mb-2">
            <a class="badge badge-success" :href="armaRuta(fichero.name)" target="_blank"><h5>{{fichero.name}} <small>(descargar)</small> </h5></a>

            <span class="btn btn-danger" @click="eliminaFichero(fichero.name)">Eliminar</span>
        </div>
    </div> -->
    

    <div class="row pt-5">
        <div class="col-sm-12 col-lg-3" v-for="fichero in ficheros">
            <div class="card-container">
                <div class="card" style="width: 100% !important">
                    <div class="card-body">
                        <h5 class="card-title">
                            <h5>{{fichero.name}} </h5>
                            <div :id="fichero.name"></div>
                        </h5>
                    </div>
                    <span class="extension-text">{{fichero.extension}}</span>
                    <div class="qr-image" :id="'qr-image-'+fichero.name" @click="visualizarQR(armaRuta(fichero.original_name))"></div>

                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item pb-3">{{fichero.size}} {{fichero.size_tag}}</li>
                        <div class="row p-2">
                            <div class="col-6">
                                <a class="btn btn-success btn-block" :href="armaRuta(fichero.original_name)" target="_blank">Descargar</a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-danger btn-block" @click="eliminaFichero(fichero.original_name)">Eliminar</button>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        


    <div class="text-center" v-if="ficheros.length <= 0">
        <span class="mt-5 badge">
            No hay nada por aquí. Haz clic en el "Botón" para comenzar a subir tu primer archivo!
        </span>
    </div>

<!--
    <pre>
        {{ $data }}
    </pre>
-->

<!-- BOTON FLOTANTE -->
<div class="floating-button" @click="toggleModal">
    <img src="assets/images/upload-icon.gif" alt="" height="70" role="button">
</div>


<!-- Modal -->
<div style="z-index: 1!important;" class="modal fade" :class="{show, 'd-block': active}" 
    id="exampleModal2" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="color: black">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cargar fichero <span v-if="file">[{{file.name}}]</span></h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="toggleModal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
   <!--   
      <input v-if="!cargando" type="file" @change="onFileChange" multiple>
-->

<div class="bloque-drag-and-drog" v-if="!cargando">
        <!-- Área de arrastre de archivos -->
        <div class="drop-area" @drop.prevent="dropHandler" @dragover.prevent @click="openFileInput">
            Arrastra y suelta archivos aquí, ó da click aquí
        </div>
        <!-- Input de tipo file oculto -->
        <input type="file" style="display: none" ref="fileInput" @change="handleFileInput">
        <!-- Lista de archivos seleccionados -->
        <table class="table table-striped table-sm table-dark " v-if="files.length > 0 && !cargando">
            <head>
                <tr>
                    <th>Archivo</th>
                    <th>Tamaño</th>
                    <th></th>
                </tr>
            </head>
            <body class="text-center">
                <tr v-for="(file, index) in files" :key="index">
                    <td>{{ file.name }}</td>
                    <td>{{ fileSize(file.size) }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
            </body>
        </table>
        <!--
        <ul>
            <li v-for="(file, index) in files" :key="index">
                {{ file.name }} - {{ fileSize(file.size) }}
            </li>
        </ul>
-->
    </div>

      <div v-if="cargando">
        <h2>
            Subiendo fichero...
        </h2>
        <p class="text-center mt-5">Espere.....</p>
      </div>

      </div>
      <div class="modal-footer" v-if="files.length > 0 && !cargando">
        <button type="button" @click="uploadFile" class="btn btn-primary">Completar la carga de fichero</button>
      </div>
    </div>
  </div>
</div>



</div>
<!-- </div> -->


<script>

    new Vue({
        el: '#app',
        data: {
            ficheros: [],
            active: false,
            show: false,
            file: null,
            cargando: false,
            files: [] // Almacena los archivos seleccionados
        },
        mounted() {
            this.obtenerFicheros();
        },
        methods: {
            obtenerFicheros() {
                axios.get('/?c=driver&a=ficheros')
                    .then((respuesta) => {
                        this.ficheros = respuesta.data;

                        // Llamar a setTimeout() para ejecutar la función después de 2 segundos
                        setTimeout(this.asignaQrBase, 1000);
                    });
            },
            armaRuta(fichero) {
                return "store/" + fichero;
            },
            toggleModal() {
                const body = document.querySelector("body");
                this.active = !this.active;
                this.files = [];
                this.active
                    ? body.classList.add("modal-open")
                    : body.classList.remove("modal-open");
                setTimeout(() => (this.show = !this.show), 10);
            },
            onFileChange(event) {
                console.log("44444444444444444444");
                this.file = event.target.files[0];
            },
            uploadFile() {
                if(this.file == null){
                    return Swal.fire({
                            title: "Upts!",
                            text: "Necesitas seleccionar un fichero!",
                            icon: "error"
                        });
                }
                    let formData = new FormData();
                    formData.append('file', this.file);
                    this.cargando = true;

                    axios.post('/?c=driver&a=upload', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(response.data);
                        Swal.fire({
                            title: "Bien!",
                            text: "Fichero Cargado correctamente!",
                            icon: "success"
                        })
                        .then((result) => {
                            if (result) {
                                this.obtenerFicheros();
                                this.toggleModal();
                                this.cargando = false;
                                this.file = null;
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error al subir el archivo:', error);
                        Swal.fire({
                            title: "Upts!",
                            text: "Error al subir el archivo: " + error,
                            icon: "error"
                        });
                        this.cargando = false;
                    });
                },

            dropHandler(event) {
                console.log("111111111111111111111111");
            // Evita el comportamiento predeterminado del navegador al soltar archivos
            event.preventDefault();

            // esto si que se está guardando
            //this.file = event.target.files[0];

            // Obtiene la lista de archivos soltados
            const droppedFiles = event.dataTransfer.files;

            // Agrega los archivos a la lista
            this.files = Array.from(droppedFiles);
        },
        handleFileInput(event) {
            console.log("2222222222222222222");
            // esto si que se está guardando
            this.file = event.target.files[0];

            // Obtiene la lista de archivos seleccionados a través del input file
            const selectedFiles = event.target.files;

            // Agrega los archivos a la lista
            this.files = Array.from(selectedFiles);
        },
        openFileInput() {
            console.log("333333333333333333333");
            // Abre el explorador de archivos al hacer clic en el área de arrastre
            this.$refs.fileInput.click();
        },
        fileSize(sizeInBytes) {
            // Convierte el tamaño del archivo de bytes a kilobytes (KB)
            // const sizeInKB = sizeInBytes / 1024;

            // Redondea el resultado a dos decimales
            // const roundedSizeInKB = sizeInKB.toFixed(2);

            const sizeInKB = Math.round(sizeInBytes / 1024); // Redondea al entero más cercano

            return `${sizeInKB} KB`;
        },
        eliminaFichero(nombreFichero) {
            console.log(nombreFichero);
            return Swal.fire({
                title: "Ingrese la contraseña",
                input: "password",
                html: "Eliminar: <b class='text-danger'>" + nombreFichero + "</b>",
                inputPlaceholder: "contraseña",
                allowOutsideClick: false,
                inputAttributes: {
                    maxlength: "10",
                    autocapitalize: "off",
                    autocorrect: "off"
                },
                showCancelButton: true
                })
                .then((password)=> {
                    if (password!==null && password.isConfirmed) {
                        if(password.value === '123'){
                            // return this.showToast('Se ha eliminado correctamente', 'success');
                            return axios.post('/?c=driver&a=renombrarFichero', { 'fichero': nombreFichero })
                            .then((respuesta) => {
                                this.obtenerFicheros();
                                return this.showToast('Se ha eliminado correctamente', 'success');
                            });
                        }else{
                            return this.showToast('Contraseña incorrecta!', 'error');
                        }
                    }else {
                        return this.showToast('Transacción cancelada!', 'warning');
                    }
                });
        },
            showToast(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    return Toast.fire({
                        icon: type,
                        title: message
                    });
            },
            visualizarQR (url, title = '') {
                Swal.fire({
                    title: "",
                    text: "",
                    html: '<div class="d-flex align-items-center justify-content-center" style="height: 100%;">'+
                            '<div class="test-2 text-center"></div>'+
                        '</div>',
                    // icon: "success"
                });

                var qrcodex = new QRCode(document.getElementsByClassName("test-2")[0], {
                    text: this.recoveryHostAndPort() + '/' + url,
                    width: 110,
                    height: 110
                });
            },
            recoveryHostAndPort() {
                // Obtener el host del servidor
                var host = window.location.hostname;

                // Obtener el puerto del servidor
                var port = window.location.port;

                // Armar la URL con el host y el puerto
                var url = "http://" + host;
                if (port) {
                    url += ":" + port;
                }

                return url;
            },

            asignaQrBase() {

                // Eliminar cualquier código QR existente
                var qrContainers = document.querySelectorAll('[id^="qr-image-"]');
                qrContainers.forEach(container => {
                    container.innerHTML = ''; // Limpiar el contenido del contenedor
                });

                this.ficheros.forEach((fichero) => {

                    var element = document.getElementById("qr-image-"+fichero.name);

                    var qrCode = new QRCode(element, {
                        text: this.recoveryHostAndPort(), // Usa el nombre del archivo como texto del código QR
                        width: 25,
                        height: 25
                    });

                });
            }
        },
    });
</script>