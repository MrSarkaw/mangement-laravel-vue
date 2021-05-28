<template>
    <div>
        <div class="operatingForm">
            <div class="h-opfo">
            <router-link :to="{name:'task.add'}"><i class="fas fa-plus"></i>Add Task</router-link>
            <router-link :to="{name:'users.add'}" style="margin-left:10px"><i class="fas fa-user-plus"></i> Add User</router-link>
          </div>
            <div style="margin-top:10px" v-if="form.title == ''">
              <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>              
            </div>

            <div class="b-opfo" v-else>
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

                        <input class="defaultbtn"  @click="update" type="submit" value="update">
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
        //update task and assign user
        update(){
            this.error={}

                this.form.put("/api/tasks/"+this.$route.params.id)
                .then(res=>{
                  
                  axios.put("/api/task/mangement/"+this.$route.params.id,
                    {
                        "users":this.form.userCheck,
                    })
                    .then((response)=>{
                          Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1000
                            })
                         this.message=res.data.message
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
          axios.get("/api/tasks/"+this.$route.params.id).then((response)=>{
            this.form.fill(
                {
                    title:response.data.task.title,
                    description:response.data.task.description,
                    start_date:response.data.task.start_date,
                    end_date:response.data.task.end_date,
                    userCheck:response.data.task.users
                }
            );
        })

        axios.get("/api/users")
        .then((response)=>{
            this.users=response.data.users;
        })

      
    }
}
</script>