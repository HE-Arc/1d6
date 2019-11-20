<template>
  <login-layout>
    <div class="field">
      <label class="label">Username</label>
      <div class="control">
        <input
          class="input is-success"
          type="text"
          placeholder="Username"
        >
      </div>
    </div>

    <div class="field">
      <label class="label">Email</label>
      <div class="control">
        <input
          class="input is-success"
          type="email"
          placeholder="email@example.com"
          value=""
        >
      </div>
    </div>

    <div class="field">
      <label class="label">Password</label>
      <div class="control">
        <input
          class="input is-success"
          type="password"
          placeholder="Password"
        >
      </div>
    </div>

    <div class="field">
      <label class="label">Confirm you password</label>
      <div class="control">
        <input
          class="input is-success"
          type="password"
          placeholder="Password"
        >
      </div>
    </div>

    <div class="field is-grouped is-grouped-right">
      <p class="control">
        <button class="button is-link">
          Sign up
        </button>
      </p>
    </div>
  </login-layout>
</template>

<script>
/*
this.$auth.loginWith('local', {
  data: {
    username: 'your_username',
    password: 'your_password'
  }
})
*/
export default {
  layout: 'login'
};
</script>