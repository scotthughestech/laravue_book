<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>
                    Purchases
                </span>

                <a class="action-link" @click="showCreatePurchaseForm">
                        Create New Purchase
                </a>
            </div>
        </div>
        <div class="panel-body">
            <p class="m-b-none" v-if="purchases.length === 0">
                You have not created any purchases.
            </p>
            <table class="table table-borderless m-b-none" v-if="purchases.length > 0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="purchase in purchases">
                        <td style="vertical-align: middle;">
                            {{ purchase.date }}
                        </td>
                        <td style="vertical-align: middle;">
                            ${{ purchase.price }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ purchase.description }}
                        </td>
                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link" @click="edit(purchase)">
                                Edit
                            </a>
                        </td>
                        <!-- Delete Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="confirm(purchase.id)">
                                Delete
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Create Purchase Modal -->
    <div class="modal fade" id="modal-create-purchase" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Purchase</h4>
                </div>

                <div class="modal-body">
                    <!-- Form Errors -->
                    <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <br>
                        <ul>
                            <li v-for="error in createForm.errors">
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <!-- Create Purchase Form -->
                    <form class="form-horizontal" role="form">
                        <!-- Date -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date</label>
                            <div class="col-md-7">
                                <input id="create-purchase-date" type="text" class="form-control"
                                                            @keyup.enter="store" v-model="createForm.date">
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Price</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="price"
                                                @keyup.enter="store" v-model="createForm.price">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="description"
                                                @keyup.enter="store" v-model="createForm.description">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="store">
                        Create
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Purchase Modal -->
    <div class="modal fade" id="modal-edit-purchase" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Purchase</h4>
                </div>
                <div class="modal-body">
                    <!-- Form Errors -->
                    <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <br>
                        <ul>
                            <li v-for="error in editForm.errors">
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <!-- Edit Purchase Form -->
                    <form class="form-horizontal" role="form">
                        <!-- Date -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date</label>

                            <div class="col-md-7">
                                <input id="edit-purchase-date" type="text" class="form-control"
                                                            @keyup.enter="update" v-model="editForm.date">
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Price</label>

                            <div class="col-md-7">
                                <input type="text" class="form-control" name="price"
                                                @keyup.enter="update" v-model="editForm.price">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>

                            <div class="col-md-7">
                                <input type="text" class="form-control" name="description"
                                                @keyup.enter="update" v-model="editForm.description">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="modal-confirm-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Purchase?</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this purchase?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                purchases: [],
                createForm: {
                    errors: [],
                    date: '',
                    price: '',
                    description: ''
                },
                editForm: {
                    errors: [],
                    id: '',
                    date: '',
                    price: '',
                    description: ''
                },
                deleteId: ''
            }
        },
        mounted() {
            this.getPurchases();
            $('#modal-create-purchase').on('shown.bs.modal', () => {
                $('#create-purchase-date').focus();
            });
            $('#modal-edit-purchase').on('shown.bs.modal', () => {
                $('#edit-purchase-date').focus();
            });
        },
        methods: {
            getPurchases() {
                axios.get('/purchases')
                    .then(response => {
                        this.purchases = response.data;
                    });
            },
            showCreatePurchaseForm() {
                $('#modal-create-purchase').modal('show');
            },
            store() {
                this.persistPurchase(
                    'post', '/purchases',
                    this.createForm, '#modal-create-purchase'
                );
            },
            edit(purchase) {
                this.editForm.id = purchase.id;
                this.editForm.date = purchase.date;
                this.editForm.price = purchase.price;
                this.editForm.description = purchase.description;

                $('#modal-edit-purchase').modal('show');
            },
            update() {
                this.persistPurchase(
                    'put', '/purchases/' + this.editForm.id,
                    this.editForm, '#modal-edit-purchase'
                );
            },
            persistPurchase(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getPurchases();

                        form.date = '';
                        form.price = '';
                        form.description = '';
                        form.errors = [];

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },
            confirm(purchaseId) {
                this.deleteId = purchaseId;
                $('#modal-confirm-delete').modal('show');
            },
            destroy() {
                axios.delete('/purchases/' + this.deleteId)
                    .then(response => {
                        this.getPurchases();
                    });
                $('#modal-confirm-delete').modal('hide');
            }
        }
    }
</script>
