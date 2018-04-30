<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" @submit.prevent="submit">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" v-model="name" value="" required autofocus>

                                <span class="help-block" v-if="errors.name">
                                    <strong>{{ errors.name[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Gender</label>

                            <div class="col-md-6">
                                <select v-model="gender" id="gender" class="form-control" required>
                                    <option value=""> --Choose gender -- </option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>

                                <span class="help-block" v-if="errors.gender">
                                    <strong>{{ errors.gender[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-model="email" value="" required>

                                <span class="help-block" v-if="errors.email">
                                    <strong>{{ errors.email[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" v-model="password" required>

                                <span class="help-block" v-if="errors.password">
                                    <strong>{{ errors.password[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        data () {
            return {
                name: null,
                gender: null,
                email: null,
                password: null,
                password_confirmation: null,
                errors: {}
            }
        },

        methods: {
            ...mapActions({
                register: 'auth/register'
            }),

            submit () {
                this.register({
                    payload: {
                        name: this.name,
                        gender: this.gender,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    }
                });
            }
        }
    }
</script>