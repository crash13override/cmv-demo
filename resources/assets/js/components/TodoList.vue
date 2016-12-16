<template>
    <table class="todo-list">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Assignee</th>
            <th>Date</th>
        </tr>
        <tr v-for="todo in todos">
            <td>{{ todo.title }}</td>
            <td>{{ todo.description }}</td>
            <td>{{ todo.priority }}</td>
            <td>{{ todo.assignee }}</td>
            <td>{{ todo.date }}</td>
        </tr>
    </table>
</template>

<script>
    module.exports = {
        props: ['todos']
    }
</script>


<style scoped>
    table.todo-list {
        width: 100%;
    }
</style>