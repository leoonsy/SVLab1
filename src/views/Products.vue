<template>
  <section id="section-products">
    <div>
      Продукты
    </div>
  </section>
</template>

<script>
import MainLayout from '@/layouts/MainLayout';
export default {
  name: 'Products',
  created() {
    this.$emit('update:layout', MainLayout);
  }
}
</script>