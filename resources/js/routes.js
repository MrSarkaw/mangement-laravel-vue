import login from './components/login.vue';

import home from './components/home.vue';
    import task from './components/task/index.vue';
    import addTask from './components/task/add.vue';
    import editTask from './components/task/edit.vue';

import userIndex from './components/user/index.vue';
    import userAdd from './components/user/add.vue';
    import userEdit from './components/user/edit.vue';

    // employee
import empHome from './components/employee/home.vue';
    import employeesTask from './components/employee/tasks.vue'
    import employeesEdit from './components/employee/edit.vue'


export const routes = [
    {
        path: "/login", component: login,
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("token");
            if (!token) {
                next();
            } else {
                next("/");
            }
        }

    },


    {
        path: "/", component: home,
        children:[
            // task
            {path:"/",component:task,name:"task.index"},
            {path:"/addTask",component:addTask,name:"task.add"},
            {path:"/editTask/:id",component:editTask,name:"task.edit"},
            // user
            {path:"/users",component:userIndex,name:"users.index"},
            {path:"/users/add",component:userAdd,name:"users.add"},
            {path:"/users/edit/:id",component:userEdit,name:"users.edit"}

        ],
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("token");
            if (token) {
                next();
            } else {
                next("/login");
            }
        }
    },

    // employee
    {
        path: "/employee/", component: empHome,
        children:[
            {path:"/",component:employeesTask,name:"employee.index"},
            {path:"edit",component:employeesEdit,name:"employee.edit"},
        ],
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("token");
            if (token) {
                next();
            } else {
                next("/login");
            }
        }
    },
];