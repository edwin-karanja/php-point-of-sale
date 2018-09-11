<template>
    <div>
        <AppButton class="pull-right mr-4" theme="success" @click.prevent="openModal">
            <i class="fa fa-upload"></i>
            Import Items
        </AppButton>

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
                            <AppButton type="submit" @click.prevent="uploadExcel" theme="primary">
                                <span v-if="!this.uploading">
                                    <svg class="icon-sm color-w" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M13 5.41V17a1 1 0 0 1-2 0V5.41l-3.3 3.3a1 1 0 0 1-1.4-1.42l5-5a1 1 0 0 1 1.4 0l5 5a1 1 0 1 1-1.4 1.42L13 5.4zM3 17a1 1 0 0 1 2 0v3h14v-3a1 1 0 0 1 2 0v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3z"/></svg>
                                </span>
                                <span v-if="this.uploading">
                                    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                </span>
                                Upload Excel
                            </AppButton>

                            <AppButton theme="primary" @click.prevent="downloadSample" class="pull-right">
                                <span>
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </span>
                                Download Sample
                            </AppButton>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <AppButton @click.prevent="closeModal">
                        Close
                    </AppButton>
                </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import eventHub from '../../events.js';
    import AppButton from '../Global/AppButton'

    export default {
        components: {
            AppButton
        },

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
                this.closeModal();
                window.location.href = '/ajax/items/download_sample'
            },

            setInputText (numFiles, label) {
                this.filename = numFiles > 1 ? numFiles + ' files selected' : label;
            },

            openModal () {
                $('#importModal').modal('show');
            },

            closeModal () {
                this.upload.file = null;
                this.upload.errors = [];
                $('#importModal').modal('hide');
            },

            uploadExcel () {
                this.uploading = true;
                let input = $('#file-upload');
                this.upload.file = input.get(0).files[0];

                let formData = new FormData();
                formData.append('file', this.upload.file);

                axios.post('/ajax/items/import', formData).then((response) => {
                    if (response.status === 200) {
                        this.closeModal();

                        eventHub.$emit('item-created');

                        eventHub.$emit('success-alert', 'All your records have been successfully uploaded and inserted.');
                    }

                    //  eventHub.$emit('error-alert', data.errorMsg);

                }).catch((error) => {
                    this.uploading = false;
                    if (error.response.status === 422) {
                        this.upload.errors = error.response.data.errors;
                        return
                    }

                    if (error.response.status === 500) {
                         eventHub.$emit('error-alert', error.response.data.errorMsg);
                    }
                })
            }
        },

        mounted() {
            //
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

    .color-w {
        fill: white;
    }
</style>