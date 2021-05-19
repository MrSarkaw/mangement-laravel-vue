<template>
    <div>

         <router-link :to="{name:'task.index'}">back</router-link> <br>
        <br>
        <br>

        
        {{ message }}
        <input placeholder="name" v-model="form.name"> 
        <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />

        <br>
        
        <input placeholder="email" v-model="form.email" type="email"> 
        <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />

        <br>
        
        <input placeholder="password" v-model="form.password" type="password">
        <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />

        <input placeholder="password confirmation" v-model="form.password_confirmation" type="password">
        <div v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')" />
        
         <br>
        <input placeholder="imgae" @change="getNameImage" type="file"> <br>
        <select v-model="form.isAdmin">
            <option>please choose level</option>
            <option 
            v-for="(l,index) in level" 
            :key="index" 
            :value="l">{{ l==1?"admin":"employee" }}</option>    
        </select>
        <div v-if="form.errors.has('isAdmin')" v-html="form.errors.get('isAdmin')" />
        
         <br>

        <button @click="newuser()">add</button>
    </div>
</template>

<script>
export default {
    data:()=>({
        level:[],
        form: new Form({
            name:"",
            email:"",
            password:"",
            password_confirmation:"",
            path:"",
            isAdmin:""
        }),
        message:""
    }),
    methods:{
        newuser(){
            this.form.post("/api/users")
                .then((res)=>{
                    this.message=res.data.message;
                    this.form.reset();
                }).catch(()=>{
                    console.log("error")
                })
        },
        getNameImage(e){
            let file=e.target.files[0];
            let reader=new FileReader();
            reader.onloadend=(result)=>{
                this.form.path=result.target.result;
            }
            reader.readAsDataURL(file);
        }
    },
    created(){
        axios.get("/api/users/create").then((res)=>{
            this.level=res.data.level
        }).catch(()=>{

        });
    }
}
</script>