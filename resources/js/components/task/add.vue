<template>
    <div>
          <div class="operatingForm">
            <div class="h-opfo">
            <router-link :to="{name:'task.add'}"><i class="fas fa-plus"></i>Add Task</router-link>
            <router-link :to="{name:'users.add'}" style="margin-left:10px"><i class="fas fa-user-plus"></i> Add User</router-link>
          </div>
            
            <p style="color:green">{{ message }}</p>
        
            <br>

            <div class="b-opfo">
                <div class="add-user">
                    <fieldset>
                    <legend>Add New Task</legend>
                        <label for="" class="mt0">Title</label>
                        <input type="text" name="title" v-model="form.title">
                        <div v-if="form.errors.has('title')" v-html="form.errors.get('title')" class="error" />

                        <label for="">Description</label>
                        <textarea class="descfie" v-model="form.description"></textarea>
                        <div v-if="form.errors.has('description')" v-html="form.errors.get('description')" class="error" />

                        
                        <div class="taskDate">
                        
                        <span>Start</span>
                        <input type="date" v-model="form.start_date">
                        <div v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" class="error" />
                        
                        <span>End</span>
                        <input type="date"  v-model="form.end_date">
                        <div v-if="form.errors.has('end_date')" v-html="form.errors.get('end_date')" class="error" />

                        </div>

                        <multiselect 
                        style="margin-top:10px"
                        v-model="form.userCheck" 
                        :options="users" 
                        :multiple="true"  
                        track-by="id"   
                        label="name" 
                        :taggable="true" 
                        @tag="addTag"></multiselect>

                        <br>
                        <br>

                        <input class="defaultbtn"  @click="insert" type="submit">
                    </fieldset>
                </div>
            </div>

          </div>
    </div>
</template>

<script>
export default {
    data:()=>({
        form:new Form({
            title:'',
            description:'',
            start_date:'',
            end_date:'',
            userCheck:[],
        }),
        message:'',
        error:{},
        users:[],
        
    }),
    methods:{
        //add task and assign user
        insert(){
            this.message='',
            this.error={}

            
                this.form.post("/api/tasks")
                .then(res=>{
                    axios.post("api/task/mangement",
                    {
                        "users":res.data.users,
                        "task_id":res.data.taskId
                    })
                    .then((response)=>{
                         this.message=res.data.message
                         this.form.reset();
                    }).catch(()=>{
                        
                    })
    
                }).catch((error)=>{
                    console.log(error)
                    const messages=JSON.parse(error.request.response);
                    this.error=messages.errors;
                })
            
        },

        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
        },

            

    },

    created(){
        axios.get("/api/users")
        .then((response)=>{
            this.users=response.data.users;
        })
    }
}
</script>

<style>
    .error{
        color:red;
        font-size:13px
    }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
