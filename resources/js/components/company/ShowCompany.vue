<template>
    <div>
        <br /> <h4><b>Show Company</b></h4>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr><td><b>ID</b></td><td>{{ company.id }}</td></tr>
                        <tr><td><b>Name</b></td><td>{{ company.name }}</td></tr>
                        <tr><td><b>Email</b></td><td>{{ company.email }}</td></tr>
                        <tr><td><b>Logo</b></td><td><img :src="`/images/${company.logo}`" alt="logo" style="width: 200px; height: 100px; object-fit: cover;"></td></tr>
                        <tr><td><b>Website</b></td><td>{{ company.website }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {}
        }
    },
    created() {
        console.log(2222);
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/companies/show/${this.$route.params.id}`)
                .then(response => {
                    this.company = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
