<template>
  <div id="app">
    <Preloader v-if="showPreloader" />

    <Header
      :isMenuOpen="isMobileMenuOpen"
      @toggle-menu="toggleMobileMenu"
    />
    <Navigation
      :isOpen="isMobileMenuOpen"
      @close="closeMobileMenu"
    />

    <main>
      <Hero />
      <Services />
      <Advantages />
      <Process />
      <CTA />
      <Contact />
    </main>

    <Footer />
    <ScrollToTop />
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import Preloader from './components/Preloader.vue'
import Header from './components/Header.vue'
import Navigation from './components/Navigation.vue'
import Hero from './components/Hero.vue'
import Services from './components/Services.vue'
import Advantages from './components/Advantages.vue'
import Process from './components/Process.vue'
import CTA from './components/CTA.vue'
import Contact from './components/Contact.vue'
import Footer from './components/Footer.vue'
import ScrollToTop from './components/ScrollToTop.vue'

export default {
  name: 'App',
  components: {
    Preloader,
    Header,
    Navigation,
    Hero,
    Services,
    Advantages,
    Process,
    CTA,
    Contact,
    Footer,
    ScrollToTop
  },
  setup() {
    const showPreloader = ref(true)
    const isMobileMenuOpen = ref(false)

    const toggleMobileMenu = () => {
      isMobileMenuOpen.value = !isMobileMenuOpen.value
      updateBodyClass()
    }

    const closeMobileMenu = () => {
      isMobileMenuOpen.value = false
      updateBodyClass()
    }

    const updateBodyClass = () => {
      if (isMobileMenuOpen.value) {
        document.body.classList.add('menu-open')
      } else {
        document.body.classList.remove('menu-open')
      }
    }

    // Закрытие меню при клике вне области
    const handleClickOutside = (event) => {
      const nav = document.querySelector('.nav')
      const menuBtn = document.querySelector('.mobile-menu-btn')

      if (nav && menuBtn &&
          !nav.contains(event.target) &&
          !menuBtn.contains(event.target) &&
          isMobileMenuOpen.value) {
        closeMobileMenu()
      }
    }

    // Закрытие меню при ресайзе на десктоп
    const handleResize = () => {
      if (window.innerWidth > 767 && isMobileMenuOpen.value) {
        closeMobileMenu()
      }
    }

    // Закрытие меню по Escape
    const handleEscape = (event) => {
      if (event.key === 'Escape' && isMobileMenuOpen.value) {
        closeMobileMenu()
      }
    }

    onMounted(() => {
      // Симуляция загрузки ресурсов
      setTimeout(() => {
        showPreloader.value = false
      }, 2000)

      // Добавляем обработчики
      document.addEventListener('click', handleClickOutside)
      window.addEventListener('resize', handleResize)
      document.addEventListener('keydown', handleEscape)
    })

    onUnmounted(() => {
      // Убираем обработчики
      document.removeEventListener('click', handleClickOutside)
      window.removeEventListener('resize', handleResize)
      document.removeEventListener('keydown', handleEscape)
      document.body.classList.remove('menu-open')
    })

    return {
      showPreloader,
      isMobileMenuOpen,
      toggleMobileMenu,
      closeMobileMenu
    }
  }
}
</script>
