<template>
    <div>
           <slot name="currentUser"></slot>
         <button @click="logout()">logout</button>
    </div>
</template>

<script>
export default {
       methods:{
        logout(){
            axios.post("/api/logout").then(()=>{
                localStorage.removeItem("token")
                this.$router.push("/login");
            }).catch(()=>{
                localStorage.removeItem("token")
                console.log("error")
            })
        }
    },
}
</script>