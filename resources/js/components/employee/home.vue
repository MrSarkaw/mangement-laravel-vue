<template>
    <div v-if=" Object.keys(currentUser).length != 0">
       
    
       <Leftside></Leftside>
        
        <rightside>
            <router-view></router-view>
        </rightside>
        
    </div>
</template>

<script>
import rightside from  '../layouts/employee/rightside';
import Leftside from  '../layouts/employee/leftside';
export default {
    components:{rightside,Leftside},
    computed:{
      currentUser:{
            get(){
                return this.$store.state.currentUser.user;
            }
        }
    },
 
     created(){
        axios.defaults.headers.common["Authorization"]="Bearer "+ localStorage.getItem("token");
         this.$store.dispatch("currentUser/getUser");

        
    },
     updated(){
        if(this.currentUser.isAdmin==1){
            this.$router.push("/");
        }
    },
}
</script>