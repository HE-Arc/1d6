<template>
  <login-layout>
    <form @submit="formSubmit">
      <div class="field">
        <label class="label">Username</label>
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
export default {
  data() {
    return {
      errors: {email: [], password: []},
      email: "",
      password: ""
    };
  },
  methods: {
    formSubmit(e) {
      let router = this.$router;
      e.preventDefault();
      let currentObj = this;
      this.axios
        .post(this.axios.defaults.baseURL + "/login", {
          email: this.email,
          password: this.password
        })
        .then(function(response) {
          // TODO: DO NOT USE LOCALSTORAGE, it's less safe than cookies for storing tokens
          // TODO: Handle errors, and success, and querying animation
          // This would not be done in a "real" application
          localStorage.setItem("apiToken", response.data.data.api_token);
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