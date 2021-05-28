<template>
    <div v-if="Object.keys(currentUser).length != 0">
    
        <Leftside></Leftside>
        
        <rightside>
            <router-view></router-view>
        </rightside>
        
    </div>
</template>

<script>
import Leftside from './layouts/leftside.vue';
import rightside from './layouts/rightside.vue';
export default {
   
    components:{Leftside,rightside},
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
        if(this.currentUser.isAdmin==0){
            this.$router.push("/employee");
        }
    },
}
</script>