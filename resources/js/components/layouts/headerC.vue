<template>
    <div>

       <div id="load" v-if="load">
                <div class="lds-dual-ring"></div>
       </div>

        <div class="head-panel">
          <div class="l-hepan">
            <a href="#">
              <div class="l-hepan-img">
                 <slot name="image"></slot>
              </div>
              <div class="r-hepan-img">
                <slot name="currentUser"></slot>
              </div>
            </a>
          </div>
          <div class="r-hepan">
            <a style="cursor: pointer;" @click="logout()"><i class="fas fa-sign-out-alt"></i>logout</a>
          </div>
        </div> 
    </div>
</template>

<script>
export default {
     data:()=>({
       load:0
     }),
       methods:{
        logout(){
          this.load=1;
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