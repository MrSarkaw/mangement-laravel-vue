<template>
    <div>
        <div class="r-body">
       
         <headerC>
             <div slot="currentUser">
                <router-link :to="{name:'users.edit',params:{id:currentUser.id}}" >
                    <h3>{{ currentUser.email }}</h3> <br>
                </router-link> 
                 <span>{{ currentUser.isAdmin==1?"manger":"employee" }}</span>
             </div>
        </headerC>

        <router-view></router-view>
      </div>
    </div>
</template>
<script>
import headerC from './headerC.vue'
export default {
    props:["user"],
      computed:{
      currentUser:{
            get(){
                return this.$store.state.currentUser.user;
            }
        }
    },
    components:{
        headerC
    }
}
</script>