<template>
    <div>
        <br>
        <h4><b>Create Company</b></h4>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="createCompany" enctype="multipart/form-data">

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="name" placeholder="Enter Company Name">
                        <span style='color: red'><small >{{ error_name }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="email" placeholder="Enter Email">
                        <span style='color: red'><small >{{ error_email }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="website" placeholder="Enter Website">
                        <span style='color: red'><small >{{ error_website }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" class="form-control" v-on:change="onLogoChange">
                        <span style='color: red'><small >{{ error_logo }} </small></span>
                        <div class="image-preview" v-if="imageData.length > 0">
                            <br>
                            <img class="preview" :src="imageData" style="width: 200px; height: 100px; object-fit: cover;">
                        </div>
                    </div><br>

                    <button type="submit" class="btn btn-primary">Create Company</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            website: '',
            logo: '',
            imageData: '',
            error_name: '',
            error_email: '',
            error_logo: '',
            error_website: '',
        }
    },
    methods: {
        createCompany() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('website', this.website);
            formData.append('logo', this.logo);

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/companies/store', formData, config)
                    .then(response => {
                        this.$router.push({name: 'companies'})
                    })
                    .catch(error => {
                       this.error_name = error.response.data.errors.name;
                       this.error_email = error.response.data.errors.email;
                       this.error_logo = error.response.data.errors.logo;
                       this.error_website = error.response.data.errors.website;
                    });
            })
        },
        onLogoChange(e){
            var input = e.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.imageData = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
            this.logo = input.files[0];
        },
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
