<template>
  <login-layout>
    <form @submit="formSubmit">
      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input class="input is-success" type="text" v-model="username" placeholder="Username" />
        </div>
        <p class="help is-danger" v-for="error in errors.name">{{error}}</p>
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
          />
        </div>
        <p class="help is-danger" v-for="error in errors.email">{{error}}</p>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <div class="control">
          <input class="input is-success" type="password" v-model="password" placeholder="Password" />
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
        <p class="help is-danger" v-for="error in errors.password">{{error}}</p>
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
export default {
  data() {
    return {
      errors: {},
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
          console.log(response);
          // TODO: DO NOT USE LOCALSTORAGE, it's less safe than cookies for storing tokens
          // TODO: Handle errors, and success, and querying animation
          // This would not be done in a "real" application
          localStorage.setItem("apiToken", response.data.data.api_token);
          router.replace("/");
        })
        .catch(function(error) {
          let errors = error.response.data.errors;
          currentObj.errors = errors;
          currentObj.output = error;
        });
    }
  }
};
</script>