<template>
    <div class="demo demo-excel">

        <div class="alert alert-info">
            Download <a href="/cmv-demo.xlsx" class="alert-link">here</a> an example file.
        </div>

        <form action="/todo/excel" class="dropzone" id="excel-dropzone">
            <div class="dz-message" v-on:click="checkClick">
                <div class="drop-ready-msg" v-if="drop_ready">
                    {{ drop_name }}
                    <span>{{ drop_size }}</span>
                    <div class="drop_cancel" v-show="drop_progress<=0" v-on:click="removeFiles">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="drop-default-msg" v-else>
                    Drop an Excel file here or click to select one
                </div>
            </div>

            <div class="form-group clearfix" v-show="drop_ready && drop_progress<=0">
                <div class="btn btn-primary btn-upload" v-on:click="uploadFile">Upload it!</div>
            </div>

            <div class="progress progress-striped active" v-show="drop_ready && drop_progress>0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" v-bind:style="{width: drop_progress+'%'}" data-dz-uploadprogress></div>
            </div>
        </form>

    </div>
</template>

<script>

    import Dropzone from 'dropzone';

    module.exports = {
        props: ['todos', 'people'],
        data() {
            return {
                dropzone: null,
                drop_ready: false,
                drop_name: '',
                drop_size: '',
                drop_progress: 0,
                show_alert: false,
                error_msg: ''
            }
        },
        mounted() {
            this.assignees = this.people.map(function (item) {
                return {text: item.name, id: item.id};
            });

            let vm = this;

            Dropzone.autoDiscover = false;
            this.dropzone = new Dropzone('#excel-dropzone', {
                paramName: 'excel',
                method: 'post',
                maxFilesize: 2,
                uploadMultiple: false,
                acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                maxFiles: 1,
                addRemoveLinks: false,
                autoProcessQueue: false,
                createImageThumbnails: false,
                init: function () {
                    // initial hook
                    this.on("addedfile", function (file) {
                        vm.drop_ready = true;
                        vm.drop_name = file.name;
                        vm.drop_size = Math.round(file.size / 1000) + 'KB';
                        vm.show_alert = false;
                    });
                    this.on("totaluploadprogress", function (progress) {
                        vm.drop_progress = progress;
                    });
                },
                success: function (file, response) {
                    vm.dropzone.removeFile(file);
                    vm.reset();

                    for (var i = 0; i < response.length; i++) {
                        vm.todos.push(response[i]);
                    }

                },
                error: function (file, response) {
                    vm.error_msg = response;
                }
            });
        },
        methods: {
            uploadFile() {;
                this.dropzone.processQueue();
            },
            reset() {
                this.drop_ready = false;
                this.drop_name = '';
                this.drop_size = '';
                this.drop_progress = 0;
            },
            checkClick(e) {
                if (this.drop_ready) {
                    e.stopPropagation();
                }
            },
            removeFiles(e) {
                this.dropzone.removeAllFiles();
                this.reset();
            }
        }
    }
</script>


<style scoped>
    .btn-upload {
        margin-top: 20px;
    }
</style>