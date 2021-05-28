<template>
    <div style="width:100%"> 
        
        
        <div class="container">
            <div id="todoDiv">
              <p style="background:#4791b3;padding:5px;color:white;border-radius:10px">todo</p>      
                <div id="todo">
                    <div  
                    class="item todoitem"
                        v-for="(item,index) in notStart" 
                        :key="index"
                        :id="index"
                        @mouseup="pickUp(index,item.id)"
                        @mousedown="drag(index)"
                        @mousemove="draging(index)"
                        >
                        <div class="title">
                             {{ item.task.title }}
                        </div>
                        <div class="desc">
                            {{ item.task.description }}
                            <span style="display:block;margin-top:5px">
                                <i class="far fa-clock"></i>
                                {{ item.task.start_date }}/{{ item.task.end_date }}    
                            </span>
                        </div>
                           
                    </div>
        
                </div>
            </div>
             <div id="inproDiv">
             <p style="background:#b3ac47;padding:5px;color:white;border-radius:10px">inprogress</p>   
                <div id="inprogress">
                    <div  
                        class="item itemprogress"
                        v-for="(item,index) in inProgress" 
                        :key="index+100"
                        :id="index+100"
                        @mouseup="pickUp(index+100,item.id)"
                        @mousedown="drag(index+100)"
                        @mousemove="draging(index+100)"
                        >
                       <div class="title">
                             {{ item.task.title }}
                        </div>
                        <div class="desc">
                            {{ item.task.description }}
                            <span style="display:block;margin-top:5px">
                                <i class="far fa-clock"></i>
                                {{ item.task.start_date }}/{{ item.task.end_date }}    
                            </span>
                        </div>
                    </div>
                </div>
             </div>
             <div id="doneDiv">
                <p style="background:#47b350;padding:5px;color:white;border-radius:10px">done</p>   
                <div id="done">
                    <div  
                        class="item itemdone"
                        v-for="(item,index) in done" 
                        :key="index+200"
                        :id="index+200"
                        @mouseup="pickUp(index+200,item.id)"
                        @mousedown="drag(index+200)"
                        @mousemove="draging(index+200)"
                        >
                       <div class="title">
                             {{ item.task.title }}
                        </div>
                        <div class="desc">
                            {{ item.task.description }}
                            <span style="display:block;margin-top:5px">
                                <i class="far fa-clock"></i>
                                {{ item.task.start_date }}/{{ item.task.end_date }}    
                            </span>
                        </div>
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
           task.style.width="27%";
           task.style.position="absolute";
                
       },
       draging(index){
           let todo=document.getElementById("todoDiv");
           let inprogress=document.getElementById("inproDiv");
           let done=document.getElementById("doneDiv");

            this.deleteStyle();

           if(this.pick){
               let task=document.getElementById(index);
               task.style.top=event.clientY - 30 + "px";
               task.style.left=event.clientX - 240 + "px";

                console.log(event.clientX-240)
                if(( event.clientX - 240 ) < 400){
                    todo.style.boxShadow="0px 0px 10px rgba(0, 0, 0, 0.486)";
                    todo.style.borderRadius="20px";
                }else if(( event.clientX - 240 ) >= 400 && ( event.clientX - 240 ) < 850){
                    inprogress.style.boxShadow="0px 0px 10px rgba(0, 0, 0, 0.486)";
                    inprogress.style.borderRadius="20px";
                }else if(( event.clientX - 240 ) > 850){
                    done.style.boxShadow="0px 0px 10px rgba(0, 0, 0, 0.486)";
                    done.style.borderRadius="20px";
                }
           }
       },
       pickUp(index,taskid){
            this.deleteStyle();

             let task=document.getElementById(index);
            if(task.style.left){
                
                if(( event.clientX - 240 ) < "400"){
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

                if(( event.clientX - 240 ) >= "400" && ( event.clientX - 240 ) < "850"){
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

                if(( event.clientX - 240 ) > "850"){
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
            }


            
            task.removeAttribute("style");
           this.pick=false;
       },
        deleteStyle(){
            let todo=document.getElementById("todoDiv");
           let inprogress=document.getElementById("inproDiv");
           let done=document.getElementById("doneDiv");
            
            todo.removeAttribute("style");
            inprogress.removeAttribute("style");
            done.removeAttribute("style");
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
        grid-gap: 20px;
        grid-template-columns: 1fr 1fr 1fr;
        margin-top: 10px;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
    }
    #todo{
        border-top: 4px solid #4791b3;
        padding: 10px;
        color:white 
    }
    #inprogress{
        border-top: 4px solid #b3ac47;
        padding: 10px;
        color:white 
    }
    #done{
        border-top: 4px solid #47b350;
        padding: 10px;
        color:white 
    }
    .todoitem{
        border-left:2px solid #4791b3;
        border-right:2px solid #4791b3;
    }

    .itemprogress{
        border-left:2px solid #b3ac47;
        border-right:2px solid #b3ac47;
    }
    .itemdone{
        border-left:2px solid #47b350;
        border-right:2px solid #47b350;
    }
    .item{
        text-align:center;padding:10px;
        width: 350px;
        color:rgb(66, 56, 56);
        margin-top: 10px;
        margin-left: auto; margin-right: auto;
        cursor: pointer;
    }

    .title{
        text-align: left;
        font-size: 19px;
    }
    .desc{
        text-align: left;
        font-size: 15px;
    }

    
</style>