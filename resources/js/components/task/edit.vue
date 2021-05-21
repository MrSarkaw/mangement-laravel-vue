<template>
    <div>
          <router-link :to="{name:'task.index'}">back</router-link> <br>
        <br>
        <br>

         {{ message }}
        <br>
      
       <input type="text" placeholder="title" v-model="form.title">
         <div v-if="form.errors.has('title')" v-html="form.errors.get('title')" />
    
       <br>
    
       <input type="text" placeholder="description" v-model="form.description">
         <div v-if="form.errors.has('description')" v-html="form.errors.get('description')" />
       
       <br>
    
       start date <input type="date" name="" id="" v-model="form.start_date">
         <div v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" />
       
       <br>
    
       end date <input type="date" name="" id="" v-model="form.end_date">
         <div v-if="form.errors.has('end_date')" v-html="form.errors.get('end_date')" />

       <br>
       <br>
       <br>

          <multiselect v-model="form.userCheck" :options="users" :multiple="true"  track-by="id"   label="name" :taggable="true" @tag="addTag"></multiselect>


        <button @click="update">update</button>

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
            this.message='',
            this.error={}

                this.form.put("/api/tasks/"+this.$route.params.id)
                .then(res=>{
                  
                  axios.put("/api/task/mangement/"+this.$route.params.id,
                    {
                        "users":this.form.userCheck,
                    })
                    .then((response)=>{
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