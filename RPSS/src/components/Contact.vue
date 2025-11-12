<template>
  <section id="contacts" class="contact-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Свяжитесь с нами</h2>
        <p class="section-subtitle">Мы всегда готовы ответить на ваши вопросы</p>
      </div>
      <div class="contact-container">
        <div class="contact-info">
          <div class="contact-card">
            <h3><i class="fas fa-map-marker-alt"></i> Наш адрес</h3>
            <p>
              Республика Коми, Усинск р-н,<br>
              г. Усинск, Промышленная ул,<br>
              д. 19, офис 35 (2 этаж)
            </p>
          </div>
          <div class="contact-card">
            <h3><i class="fas fa-phone"></i> Телефоны</h3>
            <div class="phones">
              <a href="tel:+78214452041">+7(82144) 52-0-41</a>
              <a href="tel:+78214452051">+7(82144) 52-0-51</a>
              <a href="tel:+79129564474">8 912 95 644 74</a>
            </div>
          </div>
          <div class="contact-card">
            <h3><i class="fas fa-envelope"></i> Email</h3>
            <a href="mailto:rpss-2017@mail.ru">rpss-2017@mail.ru</a>
          </div>
          <div class="contact-card">
            <h3><i class="far fa-clock"></i> Время работы</h3>
            <p>Пн-Пт: 8:30-17:00<br>Сб-Вс: выходные</p>
          </div>
          <div class="contact-card">
            <h3><i class="fas fa-truck"></i> Зона обслуживания</h3>
            <p>Мы работаем по Усинску и Усинскому району. Возможен выезд в другие районы Республики Коми для крупных объектов.</p>
          </div>
        </div>
        <div class="contact-form-wrapper">
          <div class="contact-form-card">
            <h3>Оставьте заявку</h3>
            <p>Мы перезвоним вам в течение рабочего дня</p>
            <div :class="['form-message', messageType]" v-if="showMessage">
              {{ messageText }}
            </div>
            <form @submit.prevent="submitForm">
              <div class="form-group">
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  placeholder=" "
                  required
                >
                <label for="name">Ваше имя *</label>
                <div class="error-message" v-if="errors.name">{{ errors.name }}</div>
              </div>

              <div class="form-group">
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  placeholder=" "
                  required
                >
                <label for="phone">Ваш телефон *</label>
                <div class="error-message" v-if="errors.phone">{{ errors.phone }}</div>
              </div>

              <div class="form-group">
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  placeholder=" "
                >
                <label for="email">Ваш e-mail</label>
                <div class="error-message" v-if="errors.email">{{ errors.email }}</div>
              </div>

              <div class="form-group">
                <select id="object_type" v-model="form.object_type" required>
                  <option value="" disabled selected></option>
                  <option value="apartment">Квартира</option>
                  <option value="house">Частный дом</option>
                  <option value="office">Офис</option>
                  <option value="commercial">Коммерческое помещение</option>
                  <option value="other">Другое</option>
                </select>
                <label for="object_type">Тип объекта *</label>
                <div class="error-message" v-if="errors.object_type">{{ errors.object_type }}</div>
              </div>

              <div class="form-group">
                <textarea
                  id="message"
                  v-model="form.message"
                  placeholder=" "
                  rows="4"
                ></textarea>
                <label for="message">Сообщение</label>
              </div>

              <button type="submit" class="btn-form" :disabled="loading">
                <i class="fas fa-paper-plane"></i>
                {{ loading ? 'Отправка...' : 'Отправить заявку' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref, reactive } from 'vue'

export default {
  name: 'Contact',
  setup() {
    const form = reactive({
      name: '',
      phone: '',
      email: '',
      object_type: '',
      message: ''
    })

    const errors = reactive({})
    const loading = ref(false)
    const showMessage = ref(false)
    const messageText = ref('')
    const messageType = ref('')

    const validateEmail = (email) => {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    }

    const validatePhone = (phone) => {
      const cleaned = phone.replace(/[^\d+]/g, '')
      const digits = cleaned.replace(/\D/g, '')
      return digits.length >= 10 && digits.length <= 15
    }

    const validateForm = () => {
      // Clear previous errors
      Object.keys(errors).forEach(key => delete errors[key])

      // Name validation
      if (!form.name.trim()) {
        errors.name = 'Пожалуйста, введите ваше имя'
      } else if (form.name.trim().length < 2) {
        errors.name = 'Имя должно содержать минимум 2 символа'
      }

      // Phone validation
      if (!form.phone.trim()) {
        errors.phone = 'Пожалуйста, введите номер телефона'
      } else if (!validatePhone(form.phone)) {
        errors.phone = 'Пожалуйста, введите корректный номер телефона'
      }

      // Email validation
      if (form.email && !validateEmail(form.email)) {
        errors.email = 'Пожалуйста, введите корректный email'
      }

      // Object type validation
      if (!form.object_type) {
        errors.object_type = 'Пожалуйста, выберите тип объекта'
      }

      return Object.keys(errors).length === 0
    }

    const showNotification = (text, type = 'success') => {
      messageText.value = text
      messageType.value = type
      showMessage.value = true

      setTimeout(() => {
        showMessage.value = false
      }, 5000)
    }

    const submitForm = async () => {
      if (!validateForm()) {
        showNotification('Пожалуйста, исправьте ошибки в форме', 'error')
        return
      }

      loading.value = true

      try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 2000))

        // Here you would normally send data to your backend
        console.log('Form data:', form)

        showNotification('Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.', 'success')

        // Reset form
        Object.keys(form).forEach(key => {
          form[key] = ''
        })
      } catch (error) {
        showNotification('Ошибка при отправке заявки. Пожалуйста, попробуйте еще раз.', 'error')
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      errors,
      loading,
      showMessage,
      messageText,
      messageType,
      submitForm
    }
  }
}
</script>