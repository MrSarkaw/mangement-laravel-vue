<template>
    <div> 
            <p>not started</p>

            <div style="border:1px solid black;" v-for="(item,index) in notStart" :key="index">
                {{ item.task.title }}
                <br>
                {{ item.task.description }}
            </div>
            <hr>
            <p>inProgress</p>

            <div style="border:1px solid black;" v-for="(item,index) in inProgress" :key="index+100">
                {{ item.task.title }}
                <br>
                {{ item.task.description }}
            </div>
            <hr>
            <p>done</p>

            <div style="border:1px solid black;" v-for="(item,index) in done" :key="index+200">
                {{ item.task.title }}
                <br>
                {{ item.task.description }}
            </div>
    </div>
</template>
<script>
export default {
    data:()=>({
        notStart:[],
        inProgress:[],
        done:[],        
    }),
    created(){
        axios.get("/api/employee/task").then((response)=>{
            response.data.tasks.forEach((element)=>{
                if(element.status==0){
                    this.notStart.unshift(element);
                }else if(element.status==1){
                    this.inProgress.unshift(element)
                }else{
                    this.done.unshift(element)
                }
            })
        })
    },
 
    mounted(){
      
        Echo.channel("task").listen("task",(e)=>{            
            if(this.$store.state.currentUser.user.id== e.task.user_id){
                this.notStart.unshift(e.task)
            }
        });
        
        Echo.channel("delete-task").listen("deleteTask",(e)=>{ 
            if(this.$store.state.currentUser.user.id== e.task.user_id){
                         

                let newdata=  this.notStart.filter((d)=>{
                        return d.task_id != e.task.task_id
                    })
                   this.notStart=newdata;

                 newdata=  this.inProgress.filter((d)=>{
                         return d.task_id != e.task.task_id
                    })
                    this.inProgress=newdata;
                    
                 newdata=  this.done.filter((d)=>{
                         return d.task_id != e.task.task_id
                    })
                    this.done=newdata;
            }
        });
        
    }
}
</script>