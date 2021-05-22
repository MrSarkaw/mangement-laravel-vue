<template>
    <div> 
            <!-- <p>todo</p>

          
            <hr> -->
          <!--   <p>inProgress</p>

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
            </div> -->
        
        <div class="container">
            <div>
            <p>todo</p>      
                <div id="todo">
                    <div  
                    class="item"
                        v-for="(item,index) in notStart" 
                        :key="index"
                        :id="index"
                        @mouseup="pickUp(index,item.id)"
                        @mousedown="drag(index)"
                        @mousemove="draging(index)"
                        >
                        {{ item.task.title }}
                            <br>
                        {{ item.task.description }}
                    </div>
        
                </div>
            </div>
             <div>
             <p>inprogress</p>   
                <div id="inprogress">
                    <div  
                        class="item"
                        v-for="(item,index) in inProgress" 
                        :key="index+100"
                        :id="index+100"
                        @mouseup="pickUp(index+100,item.id)"
                        @mousedown="drag(index+100)"
                        @mousemove="draging(index+100)"
                        >
                        {{ item.task.title }}
                            <br>
                        {{ item.task.description }}
                    </div>
                </div>
             </div>
             <div>
                <p>done</p>   
                <div id="done">
                    <div  
                        class="item"
                        v-for="(item,index) in done" 
                        :key="index+200"
                        :id="index+200"
                        @mouseup="pickUp(index+200,item.id)"
                        @mousedown="drag(index+200)"
                        @mousemove="draging(index+200)"
                        >
                        {{ item.task.title }}
                            <br>
                        {{ item.task.description }}
                    </div>
                </div>
             </div>
        </div>
        

    </div>
</template>
<script>


export default {
    data:()=>({
        notStart:[],
        inProgress:[],
        done:[],        
        pick:false,

    }),
   
   methods:{
       drag(index){
           this.pick=true;
           let task=document.getElementById(index);
           task.style.width="35%";
           task.style.position="absolute";
                
       },
       draging(index){
           if(this.pick){
               let task=document.getElementById(index);
               task.style.top=event.clientY - 30 + "px";
               task.style.left=event.clientX - 260 + "px";
           }
       },
       pickUp(index,taskid){
             let task=document.getElementById(index);
                if(task.style.left < "400"){
                    let newData=this.notStart.splice(index,1);
                    if(newData[0]){
                        this.updateState(taskid,0);
                        this.notStart.push(newData[0]);
                    }else{
                        newData=this.inProgress.splice(index-100,1);
                        if(newData[0]){
                             this.updateState(taskid,0);
                            this.notStart.push(newData[0]);
                        }else{
                            newData=this.done.splice(index-200,1);
                            if(newData[0]){
                                 this.updateState(taskid,0);
                                this.notStart.push(newData[0]);
                            }
                        } 
                    }   
                }

                if(task.style.left > "400" && task.style.left < "700"){
                    let newData=this.notStart.splice(index,1);
                    if(newData[0]){
                         this.updateState(taskid,1);
                        this.inProgress.push(newData[0]);
                    }else{
                        newData=this.inProgress.splice(index-100,1);
                        if(newData[0]){
                            this.updateState(taskid,1);
                            this.inProgress.push(newData[0]);
                        }else{
                            newData=this.done.splice(index-200,1);
                            if(newData[0]){
                                this.updateState(taskid,1);
                                this.inProgress.push(newData[0]);
                            }
                        }
                    }
                }

                if(task.style.left > "700"){
                    let newData=this.notStart.splice(index,1);
                    if(newData[0]){
                        this.updateState(taskid,2);
                        this.done.push(newData[0]);
                    }else{
                        newData=this.inProgress.splice(index-100,1);
                        if(newData[0]){
                            this.updateState(taskid,2);
                            this.done.push(newData[0]);
                        }else{
                            newData=this.done.splice(index-200,1);
                            if(newData[0]){
                                this.updateState(taskid,2);
                                this.done.push(newData[0]);
                            }
                        }
                    }
                }
            
             task.removeAttribute("style");
           this.pick=false;
       },

       updateState(id,status){
           axios.put("/api/employee/task/"+id,{
               "status":status
           })
       }
   },
   
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

<style scoped>
    .container{
        display: grid;
        grid-gap: 10px;
        grid-template-columns: 440px 440px 440px
    }
    .container > div{
        background: rgb(66, 56, 56);
        padding: 10px;
        border-radius: 30px;
        color:white
        
    }
    .item{
        border:1px solid black; text-align:center;padding:10px;width:500px;background:yellow;
        width: 400px;
        color:rgb(66, 56, 56);
        border-radius: 40px;
        
    }
</style>