<template>
    <div>
        <br>
        <h4><b>Create Employee</b></h4>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="createEmployee">

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="employee.first_name" placeholder="Enter First Name">
                        <span style='color: red'><small >{{ error_first_name }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="employee.last_name" placeholder="Enter Last Name">
                        <span style='color: red'><small >{{ error_last_name }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="employee.email" placeholder="Enter Email">
                        <span style='color: red'><small >{{ error_email }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="employee.phone" placeholder="Enter Phone">
                        <span style='color: red'><small >{{ error_phone }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <label>Select Company:</label>
                        <select class='form-control' v-model='employee.company_id'>
                            <option v-for='data in companies' :value='data.id' v-bind:key="data.id">{{ data.name }}</option>
                        </select>
                        <span style='color: red'><small >{{ error_company_name }} </small></span>
                    </div><br>

                    <button type="submit" class="btn btn-primary">Create Employee</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employee: {},
            companies: [],
            error_first_name: '',
            error_last_name: '',
            error_email: '',
            error_phone: '',
            error_company_name: '',
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/companies/all_companies')
                .then(response => {
                    this.companies = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        createEmployee() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/employees/store', this.employee)
                    .then(response => {
                        console.log(response); //return false;
                        this.$router.push({name: 'employees'})
                    })
                    .catch(error => {
                        console.log(error.response.data.errors);
                        this.error_first_name   = error.response.data.errors.first_name;
                        this.error_last_name    = error.response.data.errors.last_name;
                        this.error_email        = error.response.data.errors.email;
                        this.error_phone        = error.response.data.errors.phone;
                        this.error_company_name = error.response.data.errors.company_id;
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
