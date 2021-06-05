<template>
  <app title="Customer Registration">
    <auth-layout>
      <b-container class="mt--8 pb-5">
        <b-row class="justify-content-center">
          <b-col lg="5" md="7">
            <b-card no-body class="bg-secondary border-0 mb-0">
              <b-card-body class="px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                  Register as Customer
                </div>

                <div v-if="redirectRoute">
                  <div class="alert alert-success">
                    <strong>Customer Registered. Please visit this link :
                      <a target="_blank" :href="redirectRoute">{{ redirectRoute }}</a>
                      to login.</strong>
                  </div>
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

                    <base-input alternative
                                class="mb-3"
                                name="Subdomain"
                                :rules="{required: true}"
                                prepend-icon="ni ni-hat-3"
                                placeholder="Type abc if you want to have abc.my-domain.com"
                                v-model="model.subdomain">
                    </base-input>

                    <div class="text-center">
                      <base-button type="primary" native-type="submit" class="my-4">Register</base-button>
                    </div>
                  </b-form>
                </validation-observer>
              </b-card-body>
            </b-card>
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
      redirectRoute: null,
      model: {
        name: '',
        email: '',
        password: '',
        subdomain: '',
      }
    };
  },
  methods: {
    onSubmit() {
      this.$inertia.post(route('customers.register.post'), this.model, {
        onSuccess: () => {
          this.redirectRoute = route('subdomain.login.index', this.model.subdomain)
        },
      })
    }
  }
}
</script>

<style scoped>

</style>
