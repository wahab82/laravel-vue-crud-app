<template>
    <div>
        <br /> <h4><b>Show Employee</b></h4> <br />

        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr><td><b>ID</b></td><td>{{ employee.id }}</td></tr>
                        <tr><td><b>First Name</b></td><td>{{ employee.first_name }}</td></tr>
                        <tr><td><b>Last Name</b></td><td>{{ employee.last_name }}</td></tr>
                        <tr><td><b>Email</b></td><td>{{ employee.email }}</td></tr>
                        <tr><td><b>Phone</b></td><td>{{ employee.phone }}</td></tr>
                        <tr><td><b>Company</b></td><td>{{ employee.companyName }}</td></tr>
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
            employee: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/employees/show/${this.$route.params.id}`)
                .then(response => {
                    this.employee = response.data;
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
