<template>
    <div>
        <div class="home-container">
            <div class="top-nav-bar">
            </div>
        </div>
        <div class="login-form" :style="errorStyle">
            <div class="top-carve" />
            <div class="account-icon">
                <img src='/images/user.png' height="75px" style="margin-top:10px;margin-right:10px" />
            </div>
            <div class="inner-login-form" :style="innerErrorStyle">
                <b-container fluid>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">اسم المستخدم :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input :state="nameState" autocomplete="off" aria-describedby="name-live-feedback"
                                v-model="user.first_name" type="text"></b-form-input>
                            <b-form-invalid-feedback id="name-live-feedback">
                                {{ errors['first_name'] == undefined ? '' : errors['first_name'][0] }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">كلمة المرورة :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" :state="passwordState"
                                aria-describedby="password-live-feedback" v-model="user.password"
                                type="password"></b-form-input>
                            <b-form-invalid-feedback id="password-live-feedback">
                                {{ errors['password'] == undefined ? '' : errors['password'][0] }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>
                    <b-row class="my-4">
                        <b-button size="lg" :disabled="isLoading" @click.prevent="login" class="inline-button">تسجيل
                            الدخول</b-button>
                    </b-row>
                    <b-row v-if="isLoading">
                        <vue-ellipse-progress class="mx-auto" :loading="true" :size="48" color="var(--background-blueish1)"
                            :thickness="'10%'" :line="'butt'" />
                    </b-row>
                </b-container>
            </div>
        </div>

        <div class="graduation-cap-container">
            <img src="/images/graduation-cap.png" height="250">

        </div>
    </div>
</template>

<script>
import { CONSTANCES } from '../utils';


export default {
    computed: {
        nameState() {
            return this.errors['first_name'] == undefined ? null : false;
        },
        passwordState() {
            return this.errors['password'] == undefined ? null : false;
        },
        errorStyle() {
            if (this.errors['first_name'] != undefined || this.errors['password'] != undefined) {
                return {
                    height: "480px"
                }
            }
        },
        innerErrorStyle() {
            if (this.errors['first_name'] != undefined || this.errors['password'] != undefined) {
                return {
                    height: "330px"
                }
            }
        }
    },
    data() {
        return {
            isLoading: false,
            user: {},
            errors: {}
        };
    },
    methods: {
        login() {
            this.isLoading = true;
            axios.post('/api/login', this.user)
                .then((response) => {
                    let data = response.data;
                    if (data.code > 200) {
                        this.errors = data.errors;
                        if (data.msg !== '')
                            this.$toast.error(data.msg);
                        this.isLoading = false;
                        return;
                    }
                    this.$toast.success('تم تسجيل الدخول');
                    let token = data.login.token;
                    let userType = data.login.user.type;
                    localStorage.setItem(CONSTANCES.TOKEN_NAME, token);
                    localStorage.setItem(CONSTANCES.USER_TYPE, userType);
                    window.axios.defaults.headers.common['authorization'] = `Bearer ${token}`;
                    this.$router.push({ name: 'home-page' });
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.error('حدث خطأ ما')
                })
        }
    }
}
</script>

<style  scoped>
.home-container {

    height: 100vh;
    background: linear-gradient(275deg, var(--background-bottom-color), var(--background-top-color));
}

.top-nav-bar {
    height: 1.4rem;
    width: 100vw;
}

.login-form {
    height: 440px;
    width: 330px;
    border-radius: 14px;
    position: absolute;
    right: 10%;
    top: 12%;
    background-color: white;
}

.top-carve {
    border-top-left-radius: 50%;
    border-top-right-radius: 50%;
    border-bottom: 14px;
    background-color: var(--background-blueish1);
    width: 100%;
    height: 90px;
    transform: rotateX(180deg);
}

.account-icon {
    border-radius: 50%;
    height: 100px;
    width: 100px;
    background: white;
    box-shadow: 6px 6px 14px #ccc;
    top: 45px;
    position: absolute;
    right: calc(30% + 10px);
}

.inner-login-form {
    height: 250px;
    width: 330px;
    position: absolute;
    bottom: 0;

}

.graduation-cap-container {
    position: absolute;
    top: 25%;
    left: 25%;
    height: 160px;
    width: 160px;

}

.graduation-cap-container img {
    transform: rotate(340deg);
}

@media screen and (max-width: 400px) {
    .graduation-cap-container {
        display: none;
    }

    .login-form {
        left: 22px;
    }
}
</style>