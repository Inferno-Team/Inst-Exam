<template>
    <div></div>
</template>

<script>
import { CONSTANCES, TYPES } from '../utils'
export default {

    mounted() {
        const token = localStorage.getItem(CONSTANCES.TOKEN_NAME)
        if (token == null || token == undefined) {
            this.$router.push({
                name: 'login-page'
            });
            return;
        }
        let userType = localStorage.getItem(CONSTANCES.USER_TYPE);
        if (userType == TYPES.ADMIN) {
            this.$router.push({
                name: 'admin-page'
            });
        } else {
            this.$toast.error(userType);
        }
    },

}
</script>

<style  scoped></style>
