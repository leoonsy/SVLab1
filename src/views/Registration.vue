<template>
  <section id="section-registration">
    <div>
      Регистрация
    </div>
  </section>
</template>

<script>
import EmptyLayout from '@/layouts/EmptyLayout';
export default {
  name: 'Registration',
  created() {
    this.$emit('update:layout', EmptyLayout);
  }
}
</script>