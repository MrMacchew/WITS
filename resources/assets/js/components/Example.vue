<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>
                    <div class="panel-body">{{user.email}}</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                user:""
            }
        },
        mounted() {
            var vm = this;
            console.log('Component mounted.')
            axios.get('/api/user')
            .then(function (response) {
                console.log(response);
                vm.user = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
</script>
