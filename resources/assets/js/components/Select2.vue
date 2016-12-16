<template>
    <select class="select2" multiple="multiple" placeholder="Assignee">
        <slot></slot>
    </select>
</template>


<script>

    import 'select2';

    module.exports = {
        props: ['options', 'value'],
        mounted: function () {
            var vm = this;
            $(this.$el)
                    .val(vm.value)
                    .select2({ data: this.options })
                    .on('change', function () {
                        vm.$emit('input', $(vm.$el).val());
                    });

            setTimeout(function(){
                $(vm.$el).val(vm.value).trigger('change');
            },500);
        },
        watch: {
            value: function (value) {
                this.value = value;
                //$(this.$el).val(value).trigger('change');
            },
            options: function (options) {
                $(this.$el).select2({ data: options })
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>

<style scoped>
    .select2 {
        width: 100%;
    }
</style>