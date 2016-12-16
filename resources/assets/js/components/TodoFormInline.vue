<template>
    <div class="demo demo-inline">
        <form class="form-inline" v-on:submit.prevent="createTodo">
            <div class="form-group">
                <input type="text" class="form-control text-input" name="title" v-model="todo_form.title" placeholder="Title" v-on:keyup.enter="createTodo">
            </div>
            <div class="form-group">
                <input type="text" class="form-control text-input" name="description" v-model="todo_form.description" placeholder="Description" v-on:keyup.enter="createTodo">
            </div>
            <div class="form-group">
                <input type="range" step="1" min="1" max="5" class="form-control slider-input" name="priority" v-model="todo_form.priority" placeholder="Priority">
            </div>
            <div class="form-group select-group">
                <select2 :options="users" v-model="todo_form.assignees">
                    <option disabled value="0">Select one</option>
                </select2>
            </div>
            <div class="form-group">
                <input type="date" class="form-control date-input" name="date" v-model="todo_form.date" placeholder="Date">
            </div>
            <div class="form-group">
                <div class="btn btn-primary" @click="createTodo">Create</div>
            </div>
        </form>
    </div>
</template>

<script>
    module.exports = {
        props: ['todos', 'people'],
        data() {
            return {
                todo_form: {
                    title: '',
                    description: '',
                    priority: 5,
                    assignees: [],
                    date: '2016-12-15'
                },
                users: null
            }
        },
        mounted() {
            this.users = this.people.map(function(item){
                return {text: item.name, id: item.id};
            });
        },
        methods: {
            createTodo() {
                let vm = this;
                this.$http.post('/todo',this.todo_form).then((response) => {
                    vm.todos.push(response.data);
                    vm.reset();

                });
            },
            reset() {
                this.todo_form.title = '';
                this.todo_form.description = '';
                this.todo_form.priority = 5;
                this.todo_form.assignees = [];
                this.todo_form.date = '2016-12-15';
            }
        }
    }
</script>


<style scoped>
    input.text-input{
        width: 120px;
    }

    .select-group {
        width: 160px;
    }

    input.slider-input {
        width: 80px;
    }

    input.date-input {
        width: 160px;
    }
</style>