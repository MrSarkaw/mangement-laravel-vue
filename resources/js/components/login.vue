<template>
    <div>

             <div class="loginff">
                <div class="loign">
                    <div class="in-loign">
                        <h1>Welcome!</h1>
                        <i class="far fa-envelope"></i><input type="text" placeholder="Email" v-model="user.email">
                       <p class="m0" v-for="(error,index) in errors.email" :key="index">{{ error }}</p> <br>

                        <i class="fas fa-lock"></i><input type="password" v-model="user.password" placeholder="Password"
                            style="padding-left:40px">
                         <p class="m0" v-for="(error,index) in errors.password" :key="index+100">{{ error }}</p> <br>
                        <input type="submit" @click="login()" value="Login">
                    </div>
                </div>
         </div>
        
    </div>
</template>

<script>
export default {
    data:()=>({
        user:{
            email:"",
            password:""
        }
    }),
    computed:{
        errors(){
            get:{
                return this.$store.state.currentUser.errors;
            }
        }
    },
    methods:{
        login(){
            this.$store.dispatch("currentUser/login",this.user)          
        }
        
    }
}
</script>


<style>
    p{
        color:red
    }
</style>