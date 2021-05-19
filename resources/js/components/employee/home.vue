<template>
    <div>
        <headerC>
             <router-link :to="{name:'users.edit',params:{id:currentUser.id}}" slot="currentUser">
                 <h2>{{ currentUser.email }}</h2>
              </router-link> 
        </headerC>
        <br>
    
        <!-- <Leftside></Leftside> -->
        
        <rightside>
            <router-view></router-view>
        </rightside>
        
    </div>
</template>

<script>
import rightside from  '../layouts/employee/rightside';
import headerC from '../layouts/headerC.vue'
export default {
    components:{rightside,headerC},
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
    }
}
</script>