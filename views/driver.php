<div id="app" style="z-index: -1!important;">
    <div class="container text-center mb-5 mt-3">
        <h1>DRIVER LOCAL <small class="small badge"><small class="badge badge-warning small"><?php echo($_ENV['version'] ?? 'v1.0.1'); ?></small></small></h1>
    </div>

    <div v-for="fichero in ficheros" style="z-index: -1!important;">
        <div class="text-center mb-2">
            <a class="badge badge-success" :href="armaRuta(fichero.name)" target="_blank"><h5>{{fichero.name}} <small>(descargar)</small> </h5></a>
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
  <div class="modal-dialog " role="document" style="color: black">
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

<div class="bloque-drag-and-drog">
        <!-- Área de arrastre de archivos -->
        <div class="drop-area" @drop.prevent="dropHandler" @dragover.prevent @click="openFileInput">
            Arrastra y suelta archivos aquí
        </div>
        <!-- Input de tipo file oculto -->
        <input type="file" style="display: none" ref="fileInput" @change="handleFileInput">
        <!-- Lista de archivos seleccionados -->
        <div class="table-responsive">
            <table class="table table-striped table-sm table-dark " v-if="files.length > 0">
                <thead>
                    <tr>
                        <th>Archivo</th>
                        <th>Tamaño</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="(file, index) in files" :key="index">
                        <td class="truncate" :title="file.name">{{ file.name }}</td>
                        <td>{{ fileSize(file.size) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
      <div class="modal-footer" v-if="files.length > 0 /*!cargando*/">
        <button type="button" @click="uploadFile" class="btn btn-primary">Completar la carga de fichero</button>
      </div>
    </div>
  </div>
</div>



</div>


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
            // Evita el comportamiento predeterminado del navegador al soltar archivos
            event.preventDefault();

            // Obtiene la lista de archivos soltados
            const droppedFiles = event.dataTransfer.files;

            // Agrega los archivos a la lista
            this.files = Array.from(droppedFiles);
        },
        handleFileInput(event) {
            // Obtiene la lista de archivos seleccionados a través del input file
            const selectedFiles = event.target.files;

            // Agrega los archivos a la lista
            this.files = Array.from(selectedFiles);
        },
        openFileInput() {
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
        }

            },
    });
</script>
