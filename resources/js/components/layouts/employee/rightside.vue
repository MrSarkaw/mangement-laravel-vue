<template>
    <div>
        <div class="r-body">
         <headerC>
             <div slot="image">
                <div v-if="currentUser.path == null" class="profile">
                    <p style="margin:0px">{{ currentUser.name.charAt(0) }}</p>
                </div>
                <div v-if="currentUser.path != null" class="profile">
                    <img :src="'/profileImg/'+currentUser.path" alt="" width="50px" height="50px" style="border-radius:50%">
                </div>
             </div>


             <div slot="currentUser">
                <router-link :to="{name:'employee.edit'}" >
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
import headerC from '../headerC.vue'
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