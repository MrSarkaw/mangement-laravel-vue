<template>
    <div>
        <headerC>
             <router-link :to="{name:'employee.edit'}" slot="currentUser">
                 <h2>
                     <img :src="'/profileImg/'+currentUser.path" alt="" width="80" height="80" style="border-radius:50%">
                     {{ currentUser.email }} 
                    </h2>
              </router-link> 
        </headerC>
        <br>
    
        <!-- <Leftside></Leftside> -->
        
        <rightside >
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

        
    },
     updated(){
        if(this.currentUser.isAdmin==1){
            this.$router.push("/");
        }
    },
}
</script>