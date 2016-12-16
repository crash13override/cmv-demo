<template>
    <div class="demo demo-csv">
        <form>
            <div class="form-group">
                <label class="control-label">Field Delimiter</label>
                <input type="text" class="form-control" name="delimiter" v-model="delimiter" placeholder=";">
            </div>
            <div class="form-group">
                <label class="control-label">Text</label>
                <textarea class="form-control" name="text" v-model="content" placeholder="Title;Description;Priority;Assignee;Date"></textarea>
            </div>
            <div class="form-group">
                <div class="btn btn-primary" @click="createTodos">Create To-dos</div>
            </div>
        </form>
    </div>
</template>

<script>
    module.exports = {
        props: ['todos', 'people'],
        data() {
            return {
                delimiter: ';',
                content: ''
            }
        },
        mounted() {
            this.assignees = this.people.map(function (item) {
                return {text: item.name, id: item.id};
            });
            console.log(this.assignees);
        },
        methods: {
            createTodos() {
                let vm = this;
                this.$http.post(
                    '/todo/csv',
                    {
                        delimiter: this.delimiter,
                        content: this.content
                    }).then(response => {
                        for (var i = 0; i < response.data.length; i++) {
                            vm.todos.push(response.data[i]);
                        }
                    }
                );
            }
        }
    }
</script>


<style>
</style>