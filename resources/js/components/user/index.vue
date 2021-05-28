<template>
    <div>
            {{ message }}
        <div style="border:1px solid black;padding:10px" v-for="(user,index) in users" :key="index">
            <img v-if="user.path != null" :src="'profileImg/'+user.path" width="80" style="border-radius:50%" height="80" alt="">
            <div v-if="user.path == null" class="profile">
                <p>{{ user.name.charAt(0) }}</p>
            </div>
            <p>{{ user.name }}</p>
            <p>{{ user.email }}</p>
            <p>{{ user.isAdmin == 1 ? "admin":"employee" }}</p>
            <router-link :to="{name:'users.edit',params:{id:user.id}}">edit</router-link>
            <button @click="deleteUser(user.id,index)">delete</button>
        </div>
        
    </div>
</template>

<script>
export default {
    data:()=>({
        message:"",
        users:[],
    }),
    methods:{
        deleteUser(id,index){
            this.message='';
            axios.delete("/api/users/"+id)
                .then((res)=>{
                    this.users.splice(index,1);
                    this.message=res.data.message;
                }).catch((errr)=>{
                    console.log(errr);
                })
                
        }
    },
    created(){
        axios.get("/api/users")
        .then((response)=>{
            response.data.users.forEach(element => {
                this.users.unshift(element);
            });
        }).catch(()=>{
            console.log("something wrong!");
        })
    }
}
</script>


<style scoped>
    .profile{
        border-radius:50%;background:rgb(20, 86, 124);
        width: 80px !important; height: 80px !important;
        display: flex; justify-content: center;align-items: center;
        font-size: 50px; color:white
        
    }
</style>