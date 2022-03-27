<template>
    <div>
        <br /> <h4><b>Edit Company</b></h4>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateCompany" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="name">
                        <span style='color: red'><small >{{ error_name }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="email">
                        <span style='color: red'><small >{{ error_email }} </small></span>
                    </div><br>

                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" class="form-control" v-on:change="onLogoChange">
                        <span style='color: red'><small >{{ error_logo }} </small></span>
                        <br>
                        <div class="image-preview" v-if="imageData.length > 0">
                            <img class="preview" :src="imageData" style="width: 200px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="image-preview" v-else>
                            <img :src="`/images/${logo}`" id="img-logo" alt="logo" style="width: 200px; height: 100px; object-fit: cover;">
                        </div>
                    </div><br>

                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="website">
                        <span style='color: red'><small >{{ error_website }} </small></span>
                    </div><br>

                    <button type="submit" class="btn btn-primary">Update Company</button>
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
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/companies/edit/${this.$route.params.id}`)
                .then(response => {
                    console.log(response.data);
                    this.name    = response.data.name;
                    this.email   = response.data.email;
                    this.logo    = response.data.logo;
                    this.website = response.data.website;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        updateCompany() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email ? this.email : "");
            formData.append('website', this.website ? this.website : "");
            formData.append('logo', this.logo ? this.logo : "");

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/companies/update/${this.$route.params.id}`, formData, config)
                    .then(response => {
                        this.$router.push({name: 'companies'});
                    })
                    .catch(error => {
                       this.error_name    = error.response.data.errors.name;
                       this.error_email   = error.response.data.errors.email;
                       this.error_logo    = error.response.data.errors.logo;
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
