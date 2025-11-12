<template>
  <div class="preloader" :class="{ 'fade-out': !isVisible }">
    <div class="loader">
      <div class="flame">
        <div class="fire-particle"></div>
        <div class="fire-particle"></div>
        <div class="fire-particle"></div>
        <div class="fire-particle"></div>
      </div>
      <p>Загружаемся...</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'Preloader',
  setup() {
    const isVisible = ref(true)

    onMounted(() => {
      setTimeout(() => {
        isVisible.value = false
      }, 2000)
    })

    return {
      isVisible
    }
  }
}
</script>