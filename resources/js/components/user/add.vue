<template>
    <div>

        
        {{ message }}
      
        

         <br>



          <div class="operatingForm">
            <div class="h-opfo">
                <router-link :to="{name:'task.add'}"><i class="fas fa-plus"></i>Add Task</router-link>
                <router-link :to="{name:'users.add'}" style="margin-left:10px"><i class="fas fa-user-plus"></i> Add User</router-link>
            </div>
            <div class="b-opfo">
                <div class="add-user">
                    <fieldset>
                    <legend>Add new user account</legend>
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

                        <label for="">Role</label>
                        <select name="role" v-model="form.isAdmin">
                            <option>please choose level</option>
                            <option 
                                v-for="(l,index) in level" 
                                :key="index" 
                                :value="l">{{ l==1?"admin":"employee" }}</option>   
                        </select>
                        <div v-if="form.errors.has('isAdmin')" v-html="form.errors.get('isAdmin')" class="error" />


                        <input class="defaultbtn" type="submit" @click="newuser()">
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
            isAdmin:""
        }),
        message:""
    }),
    methods:{
        newuser(){
            this.form.post("/api/users")
                .then((res)=>{
                    this.message=res.data.message;
                    this.form.reset();
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
        axios.get("/api/users/create").then((res)=>{
            this.level=res.data.level
        }).catch(()=>{

        });
    }
}
</script>


<style scoped>
    .error{
        color:red;
        font-size: 12px;
    }
</style>