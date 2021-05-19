<template>
    <div>
        <p>{{ errors.message }}</p>
        <input type="text" v-model="user.email"> 
        <p v-for="(error,index) in errors.email" :key="index">{{ error }}</p> <br>

        <input type="password" v-model="user.password"> 
         <p v-for="(error,index) in errors.password" :key="index+100">{{ error }}</p> <br>

        <button @click="login()">login</button>
        
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