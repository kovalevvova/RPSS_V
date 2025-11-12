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

            <!-- Сообщения о статусе отправки -->
            <div
              v-if="showMessage"
              class="form-message"
              :class="messageType"
            >
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
                  :disabled="loading"
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
                  :disabled="loading"
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
                  :disabled="loading"
                >
                <label for="email">Ваш e-mail</label>
                <div class="error-message" v-if="errors.email">{{ errors.email }}</div>
              </div>

              <div class="form-group">
                <select
                  id="object_type"
                  v-model="form.object_type"
                  required
                  :disabled="loading"
                >
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
                  :disabled="loading"
                ></textarea>
                <label for="message">Сообщение</label>
              </div>

              <button
                type="submit"
                class="btn-form"
                :disabled="loading"
                :class="{ 'loading': loading }"
              >
                <template v-if="loading">
                  <i class="fas fa-spinner fa-spin"></i>
                  Отправка...
                </template>
                <template v-else>
                  <i class="fas fa-paper-plane"></i>
                  Отправить заявку
                </template>
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

    // URL сервера - измените на ваш домен после деплоя
   // В компоненте Contact.vue
const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:3000'

    const validateEmail = (email) => {
      if (!email) return true // email не обязателен
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    }

    const validatePhone = (phone) => {
      const cleaned = phone.replace(/[^\d+]/g, '')
      const digits = cleaned.replace(/\D/g, '')
      return digits.length >= 10 && digits.length <= 15
    }

    const validateForm = () => {
      // Очищаем предыдущие ошибки
      Object.keys(errors).forEach(key => delete errors[key])

      // Валидация имени
      if (!form.name.trim()) {
        errors.name = 'Пожалуйста, введите ваше имя'
      } else if (form.name.trim().length < 2) {
        errors.name = 'Имя должно содержать минимум 2 символа'
      }

      // Валидация телефона
      if (!form.phone.trim()) {
        errors.phone = 'Пожалуйста, введите номер телефона'
      } else if (!validatePhone(form.phone)) {
        errors.phone = 'Пожалуйста, введите корректный номер телефона'
      }

      // Валидация email
      if (form.email && !validateEmail(form.email)) {
        errors.email = 'Пожалуйста, введите корректный email'
      }

      // Валидация типа объекта
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
        const response = await fetch(`${API_URL}/api/send-message`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: form.name.trim(),
            phone: form.phone.trim(),
            email: form.email.trim(),
            service: form.object_type, // переименовываем для сервера
            message: form.message.trim(),
            object_type: form.object_type // дублируем для ясности
          })
        })

        const result = await response.json()

        if (result.success) {
          showNotification('Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.', 'success')

          // Сбрасываем форму
          Object.keys(form).forEach(key => {
            form[key] = ''
          })
        } else {
          showNotification(result.message || 'Ошибка при отправке заявки', 'error')
        }

      } catch (error) {
        console.error('Ошибка отправки:', error)
        showNotification('Ошибка соединения с сервером. Пожалуйста, попробуйте еще раз или позвоните нам.', 'error')
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

<style scoped>
/* Дополнительные стили для состояния загрузки */
.btn-form.loading {
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-form:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.fa-spinner {
  margin-right: 8px;
}

.form-message {
  padding: 12px 15px;
  margin: 15px 0;
  border-radius: 8px;
  text-align: center;
  font-weight: 500;
  font-size: 0.9rem;
}

.form-message.success {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.form-message.error {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}
</style>