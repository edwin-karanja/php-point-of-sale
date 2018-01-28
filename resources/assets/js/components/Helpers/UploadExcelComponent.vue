<template>
    <div>
        <button class="btn btn-primary pull-right mr-4" @click.prevent="openModal">
            <i class="fa fa-upload"></i>
            Excel Import
        </button>

        <!-- Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload Excel</h4>
                </div>
                <div class="modal-body">
                    <form action="#"  @submit.prevent="uploadExcel" enctype="multipart/form-data">
                        <div class="form-group" :class="{'has-error': upload.errors['file']}">
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        Browse Excel File... <input type="file" id="file-upload" style="display: none;" @change="fileSelected">
                                    </span>
                                </label>
                                <input type="text" v-model="filename" class="form-control" readonly>
                            </div>


                            <span class="help-block" v-if="upload.errors.file">
                                <strong>{{ upload.errors.file[0] }}</strong>
                            </span>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <span v-if="!this.uploading">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                </span>
                                <span v-if="this.uploading">
                                    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                </span>
                                Upload Excel
                            </button>

                            <button class="btn btn-primary pull-right" @click.prevent="downloadSample">
                                <span>
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </span>
                                Download Sample
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click.prevent="closeModal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import eventHub from '../../events.js'

    export default {
        props: ['url'],

        data() {
            return {
                filename: '',
                uploading: false,
                upload: {
                    file: null,
                    errors: []
                },
            }
        },

        methods: {
            fileSelected () {
                var input = $('#file-upload'),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

                this.setInputText(numFiles, label);
            },

            downloadSample () {
                this.closeModal()
                window.location.href = '/ajax/items/download_sample'
            },

            setInputText (numFiles, label) {
                this.filename = numFiles > 1 ? numFiles + ' files selected' : label;
            },

            openModal () {
                $('#importModal').modal('show')
            },

            closeModal () {
                this.upload.file = null
                this.upload.errors = []
                $('#importModal').modal('hide')
            },

            uploadExcel () {
                this.uploading = true;
                var input = $('#file-upload');
                this.upload.file = input.get(0).files[0];

                let formData = new FormData()
                formData.append('file', this.upload.file)

                axios.post(this.url, formData).then((response) => {
                    if (response.status === 200) {
                        let data = response.data
                        this.closeModal()

                        eventHub.$emit('item-created')

                        eventHub.$emit('success-alert', 'All your records have been successfully uploaded and inserted.');
                    }

                    //  eventHub.$emit('error-alert', data.errorMsg);

                }).catch((error) => {
                    this.uploading = false;
                    if (error.response.status === 422) {
                        this.upload.errors = error.response.data.errors
                        return
                    }

                    if (error.response.status === 500) {
                         eventHub.$emit('error-alert', error.response.data.errorMsg)
                    }
                })
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>


<style scaled>
    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>