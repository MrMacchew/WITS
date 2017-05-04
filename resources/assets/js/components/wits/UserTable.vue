<template>
   <table class="table table-striped" style="border-collapse:collapse;">
    <thead>
      <tr>
        <th></th>
        <th>id</th>
        <th>First</th>
        <th>Last</th>
        <th>Email</th>
        <th>Role</th>
        <th>Department</th>
    </tr>
</thead>

<tbody>


</tbody>
</table>
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
            axios.get('/api/v1/users')
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
