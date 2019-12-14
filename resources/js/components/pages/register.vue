<template>
  <login-layout>
    <form @submit="formSubmit">
      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input
            class="input is-success"
            type="text"
            v-model="username"
            placeholder="Username"
            ref="name"
          />
        </div>
        <p class="help is-danger" v-for="error in errors.name" v-bind:key="error">{{error}}</p>
      </div>

      <div class="field">
        <label class="label">Email</label>
        <div class="control">
          <input
            class="input is-success"
            type="email"
            v-model="email"
            placeholder="email@example.com"
            value
            ref="email"
          />
        </div>
        <p class="help is-danger" v-for="error in errors.email" v-bind:key="error">{{error}}</p>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <div class="control">
          <input
            class="input is-success"
            type="password"
            v-model="password"
            placeholder="Password"
            ref="password"
          />
        </div>
      </div>

      <div class="field">
        <label class="label">Confirm you password</label>
        <div class="control">
          <input
            class="input is-success"
            type="password"
            v-model="password_confirm"
            placeholder="Password"
          />
        </div>
        <p class="help is-danger" v-for="error in errors.password" v-bind:key="error">{{error}}</p>
      </div>

      <div class="field is-grouped is-grouped-right">
        <p class="control">
          <button class="button is-link">Sign up</button>
        </p>
      </div>
    </form>
  </login-layout>
</template>

<script>
import login from "./login";

export default {
  data() {
    return {
      errors: { name: [], password: [], email: [] },
      username: "",
      email: "",
      password: "",
      password_confirm: ""
    };
  },
  methods: {
    formSubmit(e) {
      e.preventDefault();
      let currentObj = this;
      let router = this.$router;
      this.axios
        .post(this.axios.defaults.baseURL + "/register", {
          email: this.email,
          name: this.username,
          password: this.password,
          password_confirmation: this.password_confirm
        })
        .then(function(response) {
          currentObj.login.methods.login(
            response.data.data.id,
            response.data.data.name,
            response.data.data.api_token
          );

          router.replace("/");
        })
        .catch(function(error) {
          let errors = error.response.data.errors;
          currentObj.errors = errors;
          // focus on the first faulty field
          for (let type in errors) {
            currentObj.$refs[type].focus();
            break;
          }
          currentObj.output = error;
        });
    }
  }
};
</script>