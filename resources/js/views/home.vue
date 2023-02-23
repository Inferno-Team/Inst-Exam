<template>
    <div></div>
</template>

<script>
import { CONSTANCES } from '../utils'
export default {

    mounted() {
        const token = localStorage.getItem(CONSTANCES.TOKEN_NAME)
        if (token == null || token == undefined)
            this.$router.push({
                name: 'login-page'
            });
    }
}
</script>

<style  scoped></style>