<template>
  <app title="Register">
    <auth-layout>
      <b-container class="mt--8 pb-5">
        <b-row class="justify-content-center">
          <b-col lg="5" md="7">
            <b-card no-body class="bg-secondary border-0 mb-0">
              <b-card-body class="px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                  Register as Admin
                </div>

                <div v-if="Object.keys(errors).length" v-for="error in Object.keys(errors)">
                  <div class="alert alert-danger">
                    <strong>{{ errors[error] }}</strong>
                  </div>
                </div>
                <validation-observer v-slot="{handleSubmit}" ref="formValidator">
                  <b-form role="form" @submit.prevent="handleSubmit(onSubmit)">
                    <base-input alternative
                                class="mb-3"
                                name="Name"
                                :rules="{required: true}"
                                prepend-icon="ni ni-hat-3"
                                placeholder="Name"
                                v-model="model.name">
                    </base-input>

                    <base-input alternative
                                class="mb-3"
                                name="Email"
                                :rules="{required: true, email: true}"
                                prepend-icon="ni ni-email-83"
                                placeholder="Email"
                                v-model="model.email">
                    </base-input>

                    <base-input alternative
                                class="mb-3"
                                name="Password"
                                :rules="{required: true, min: 6}"
                                prepend-icon="ni ni-lock-circle-open"
                                type="password"
                                placeholder="Password"
                                v-model="model.password">
                    </base-input>

                    <div class="text-center">
                      <base-button type="primary" native-type="submit" class="my-4">Register</base-button>
                    </div>
                  </b-form>
                </validation-observer>
              </b-card-body>
            </b-card>
            <b-row class="mt-3">
              <b-col cols="6">
                <inertia-link href="/" class="text-light"><small>Forgot password?</small></inertia-link>
              </b-col>
              <b-col cols="6" class="text-right">
                <inertia-link :href="route('login.index')" class="text-light"><small>Sign In</small></inertia-link>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
      </b-container>
    </auth-layout>
  </app>
</template>

<script>
import App from "@/App";
import AuthLayout from "@/views/Pages/AuthLayout";

export default {
  components: {
    App,
    AuthLayout,
  },
  name: "Register",
  props: {
    errors: Object,
  },
  data() {
    return {
      model: {
        name: '',
        email: '',
        password: '',
      }
    };
  },
  methods: {
    onSubmit() {
      this.$inertia.post(route('register.post'), this.model)
    }
  }
}
</script>

<style scoped>

</style>
