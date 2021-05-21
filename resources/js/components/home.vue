<template>
    <div>
        <headerC>
             <router-link :to="{name:'users.edit',params:{id:currentUser.id}}" slot="currentUser">
                 <h2>{{ currentUser.email }}</h2>
              </router-link> 
        </headerC>
        <br>
    
        <Leftside></Leftside>
        
        <rightside>
            <router-view></router-view>
        </rightside>
        
    </div>
</template>

<script>
import Leftside from './layouts/leftside.vue';
import rightside from './layouts/rightside.vue';
import headerC from './layouts/headerC.vue'
export default {
    components:{Leftside,rightside,headerC},
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