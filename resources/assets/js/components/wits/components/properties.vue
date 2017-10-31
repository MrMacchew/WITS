<template>
    <div>

        <p>ID: {{id}}</p>

        <div>
            <div >

            </div>

            <div class="table-responsive">
                <table class="table">
                    <colgroup>
                        <col class="col-xs-2"></col>
                        <col class="col-xs-6"></col>
                        <col class="col-xs-1"></col>
                    </colgroup>

                    <tbody>
                    <tr>
                        <td>{{item.name.name}}: </td>
                        <td><input type="text" v-model="item.value"></td>
                        <td><button v-on:click="removeProperty(key)"> X </button></td>
                    </tr>
                    </tbody>
                </table>
            </div>




        </div>

        <button @click="addProperty">Add Property</button>

        <p>properties oh and Additional Asset Properties (for each...) on the Advanced tab</p>



        <code>
            <pre>{{properties}}</pre>
        </code>

    </div>
</template>
<script>
    export default {
        props: ['id', 'data'],
        data: function () {
            return {
                properties: this.data,
                propertyList: []
            }
        },
        methods: {
            addProperty(){
                this.properties.push({id: null, name:'', value:''})
                console.log('addProperty', this.properties)
            },

            removeProperty(key) {
                this.properties.splice(key,1)
                console.log('remove item from server', this.properties)
            }
        },
        watch: {},
        computed: {},
        mounted() {
            var vm = this
            console.log(this.$data)
        }

    }

</script>
