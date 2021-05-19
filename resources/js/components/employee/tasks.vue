<template>
    <div>   
            <div>

            </div>
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
    }
}
</script>