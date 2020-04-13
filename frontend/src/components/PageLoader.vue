<template>
  <div class="progress" v-if="loading" >
    <div class="indeterminate"></div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["loading"])
  }
};
</script>
<style lang="scss" scoped>
    .progress {
        position: absolute;
        bottom: 0;
        overflow: hidden;
        margin: 0;
        height: 8px;
    }
</style>