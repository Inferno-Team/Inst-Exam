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
        } else if (userType == TYPES.MODERATOR) {
            this.$router.push({
                name: 'moderator-page'
            });
        } else if (userType == TYPES.STUDENT) {
            this.$router.push({
                name: 'student-page'
            });
        } else {
            this.$toast.error(userType);
        }
    },

}
</script>

<style  scoped></style>
