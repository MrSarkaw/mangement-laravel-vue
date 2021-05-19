import axios from "axios";
import {app} from "../../app"
const state = {
    user: {},
    errors:{},
};

const getters = {};

const actions = {

    async getUser( { commit } ){
        try{
            const crUser= await  axios.get("/api/currentUser");
            commit("setUser",crUser.data);
        }catch{
            localStorage.removeItem("token")
            app.$router.push("/login");
        }
    },

    login({state},user){
        state.errors={};
        axios.post("api/login",{

            email:user.email,
            password:user.password
            
        }).then((response)=>{

            if(response.data.access_token){
                localStorage.setItem("token",response.data.access_token);
                
                response.data.user.isAdmin==1?app.$router.push("/"):app.$router.push("/employee");
            }else{
                state.errors={"message":"Invalid login cridential"}

                console.log(state.errors)
            }
            
        }).catch (error => {
                const errorMessage = JSON.parse(error.request.response)
                state.errors=errorMessage.errors
       })

       
           
    }


};

const mutations = {
    setUser(state,data){
        state.user=data.user;
    },
};

export default {
    namespaced:true,
    state,
    getters,
    actions,
    mutations
};