<template>
    <div>
            <div id="load" v-if="load">
                <div class="lds-dual-ring"></div>
            </div>
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
                         <p style="padding:5px;text-align:center;background:red;color:white;margin-top:10px" v-if="errors.message">
                            {{ errors.message }}
                        </p>
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
        },
        load:0
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
            this.load=1;
            this.$store.dispatch("currentUser/login",this.user);
            
            setTimeout(()=>{
                this.load=0;
            },500)
        }
        
    }
}
</script>


<style>
    p{
        color:red
    }

    #load{
        width: 100vw;
        height: 100vh;
        position: fixed;
        background: rgba(0, 0, 0, 0.473);
        z-index: 50;
    }
</style>