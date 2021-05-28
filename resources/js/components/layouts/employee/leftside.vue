<template>
    <div>
        <div class="l-nav">
            <div class="l-nav-c">
                <router-link :to="{name:'employee.edit'}" ><i class="fas fa-user"></i></router-link>
                <router-link :to="{name:'employee.index'}"><i class="fas fa-home"></i></router-link>                    
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    
}
</script>