<template>
    <div>


        <div class="operatingForm">
          <div class="h-opfo">
            <router-link :to="{name:'task.add'}"><i class="fas fa-plus"></i>Add Task</router-link>
            <router-link :to="{name:'users.add'}"><i class="fas fa-user-plus"></i> Add User</router-link>
          </div>
          <div class="b-opfo">
            <!-- full topic block -->
            <div class="jobtopic"  v-for="(task,index) in tasks" :key="index" >
              <div class="l-joto">
                <h2>{{ task.title }}</h2>
                <p>{{ task.description }}</p>
                <div class="joto-time" style="width:100%">
                  <i class="far fa-clock"></i>
                  <span>{{ task.start_date }}/{{ task.end_date }}</span>
                </div>
              </div>
              <div class="r-joto">
                <div class="t-r-joto">
                  <a href="#"><i class="fas fa-users"></i> {{ task.users.length }} Users</a>
                </div>
                <div class="b-r-joto">
                  <router-link :to="{name:'task.edit',params:{id:task.id}}"><i class="fas fa-pencil-alt"></i></router-link>
                  <a style="cursor: pointer;" @click="deletetask(task.id,index)"><i class="far fa-trash-alt"></i></a>
                </div>
              </div>
            </div>

            
         
          </div>
        </div>


        <!-- 
          <br>

        <divstyle="border:1px solid black;padding:10px">
            <h3></h3>
            <h4></h4>
            <div v-for="user in task.users" :key="user.id" style="border:1px solid black;padding:10px">
                {{ user.name }}
            </div>


            <div>
                <p></p>
                <button delete</button> 
            </div>
        </div>
         -->
    </div>
</template>

<script>
export default {
    data:()=>({
        tasks:[]
    }),
    methods:{
        deletetask(id,index){
           axios.delete("/api/tasks/"+id+"").then(()=>{
                this.tasks.splice(index,1);
           }).catch((err)=>{
               console.log(err);
           })
        }
    },
    created(){
        axios.get("api/tasks").then((response)=>{
            response.data.task.forEach(element => {
                   this.tasks.unshift(element);
            });
        }).catch(()=>{
            console.log("something wrong");
        })
    }
    
}
</script>