<template>
  <div>
    <div class="row">
      <aside class="col-md-3 col-xs-12">
      <ui-collapsible title="Add Role">


        <form @submit.prevent="onSubmitRole">

          <ui-textbox
          floating-label
          label="Role Name"
          v-model="formRole.name"
          :error="formRole.errors.get('name')"
          :invalid="!!formRole.errors.get('name')"
          @keydown="formRole.errors.clear('name')"
          />

          <ui-button buttonType="submit" type="primary" color="primary" size="small">Add Role</ui-button>

        </form>

      </ui-collapsible>
    </aside>

        <div class="col-md-9 col-xs-12">
          <table class="table table-striped">

            <thead>
              <tr>
                <th width="1%">Permissions</th>
                <th class="rotate"> <div> <span>Admin</span> </div> </th>
                <th class="rotate"> <div> <span>Deptment Admin</span> </div> </th>
                <th class="rotate"> <div> <span>Deptment User</span> </div> </th>
                <th class="rotate"> <div> <span>Auditor</span> </div> </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>Permission 1</td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
              </tr>
            </tbody>

          </table>
        </div>
      </div>
  </div>
</template>

<script>
import Fuse from 'fuse.js';
import _ from 'lodash';
import toastr from 'toastr';
import confirm from 'jquery-confirm';
import Form from '../../utils/Form';



export default {
  data() {
    return {
      roles: [],
      formRole: new Form({
        name:""
      }),
    }
  },
  methods: {
    onSubmitRole: function (e) {
      var vm = this
      // console.log('onSubmitRole', this, e)

      this.formRoles
      // .beforeSubmit(function(form){
      //   console.log(form)
      //   if (form.get('parent_roles_id')) {
      //     form.set('parent_roles_id', form.get('parent_roles_id').id)
      //   }
      // })
      .post('/api/v1/roles')
      .then(function(response){
        vm.roles.push(response)
        toastr["success"]("Saved Roles")
      })
      .catch(errors => console.log(this.formRoles.errors.errors))
    }
  },
  watch: {},
  mounted() {
      // console.log(this)
    }
  }
</script>

<style>
  th.rotate {
  /* Something you can count on */
  height: 140px;
  white-space: nowrap;
  width: 1%;
}

th.rotate > div {
  transform:
    /* Magic Numbers */
    translate(0px, 0px)
    /* 45 is really 360 - 45 */
    rotate(-45deg);
  border-bottom:1px solid #ccc;
  width: 30px;
}
th.rotate > div {
/*   border-bottom: 1px solid #ccc; */
  padding: 5px 10px;
}
</style>