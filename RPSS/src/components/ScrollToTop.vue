<template>
  <button
    class="scroll-to-top"
    :class="{ 'visible': isVisible }"
    @click="scrollToTop"
  >
    <i class="fas fa-chevron-up"></i>
  </button>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
  name: 'ScrollToTop',
  setup() {
    const isVisible = ref(false)

    const handleScroll = () => {
      isVisible.value = window.scrollY > 500
    }

    const scrollToTop = () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      })
    }

    onMounted(() => {
      window.addEventListener('scroll', handleScroll)
    })

    onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll)
    })

    return {
      isVisible,
      scrollToTop
    }
  }
}
</script>