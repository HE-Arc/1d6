<template>
  <login-layout>
    <form @submit="formSubmit">
      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input class="input is-success" type="email" v-model="email" placeholder="Email" />
        </div>
      </div>
      <div class="field">
        <label class="label">Password</label>
        <div class="control">
          <input class="input is-success" type="password" v-model="password" placeholder="Password" />
        </div>
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
        .post("http://localhost:8000/api/login", {
          email: this.email,
          password: this.password
        })
        .then(function(response) {
          // TODO: DO NOT USE LOCALSTORAGE, it's less safe than cookies for storing tokens
          // TODO: Handle errors, and success, and querying animation
          // This would not be done in a "real" application
          localStorage.setItem("apiToken", response.data.data.api_token);
          router.push("/");
        })
        .catch(function(error) {
          alert("Login failed");
          console.log("err", error);
          currentObj.output = error;
        });
    }
  }
};
</script>