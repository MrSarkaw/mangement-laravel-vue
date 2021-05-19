<template>
    <div>

        <router-link :to="{name:'users.add'}">user + </router-link>
          <br>

        <div v-for="(task,index) in tasks" :key="index" style="border:1px solid black;padding:10px">
            <h3>{{ task.title }}</h3>
            <h4>{{ task.description }}</h4>
            <div v-for="user in task.users" :key="user.id" style="border:1px solid black;padding:10px">
                {{ user.name }}
            </div>


            <div>
                <p>{{ task.start_date }}/{{ task.end_date }}</p>
                <button @click="deletetask(task.id,index)">delete</button> <router-link :to="{name:'task.edit',params:{id:task.id}}">edit</router-link>
            </div>
        </div>
        <router-link :to="{name:'task.add'}">task + </router-link>
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