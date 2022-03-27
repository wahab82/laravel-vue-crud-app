<template>
    <div>
        <br><h4><b>All Employees</b></h4><hr>
        <div>
            <button type="button" class="btn btn-info" @click="this.$router.push('/employees/store')">Add Employee</button>
        </div>
        <br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees.data" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.first_name }}</td>
                <td>{{ employee.last_name }}</td>
                <td>{{ employee.email }}</td>
                <td>{{ employee.phone }}</td>
                <td>{{ employee.companyName }}</td>
                <td>
                    <router-link :to="{name: 'showemployee', params: { id: employee.id }}">
                        <button class="btn btn-outline-success btn-sm" style="margin-right:10px;">View</button>
                    </router-link>
                    <router-link :to="{name: 'editemployee', params: { id: employee.id }}">
                        <button class="btn btn-outline-primary btn-sm" style="margin-right:10px;">Edit</button>
                    </router-link>
                    <button class="btn btn-outline-danger btn-sm" @click="deleteEmployee(employee.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :data="employees" @pagination-change-page="getResults" />
    </div>
</template>

<script>
import Pagination from 'laravel-vue-pagination';

export default {
    components: {
        'Pagination': Pagination
    },

    data() {
        return {
            employees: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/employees')
                .then(response => {
                    this.employees = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        getResults(page = 1) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/employees?page=' +page)
                .then(response => {
                    this.employees = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },

        deleteEmployee(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/employees/delete/${id}`)
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(function (error) {
                        console.error(error);
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
