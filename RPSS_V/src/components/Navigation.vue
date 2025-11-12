<template>
  <nav class="nav" :class="{ 'active': isOpen }" :aria-hidden="!isOpen">
    <div class="container">
      <ul class="nav-links">
        <li><a href="#services" @click="handleLinkClick"><i class="fas fa-tools"></i> Услуги</a></li>
        <li><a href="#advantages" @click="handleLinkClick"><i class="fas fa-star"></i> Преимущества</a></li>
        <li><a href="#process" @click="handleLinkClick"><i class="fas fa-play-circle"></i> Как мы работаем</a></li>
        <li><a href="#contacts" @click="handleLinkClick"><i class="fas fa-envelope"></i> Контакты</a></li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navigation',
  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  },
  emits: ['close'],
  setup(props, { emit }) {
    const handleLinkClick = () => {
      emit('close')
    }

    return {
      handleLinkClick
    }
  }
}
</script>