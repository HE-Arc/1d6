<template>
  <login-layout>
    <form @submit="formSubmit">
      <div class="field">
        <label class="label">Email</label>
        <div class="control">
          <input
            class="input is-success"
            type="email"
            v-model="email"
            placeholder="Email"
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
        <p class="help is-danger" v-for="error in errors.password" v-bind:key="error">{{error}}</p>
      </div>

      <div class="field is-grouped is-grouped-right">
        <p class="control">
          <input type="submit" class="button is-link" value="Login" />
        </p>
      </div>
    </form>
  </login-layout>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      errors: { email: [], password: [] },
      email: "",
      password: ""
    };
  },
  methods: {
    login(id, username, token) {
      // TODO: DO NOT USE LOCALSTORAGE, it's less safe than cookies for storing tokens
      // TODO: Handle errors, and success, and querying animation
      // This would not be done in a "real" application
      localStorage.setItem("id", id);
      localStorage.setItem("username", username);
      localStorage.setItem("apiToken", token);
      axios.defaults.headers.common = {
        Authorization: `Bearer ${localStorage.getItem("apiToken")}`
      };
    },
    formSubmit(e) {
      let router = this.$router;
      e.preventDefault();

      this.axios
        .post("/login", {
          email: this.email,
          password: this.password
        })
        .then(response => {
          this.login(
            response.data.data.id,
            response.data.data.name,
            response.data.data.api_token
          );

          router.replace("/");
        })
        .catch(error => {
          let errors = error.response.data.errors;
          this.errors = errors;
          // focus on the first faulty field
          for (let type in errors) {
            this.$refs[type].focus();
            break;
          }
          this.output = error;
        });
    }
  }
};
</script>