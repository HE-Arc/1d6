<template>
  <default-layout>
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Create a new group</p>
          <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <form>
            <label class="label">Group name</label>
            <input type="text" placeholder="Where are we gonna eat" class="input input-group-name"/>
            <div class="columns">
              <div class="column is-half">
                <label class="label">Members</label>
                <div class="list is-hoverable group-item-list">
                  <span class="list-item">Mcdo <a class="delete-item"><i class="fa fa-trash"></i></a></span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Paprika</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Bleu café</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Coop pronto</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Piadine</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Cafète de la he-arc</span>
                </div>
                <div class="field has-addons">
                  <div class="control is-expanded">
                    <input type="text" placeholder="Member username" class="input"/>
                  </div>
                  <div class="control">
                    <button type="submit" class="button is-primary"><i class="fa fa-user-plus"></i></button>
                  </div>
                </div>
              </div>
              <div class="column is-half">
                <label class="label">Default items</label>
                <div class="list is-hoverable group-item-list">
                  <span class="list-item">Mcdo <a class="delete-item"><i class="fa fa-trash"></i></a></span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Paprika</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Bleu café</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Coop pronto</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Piadine</span>
                  <span class="list-item"><a class="delete-item"><i class="fa fa-trash"></i></a>Cafète de la he-arc</span>
                </div>
                <div class="field has-addons">
                  <div class="control is-expanded">
                    <input type="text" placeholder="Item name" class="input"/>
                  </div>
                  <div class="control">
                    <button type="submit" class="button is-primary"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">Create group</button>
          <button class="button">Cancel</button>
        </footer>
      </div>
    </div>
    <h1>Your groups</h1>
    <div class="columns is-multiline is-1-mobile is-0-tablet is-3-desktop is-8-widescreen container-container">
      <div class="column container-border poll-card is-one-quarter">
        <span class="header">Mangeur de lel</span>
        <b>5</b> peoples<br>
        <span class="poll-card-action"><a href="#"><i class="fa fa-edit"></i> Edit</a></span>
        <span class="poll-card-action"><a href="#"><i class="fa fa-trash"></i> Delete</a></span>
        <span class="poll-card-action"><a href="#"><i class="fa fa-star"></i> Stars</a></span>
      </div>
    </div>
    <button class="button is-primary is-rounded floating-button">New group</button>
  </default-layout>
</template>

<script>
export default {
  components: {}
};
</script>

<style>
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}

.group-item-list {
  max-height: 200px;
  overflow: auto;
}

.delete-item {
  margin-right: 12px;
  float: right;
}
</style>
