<template>
  <default-layout>
    <h1>Create a new poll</h1>
    <label class="label">Import settings from groups</label>

    <div class="field has-addons">
      <div class="control is-expanded">
        <div class="select is-fullwidth">
          <select name="groups">
            <option>Mid'Arc</option>
            <option>Ciném</option>
            <option>Games</option>
          </select>
        </div>
      </div>
      <div class="control">
        <button type="submit" class="button is-primary">Import settings</button>
      </div>
    </div>
    <hr />

    <div class="columns">
      <div class="column is-half">
        <select-list icon="fa-user-plus" placeholder="Member name">Members</select-list>
      </div>
      <div class="column is-half">
        <select-list icon="fa-plus" placeholder="Item name">Default items</select-list>
      </div>
    </div>

    <div class="control">
      <button type="submit" class="button is-primary">Create poll</button>
    </div>
  </default-layout>
</template>
<script>
import selectList from "../groups/select-list";

export default {
  components: {
    selectList
  },
  middleware: "auth"
};
</script>