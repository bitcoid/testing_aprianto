<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container>
      <q-responsive>
        <div class="rounded-borders"> 
             <router-view/>  
        </div>
      </q-responsive>
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: "defaultlayout"
};
</script>
