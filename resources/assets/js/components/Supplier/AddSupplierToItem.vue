<template>
    <div>
        <button class="btn btn-success btn-sm pull-right" @click.prevent="openModal">
            Add Supplier
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createSupplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                        <br>
                        <input type="text" class="form-control" placeholder="Search Supplier">
                    </div>
                    <div class="modal-body">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Pin No:</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="s in suppliers">
                                    <td>{{ s.name }}</td>
                                    <td>{{ s.vat_pin || '-'}}</td>
                                    <td>
                                        <a href="#" @click.prevent="attachSupplier(s)" class="btn btn-xs btn-primary">Attach</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="ui button" @click.prevent="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      props: {
        item: {
          type: Object,
          required: true
        }
      },
      data () {
        return {
          suppliers: []
        }
      },

      methods: {
        fetchSuppliers () {
          return axios.get('/items/' + this.item.id + '/suppliers/show').then((response) => {
            this.suppliers = response.data.all;
          });
        },

        attachSupplier (supplier) {
          return axios.post('/items/' + this.item.id + '/suppliers/attach', { id: supplier.id }).then(() => {
            // remove from list of suppliers
            this.suppliers = _.remove(this.suppliers, function(s) {
              return s.id !== supplier.id;
            })
          })
        },

        openModal () {
          $('#createSupplierModal').modal('show');
        },

        closeModal () {
          $('#createSupplierModal').modal('hide');
        }
      },

      mounted () {
        this.fetchSuppliers();
      }
    }
</script>
