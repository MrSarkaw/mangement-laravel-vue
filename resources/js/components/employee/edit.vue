<template>
      <div>
<div class="operatingForm">
            
            <p style="color:green">  {{ message }}</p>
          
            <div class="b-opfo">
                <div class="add-user">
                    <fieldset>
                    <legend>Edit Profile</legend>
                    <div class="insideau">
                        <label for="" class="mt0">Full Name</label>
                        <input type="text"  v-model="form.name">
                        <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" class="error" />



                        <label for="">Email</label>
                        <input type="text" name="email" v-model="form.email">
                        <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" class="error" />

                        <label for="">Password</label>
                        <input v-model="form.password" type="password">
                        <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" class="error" />

                        <label for="">password_confirmation</label>
                        <input  v-model="form.password_confirmation" type="password">
                    <div v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')" class="error" />
                    
                        <label for="">image</label>
                        <input  @change="getNameImage" type="file">

                       
                        <input class="defaultbtn" type="submit" @click="updateuser()" value="update" style="margin-top:10px">
                    </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data:()=>({
        level:[],
        form: new Form({
            name:"",
            email:"",
            password:"",
            password_confirmation:"",
            path:"",
        }),
        message:""
    }),
    methods:{
        updateuser(){
            this.form.patch("/api/employee/profile")
                .then((res)=>{
                    this.message=res.data.message;
                      this.$store.dispatch("currentUser/getUser");
                }).catch(()=>{
                    console.log("error")
                })
        },
        getNameImage(e){
            let file=e.target.files[0];
            let reader=new FileReader();
            reader.onloadend=(result)=>{
                this.form.path=result.target.result;
            }
            reader.readAsDataURL(file);
        }
    },
    created(){

        axios.get("/api/employee/fetchProfile").then((res)=>{
            this.form.fill({
                name:res.data.user.name,
                email:res.data.user.email,
                password:"",
                password_confirmation:"",
                path:"",
            });
        }).catch(()=>{});
    }
}
</script>