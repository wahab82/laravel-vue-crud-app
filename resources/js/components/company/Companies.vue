<template>
    <div>
        <br/><h4><b>All Companies</b></h4>
        <hr>
        <div>
            <button type="button" class="btn btn-info" @click="this.$router.push('/companies/store')">Create Company</button>
        </div>
        <br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Logo</th>
                <th>Website</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="company in companies.data" :key="company.id">
                <td>{{ company.id }}</td>
                <td>{{ company.name }}</td>
                <td>{{ company.email }}</td>
                <td>
                    <img :src="`/images/${company.logo}`" alt="logo" style="width: 200px; height: 100px; object-fit: cover;">
                </td>
                <td>{{ company.website }}</td>
                <td>
                    <router-link :to="{name: 'showcompany', params: { id: company.id }}">
                        <button class="btn btn-outline-success btn-sm" style="margin-right:10px;">View</button>
                    </router-link>
                    <router-link :to="{name: 'editcompany', params: { id: company.id }}">
                        <button class="btn btn-outline-primary btn-sm" style="margin-right:10px;">Edit</button>
                    </router-link>
                    <button class="btn btn-outline-danger btn-sm" @click="deleteCompany(company.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :data="companies" @pagination-change-page="getResults" />
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
            companies: {}
        }
    },

    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/companies')
                .then(response => {
                    this.companies = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },

    methods: {
        getResults(page = 1) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/companies?page=' +page)
                .then(response => {
                    this.companies = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },

        deleteCompany(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/companies/delete/${id}`)
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
