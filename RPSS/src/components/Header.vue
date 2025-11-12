<template>
  <header class="header" :class="{ 'scrolled': isScrolled }">
    <div class="container">
      <div class="header-content">
        <div class="logo">
          <div class="logo-icon">
            <i class="fas fa-fire-extinguisher"></i>
          </div>
          <div class="logo-text">
            <h1>Региональная пожарно-спасательная служба</h1>
            <p>Надежная защита вашего имущества</p>
          </div>
        </div>
        <div class="contact-info">
          <div class="phone">
            <a href="tel:+78214452041" class="clickable-phone">
              <i class="fas fa-phone"></i>
              +7(82144) 52-0-41
            </a>
          </div>
          <div class="work-hours">
            <i class="far fa-clock"></i>
            Пн-Пт: 8:30-17:00, Сб-Вс: выходные
          </div>
        </div>
        <button
          class="mobile-menu-btn"
          @click="toggleMobileMenu"
          :class="{ 'active': isMenuOpen }"
          aria-label="Меню"
          :aria-expanded="isMenuOpen"
        >
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
  name: 'Header',
  props: {
    isMenuOpen: {
      type: Boolean,
      default: false
    }
  },
  emits: ['toggle-menu'],
  setup(props, { emit }) {
    const isScrolled = ref(false)

    const handleScroll = () => {
      isScrolled.value = window.scrollY > 100
    }

    const toggleMobileMenu = () => {
      emit('toggle-menu')
    }

    onMounted(() => {
      window.addEventListener('scroll', handleScroll)
    })

    onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll)
    })

    return {
      isScrolled,
      toggleMobileMenu
    }
  }
}
</script>